<?php
namespace Tests\Checks;

use Health\Checks\Network\Http;

class HttpTest extends CheckTestCase
{

    public function testCheckUp()
    {
        $params = [
            'uri' => "https://google.com",
            'options' => [
                'verify' => true
            ]
        ];

        $check = $this->runCheck(Http::class, $params);

        // dump($check);

        $this->assertCheck($check, 'UP');
    }

    public function testCheckDownNoSuchDomain()
    {
        $params = [
            'uri' => "http://nosuchonesorry.com",
            'options' => [
                'verify' => true
            ]
        ];

        $check = $this->runCheck(Http::class, $params);

        $this->assertCheck($check, 'DOWN');
    }

    public function testCheckDownTimeout()
    {
        $params = [
            'uri' => "https://google.com",
            'options' => [
                'verify' => true,
                'timeout' => 0.1
            ]
        ];

        $check = $this->runCheck(Http::class, $params);

        $this->assertCheck($check, 'DOWN');
    }
}