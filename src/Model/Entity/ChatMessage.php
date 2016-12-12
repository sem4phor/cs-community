<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ChatMessage Entity.
 *
 * @property int $message_id
 * @property \App\Model\Entity\Message $message
 * @property int $sent_by
 * @property \Cake\I18n\Time $created
 */
class ChatMessage extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'message_id' => false,
    ];
}
