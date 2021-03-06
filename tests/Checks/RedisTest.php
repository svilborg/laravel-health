<?php
namespace Tests\Checks;

use Health\Checks\Servers\Redis;

class RedisTest extends CheckTestCase
{

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.redis.client', 'predis');
        $app['config']->set('database.redis.default.host', '8.8.8.8');
    }

    public function testCheckUp()
    {
        $this->assertCheck($this->runCheck(Redis::class), 'DOWN');
    }
}