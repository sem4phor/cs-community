<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LobbysTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LobbysTable Test Case
 */
class LobbysTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LobbysTable
     */
    public $Lobbys;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.lobbys',
        'app.lobbies',
        'app.users',
        'app.lobbys_users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Lobbys') ? [] : ['className' => 'App\Model\Table\LobbysTable'];
        $this->Lobbys = TableRegistry::get('Lobbys', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Lobbys);

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
