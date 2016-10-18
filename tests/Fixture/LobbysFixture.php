<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LobbysFixture
 *
 */
class LobbysFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'lobby_id' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'owned_by' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'free_slots' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => '4', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'url' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'owned_by' => ['type' => 'index', 'columns' => ['owned_by'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['lobby_id'], 'length' => []],
            'lobbys_ibfk_1' => ['type' => 'foreign', 'columns' => ['owned_by'], 'references' => ['users', 'user_id'], 'update' => 'restrict', 'delete' => 'cascade', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'lobby_id' => 1,
            'owned_by' => 1,
            'free_slots' => 1,
            'url' => 'Lorem ipsum dolor sit amet',
            'created' => '2016-10-18 13:02:59',
            'modified' => '2016-10-18 13:02:59'
        ],
    ];
}
