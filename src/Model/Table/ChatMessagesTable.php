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
 * ChatMessages Model
 *
 * @author Valentin Rapp
 *
 */
class ChatMessagesTable extends Table
{

    /**
     * Initialize method
     *
     * Configures the associations and other model properties. Sender is the user who sent the chatMessage
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('chat_messages');
        $this->displayField('message_id');
        $this->primaryKey('message_id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ChatMessages', [
            'foreignKey' => 'message_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Sender', [
            'className' => 'Users',
            'bindingKey' => 'steam_id',
            'foreignKey' => 'sent_by'// own table
        ]);
    }

    /**
     * Default validation rules.
     *
     * Validates that sent_by and message fields are present on creation and that a message can only be 200 characters long.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->requirePresence('sent_by', 'create')
            ->notEmpty('sent_by');

        $validator
            ->requirePresence('message', 'create')
            ->add('message', 'maxLength', [
                'rule' => ['maxLength', 200],
                'message' => __('Message too long.')
            ])
            ->notEmpty('message');

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
        $rules->add($rules->existsIn('message_id', 'ChatMessages'));
        return $rules;
    }
}
