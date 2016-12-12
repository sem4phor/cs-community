<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LobbiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LobbiesTable Test Case
 */
class LobbiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LobbiesTable
     */
    public $Lobbies;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.lobbies',
        'app.users',
        'app.roles',
        'app.lobbys',
        'app.lobbys_users',
        'app.lobbies_users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Lobbies') ? [] : ['className' => 'App\Model\Table\LobbiesTable'];
        $this->Lobbies = TableRegistry::get('Lobbies', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Lobbies);

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
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
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
