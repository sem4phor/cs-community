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
        $this->belongsToMany('Users', [
            'foreignKey' => 'lobby_id',
            'targetForeignKey' => 'user_id',
            'joinTable' => 'lobbies_users'
        ]);
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
            ->integer('owned_by')
            ->requirePresence('owned_by', 'create')
            ->notEmpty('owned_by');

        $validator
            ->integer('free_slots')
            ->allowEmpty('free_slots');

        $validator
            ->requirePresence('url', 'create')
            ->notEmpty('url');

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
            ->allowEmpty('rank_to');

        $validator
            ->allowEmpty('rank_from');

        $validator
            ->integer('min_playtime')
            ->allowEmpty('min_playtime');

        $validator
            ->allowEmpty('language');

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
