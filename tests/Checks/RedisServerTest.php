<?php
namespace Tests\Checks;

use Health\Checks\Servers\Redis;

class RedisServerTest extends CheckTestCase
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
    }

    public function testCheckUp()
    {
        if (getenv('SERVER_REDIS_ON') !== 'true') {
            $this->markTestSkipped('Redis Server is not enabled');
        }

        $this->assertCheck($this->runCheck(Redis::class), 'UP');
    }
}