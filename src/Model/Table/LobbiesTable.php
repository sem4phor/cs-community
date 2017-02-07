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

/**
 * Lobbies Model
 *
 * @author Valentin Rapp
 *
 */
class LobbiesTable extends Table
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

        $this->table('lobbies');
        $this->displayField('lobby_id');
        $this->primaryKey('lobby_id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Lobbies', [
            'foreignKey' => 'lobby_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Users', [
            'foreignKey' => 'lobby_id'
        ]);
        $this->belongsTo('Owner', [
            'className' => 'Users',
            'foreignKey' => 'owner_id'
        ]);
        $this->belongsTo('RankFrom', [
            'className' => 'Ranks',
            'propertyName' => 'RankFrom',
            'foreignKey' => 'rank_from'
        ]);
        $this->belongsTo('RankTo', [
            'className' => 'Ranks',
            'propertyName' => 'RankTo',
            'foreignKey' => 'rank_to'
        ]);
    }

    /**
     * isOwnedBy method
     *
     * Returns true if the lobby with the provided id is owned by the user with the provided id.
     *
     * @param int $lobby_id The ID of a lobby.
     * @param int $steam_id The ID of a user.
     * @return boolean true|false
     */
    public function isOwnedBy($lobby_id, $steam_id)
    {
        return $this->exists(['lobby_id' => $lobby_id, 'owner_id' => $steam_id]);
    }

    /**
     * rankFromHasToBeSmallerOrEqualToRankTo method
     *
     * This is a validation method. It ensures that the entered rankFrom is lower than the rankTo.
     *
     * @param int $value The entered value for the rankFrom field
     * @param array $context The submitted lobby as an array
     * @return boolean true|false
     */
    public function rankFromHasToBeSmallerOrEqualToRankTo($value, array $context)
    {
        return $value <= $context['data']['rank_to'];
    }

    /**
     * rankToHasToBeBiggerOrEqualToRankFrom method
     *
     * This is a validation method. It ensures that the entered rankTo is bigger or equal the rankFrom.
     *
     * @param int $value The entered value for the rankTo field
     * @param array $context The submitted lobby as an array
     * @return boolean true|false
     */
    public function rankToHasToBeBiggerOrEqualToRankFrom($value, array $context)
    {
        return $value >= $context['data']['rank_from'];
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
            ->integer('owner_id')
            ->requirePresence('owner_id', 'create')
            ->notEmpty('owner_id');

        $validator
            ->integer('free_slots')
            ->requirePresence('free_slots', 'create')
            ->add('free_slots', [
                'equalTo' => ['rule' => ['equalTo' => 5]]
            ]);

        $validator
            ->requirePresence('url', 'create')
            ->add('url', [
                'validFormat' => ['rule' => ['custom', '/(steam:\/\/joinlobby\/[0-9]*\/[0-9]*\/[0-9]*)/i'],
                    'message' => __('Please enter a valid lobby url')
                ]
            ])
            ->notEmpty('url');

        $validator
            ->allowEmpty('teamspeak_ip')
            ->add('teamspeak_ip', [
                'validFormat' => ['rule' => ['custom', '/([0-9]+(?:\.[0-9]+){3}(:[0-9]+)*|([a-zA-Z0-9]+\.)+[a-zA-Z0-9]+(:[0-9]+)*)/i'],
                    'message' => __('Please enter a valid teamspeak ip or hostname')
                ]
            ]);

        $validator
            ->integer('rank_to')
            ->requirePresence('rank_to', 'create')
            ->add('rank_to', 'rankToHasToBeBiggerOrEqualToRankFrom', [
                'rule' => 'rankToHasToBeBiggerOrEqualToRankFrom',
                'message' => __('Ending rank has to be bigger or equal than the starting rank!'),
                'provider' => 'table',
            ])
            ->notEmpty('rank_to');

        $validator
            ->integer('rank_from')
            ->requirePresence('rank_from', 'create')
            ->add('rank_from', 'rankFromHasToBeSmallerOrEqualToRankTo', [
                'rule' => 'rankFromHasToBeSmallerOrEqualToRankTo',
                'message' => __('Starting rank has to be lower or equal than the ending rank!'),
                'provider' => 'table',
            ])
            ->notEmpty('rank_from');

        $validator
            ->requirePresence('language', 'create')
            ->notEmpty('language');

        $validator
            ->boolean('microphone_req')
            ->allowEmpty('microphone_req');

        $validator
            ->integer('min_age')
            ->allowEmpty('min_age');

        $validator
            ->boolean('teamspeak_req')
            ->allowEmpty('teamspeak_req');

        $validator
            ->boolean('prime_req')
            ->allowEmpty('prime_req');

        $validator
            ->integer('min_playtime')
            ->allowEmpty('min_playtime');
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
        $rules->add($rules->existsIn(['lobby_id'], 'Lobbies'));
        return $rules;
    }
}
