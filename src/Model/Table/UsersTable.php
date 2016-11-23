<?php
namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

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
        $this->displayField('name');
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
            'foreignKey' => 'lobby_id'// own table
        ]);

    }

    public function getRegionCode($user_id) {
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
            ->allowEmpty('loccountrycode');


        $validator
            ->allowEmpty('rank');

        $validator
            ->add('upvotes', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('upvotes');

        $validator
            ->add('downvotes', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('downvotes');

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
        return $rules;
    }
}
