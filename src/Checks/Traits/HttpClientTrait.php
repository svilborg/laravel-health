<?php
namespace Health\Checks\Traits;

use GuzzleHttp\Client;

/**
 * Http Client Instance
 */
trait HttpClientTrait
{

    /**
     *
     * @var Client
     */
    protected $client;

    /**
     *
     * @param Client $client
     */
    public function setHttpClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     *
     * @return \GuzzleHttp\Client
     */
    protected function getHttpClient()
    {
        if (! $this->client) {
            $this->client = new Client();
        }

        return $this->client;
    }
}