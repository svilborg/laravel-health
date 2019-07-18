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
            $uri = $this->getParam('uri');
            $options = $this->getParam('options', []);
            $method = strtoupper($this->getParam('method', 'GET'));
            $status = $this->getParam('status', null);
            $result = $this->getParam('result', null);

            /** @var \Psr\Http\Message\ResponseInterface $response */
            $response = $this->getHttpClient()->request($method, $uri, $options);

            $statusCode = $response->getStatusCode();

            $up = ($statusCode >= 200 && $statusCode < 300) ? true : false;

            if ($status !== null) {
                $up = ($status == $statusCode);
            }

            if ($result !== null) {
                if (preg_match("|{$result}|", $response->getBody()->getContents())) {
                    $up = false;
                }
            }

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
