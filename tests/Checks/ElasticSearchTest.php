<?php
namespace Tests\Checks;

use Health\Checks\Servers\ElasticSearch;

// Guzzle
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;

class ElasticSearchTest extends CheckTestCase
{

    public function testCheckDown()
    {
        $check = $this->runCheck(ElasticSearch::class, []);

        $this->assertCheck($check, 'DOWN');
    }

    public function testCheckEmptyReponse()
    {
        $check = new ElasticSearch();
        $check->setHttpClient($this->getMockedClient(''));

        $health = $check->call();

        $this->assertCheck($health, 'DOWN');
        $this->assertEquals('n/a', $health->getData()['status']);
    }

    public function testCheckYellow()
    {
        $check = new ElasticSearch();
        $check->setHttpClient($this->getMockedClient($this->getYellowResponse()));

        $health = $check->call();

        $this->assertCheck($health, 'UP');
    }

    public function testCheckRed()
    {
        $check = new ElasticSearch();
        $check->setHttpClient($this->getMockedClient($this->getRedResponse()));

        $health = $check->call();

        $this->assertCheck($health, 'DOWN');
    }

    private function getMockedClient(string $response)
    {
        $mock = new MockHandler([
            new Response(200, [], $response)
        ]);

        return new Client([
            'handler' => HandlerStack::create($mock)
        ]);
    }

    private function getYellowResponse()
    {
        return '{
          "cluster_name" : "testcluster",
          "status" : "yellow",
          "timed_out" : false,
          "number_of_nodes" : 1,
          "number_of_data_nodes" : 1,
          "active_primary_shards" : 1,
          "active_shards" : 1,
          "active_shards_percent_as_number": 50.0
        }';
    }

    private function getRedResponse()
    {
        return '{
          "cluster_name" : "testcluster",
          "status" : "red",
          "timed_out" : false,
          "number_of_nodes" : 1,
          "number_of_data_nodes" : 1,
          "active_primary_shards" : 1,
          "active_shards" : 1,
          "relocating_shards" : 0,
          "initializing_shards" : 0,
          "unassigned_shards" : 1
        }';
    }
}