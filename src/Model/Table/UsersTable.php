<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;

/**
 * Users Model
 *
 * @author Valentin Rapp
 *
 */
class UsersTable extends Table
{

    /**
     * Initialize method
     *
     * Configures the associations and other model properties.
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('users');
        $this->displayField('personaname');
        $this->primaryKey('steam_id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'steam_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id'
        ]);
        $this->belongsTo('Countries', [
            'foreignKey' => 'loccountrycode'
        ]);
        $this->belongsTo('Lobby', [
            'className' => 'Lobbies',
            'foreignKey' => 'lobby_id'
        ]);
        $this->hasMany('ChatMessages', [
            'foreignKey' => 'message_id',
            'dependent' => true,
            'bindingKey' => 'steam_id'
        ]);

    }

    /**
     * isPartOfLobby method
     *
     * Checks if a user with the provided id is part of the lobby with the provided id.
     *
     * @param int $lobby_id Lobby ID
     * @param int $steam_id Steam ID
     * @return bool
     */
    public function isPartOfLobby($lobby_id, $steam_id)
    {
        return $this->exists(['steam_id' => $steam_id, 'lobby_id' => $lobby_id]);
    }

    /**
     * getRegionCode method
     *
     * get the continent ode of the provided user
     *
     * @param int $user_id ID of the user to get the code of.
     * @return string $continent_code
     */
    public function getRegionCode($user_id)
    {
        return $this->find()->where(['steam_id =' => $user_id])->contain(['Countries.Continents'])->toArray()[0]->country->continent->code;
    }


    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmpty('steam_id')
            ->add('steam_id', 'numeric', [
                'rule' => ['numeric'],
                'message' => 'No valid steam_id.'
            ]);
        $validator
            ->notEmpty('playtime')
            ->add('playtime', 'numeric', [
                'rule' => ['numeric'],
                'message' => 'No valid playtime.'
            ]);
        $validator
            ->notEmpty('role_id');
        $validator
            ->notEmpty('loccountrycode');
        $validator
            ->add('playtime', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('playtime');
        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['steam_id'], 'Users'));
        $rules->add($rules->existsIn(['role_id'], 'Roles'));
        $rules->add($rules->existsIn(['lobby_id'], 'Lobby'));
        return $rules;
    }

    /**
     * register method
     *
     * Creates a new user with a provided steam ID as his Identifier.
     *
     * @param int steam_id
     * @return void
     */
    public function register($steam_id = null)
    {
        $newUser = $this->newEntity();
        $newUser->steam_id = $steam_id;
        $this->save($newUser);
    }

    /**
     * updateSteamData
     *
     * Fetches data from the steamprofile with the provided steam_id and saves it to the database.
     * Returns true if save was successfull and false if not
     * Returns 0 if the user has a private profile.
     * Returns 1 if the user has no country set in his profile.
     *
     * @param $steamId
     * @return bool|int
     */
    public function updateSteamData($steamId)
    {
        $user = $this->get($steamId);
        $url = file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=" . Configure::read('APIkey') . "&steamids=" . $steamId);
        $content = json_decode($url, true);
        //$user['steam_lastlogoff'] = $content['response']['players'][0]['lastlogoff'];
        $user->profileurl = $content['response']['players'][0]['profileurl'];
        $user->avatar = $content['response']['players'][0]['avatar'];
        $user->avatarmedium = $content['response']['players'][0]['avatarmedium'];
        $user->avatarfull = $content['response']['players'][0]['avatarfull'];
        $user->personastate = $content['response']['players'][0]['personastate'];
        $user->timecreated = $content['response']['players'][0]['timecreated'];
        $user->personaname = $content['response']['players'][0]['personaname'];

        $user['steam_profilestate'] = $content['response']['players'][0]['profilestate'];
        $user['steam_communityvisibilitystate'] = $content['response']['players'][0]['communityvisibilitystate'];
        if ($user['steam_communityvisibilitystate'] != 3 || $user['steam_profilestate'] != 1) {
            return 0;
        }
        $user['loccountrycode'] = $content['response']['players'][0]['loccountrycode'];
        if ($user['loccountrycode'] == false) {
            return 1;
        }
        if ($this->save($user)) {
            return true;
        } else {
            return false;
        }
    }
}
