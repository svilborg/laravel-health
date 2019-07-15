<?php
namespace Health\Checks\Network;

use GuzzleHttp\Client;
use Health\Checks\BaseCheck;
use Health\Checks\HealthCheckInterface;

class Http extends BaseCheck implements HealthCheckInterface
{

    /**
     *
     * @var Client
     */
    protected $client;

    /**
     *
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $this->params = $params;

        $this->client = new Client();
    }

    /**
     *
     * {@inheritdoc}
     * @see \Health\Checks\HealthCheckInterface::call()
     */
    public function call()
    {
        $builder = $this->getBuilder();

        try {
            $uri = $this->params['uri'];
            $options = $this->params['options'];
            $method = isset($this->params['method']) ? strtoupper($this->params['method']) : 'GET';

            /** @var \Psr\Http\Message\ResponseInterface $response */
            $response = $this->client->request($method, $uri, $options);

            $statusCode = $response->getStatusCode();

            $up = ($statusCode == 200) ? true : false;

            $builder->state($up)
                ->withData('uri', $uri)
                ->withData('status_code', $statusCode)
                ->withData('options', $options);
        } catch (\Exception $exception) {
            $builder->down()->withData('error', $exception->getMessage());
        }

        return $builder->build();
    }
}