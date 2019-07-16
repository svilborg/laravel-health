<?php
namespace Health\Checks\Servers;

use Health\Checks\BaseCheck;
use Health\Checks\HealthCheckInterface;
use Health\Checks\Traits\HttpClientTrait;

class ElasticSearch extends BaseCheck implements HealthCheckInterface
{

    use HttpClientTrait;

    const DEFAULT_URL = "http://localhost:9200";

    /**
     *
     * {@inheritdoc}
     * @see \Health\Checks\HealthCheckInterface::call()
     */
    public function call()
    {
        $builder = $this->getBuilder();

        try {
            $uri = $this->getUri();

            /** @var \Psr\Http\Message\ResponseInterface $response */
            $response = $this->getHttpClient()->get($uri);

            $statusCode = $response->getStatusCode();
            $status = '';

            if ($response->getStatusCode() == 200) {
                $response = json_decode($response->getBody()->getContents());
                $status = $response->status ?? 'n/a';

                if ($status == 'green' || $status == 'yellow') {
                    $builder->up();
                } else {
                    $builder->down();
                }
            }

            $builder->withData('uri', $uri)
                ->withData('status', $status)
                ->withData('http_status', $statusCode);
        } catch (\Exception $exception) {
            $builder->down()->withData('error', $exception->getMessage());
        }

        return $builder->build();
    }

    /**
     * Get Cluster Health Uri
     *
     * @return string
     */
    private function getUri()
    {
        $uri = $this->params['uri'] ?? self::DEFAULT_URL;
        $uri = rtrim($uri, "/") . "/_cluster/health";

        return $uri;
    }
}