<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LobbiesUsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LobbiesUsersTable Test Case
 */
class LobbiesUsersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LobbiesUsersTable
     */
    public $LobbiesUsers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.lobbies_users',
        'app.lobbies',
        'app.users',
        'app.roles',
        'app.countries',
        'app.continents',
        'app.ranks'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('LobbiesUsers') ? [] : ['className' => 'App\Model\Table\LobbiesUsersTable'];
        $this->LobbiesUsers = TableRegistry::get('LobbiesUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LobbiesUsers);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
