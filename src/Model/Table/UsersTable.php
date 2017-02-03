<?php
namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Steams
 * @property \Cake\ORM\Association\BelongsTo $Roles
 * @property \Cake\ORM\Association\BelongsToMany $Lobbies
 */
class UsersTable extends Table
{

    /**
     * Initialize method
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

    public function isPartOfLobby($lobby_id, $steam_id)
    {
        return $this->exists(['steam_id' => $steam_id, 'lobby_id' => $lobby_id]);
    }

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

// if user not i ndb register him
    public function register($steam_id = null)
    {
        $newUser = $this->newEntity();
        $newUser->steam_id = $steam_id;
        $this->save($newUser);
    }

// adds steamdata to user
// loccountrycode is set to false if not set
// returns 0 if prof. private; retrun 1 if no country set else return true
    public
    function updateSteamData($steamId)
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
