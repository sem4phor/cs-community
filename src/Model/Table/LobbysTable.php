<?php
namespace App\Model\Table;

use App\Model\Entity\Lobby;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Lobbys Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Lobbies
 * @property \Cake\ORM\Association\BelongsToMany $Users
 */
class LobbysTable extends Table
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

        $this->table('lobbys');
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
            'joinTable' => 'lobbys_users'
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
            ->add('owned_by', 'valid', ['rule' => 'numeric'])
            ->requirePresence('owned_by', 'create')
            ->notEmpty('owned_by');

        $validator
            ->add('free_slots', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('free_slots');

        $validator
            ->requirePresence('url', 'create')
            ->notEmpty('url');

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
