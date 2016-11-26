<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Lobbies Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Lobbies
 * @property \Cake\ORM\Association\BelongsToMany $Users
 *
 * @method \App\Model\Entity\Lobby get($primaryKey, $options = [])
 * @method \App\Model\Entity\Lobby newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Lobby[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Lobby|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Lobby patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Lobby[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Lobby findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LobbiesTable extends Table
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

        $this->table('lobbies');
        $this->displayField('lobby_id');
        $this->primaryKey('lobby_id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Lobbies', [
            'foreignKey' => 'lobby_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Users', [
            'foreignKey' => 'lobby_id' // other table
        ]);
        $this->belongsTo('Owner', [
            'className' => 'Users',
            'foreignKey' => 'owner_id'// own table
        ]);
        $this->belongsTo('RankFrom', [
            'className' => 'Ranks',
            'propertyName' => 'RankFrom',
            'foreignKey' => 'rank_from'// own table
        ]);
        $this->belongsTo('RankTo', [
        'className' => 'Ranks',
            'propertyName' => 'RankTo',
        'foreignKey' => 'rank_to'// own table
    ]);
    }

    public function isOwnedBy($absenceId, $userId)
    {
        //return $this->exists(['absence_id' => $absenceId, 'user_id' => $userId]);
    }

    public function rankFromHasToBeSmallerOrEqualToRankTo($value, array $context)
    {
        return $value <= $context['data']['rank_to'];
    }

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
                    'equalTo' => ['rule' => ['equalTo' => 4]]
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

        $validator
            ->integer('min_upvotes')
            ->allowEmpty('min_upvotes');

        $validator
            ->integer('max_downvotes')
            ->allowEmpty('max_downvotes');

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
