<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LobbiesUser Entity
 *
 * @property int $lobbies_users_id
 * @property int $lobby_id
 * @property int $user_id
 *
 * @property \App\Model\Entity\LobbiesUser $lobbies_user
 * @property \App\Model\Entity\Lobby $lobby
 * @property \App\Model\Entity\User $user
 */
class LobbiesUser extends Entity
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
        'lobbies_users_id' => false
    ];
}
