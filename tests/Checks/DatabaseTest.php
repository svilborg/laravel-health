<?php
namespace Tests\Checks;

use Health\Checks\Servers\Database;

class DatabaseTest extends CheckTestCase
{

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => ''
        ]);
    }

    public function testCheckDown()
    {
        $this->assertCheck($this->runCheck(Database::class), 'UP');
    }
}