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
        $app['config']->set('database.redis.client', 'phpredis');
    }

    public function testCheckUp()
    {
        $this->assertCheck($this->runCheck(Redis::class), 'DOWN');
    }
}