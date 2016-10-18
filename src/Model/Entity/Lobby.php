<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Lobby Entity.
 *
 * @property int $lobby_id
 * @property \App\Model\Entity\Lobby $lobby
 * @property int $owned_by
 * @property int $free_slots
 * @property string $url
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\User[] $users
 */
class Lobby extends Entity
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
        'lobby_id' => false,
    ];
}
