<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Continents Model
 *
 * @method \App\Model\Entity\Continent get($primaryKey, $options = [])
 * @method \App\Model\Entity\Continent newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Continent[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Continent|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Continent patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Continent[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Continent findOrCreate($search, callable $callback = null)
 */
class ContinentsTable extends Table
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

        $this->hasMany('Countries', [
            'foreignKey' => 'code'
        ]);

        $this->table('continents');
        $this->displayField('name');
        $this->primaryKey('code');
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
            ->allowEmpty('code', 'create');

        $validator
            ->allowEmpty('name');

        return $validator;
    }
}