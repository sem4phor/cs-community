<?php
namespace App\Model\Table;

use App\Model\Entity\ChatMessage;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ChatMessages Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Messages
 */
class ChatMessagesTable extends Table
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
            'foreignKey' => 'sent_by'// own table
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
            ->requirePresence('sent_by', 'create')
            ->notEmpty('sent_by');

        $validator
            ->requirePresence('message', 'create')
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
        $rules->add($rules->existsIn(['message_id'], 'ChatMessages'));
        return $rules;
    }
}
