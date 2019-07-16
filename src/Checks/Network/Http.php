<?php
namespace Health\Checks\Network;

use Health\Checks\BaseCheck;
use Health\Checks\HealthCheckInterface;
use Health\Checks\Traits\HttpClientTrait;

class Http extends BaseCheck implements HealthCheckInterface
{

    use HttpClientTrait;

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
            $options = $this->params['options'] ?? [];
            $method = isset($this->params['method']) ? strtoupper($this->params['method']) : 'GET';

            /** @var \Psr\Http\Message\ResponseInterface $response */
            $response = $this->getHttpClient()->request($method, $uri, $options);

            $statusCode = $response->getStatusCode();

            $up = ($statusCode >= 200 && $statusCode < 300) ? true : false;

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