<?php
namespace Health\Checks\Servers;

use Health\Checks\BaseCheck;
use Health\Checks\HealthCheckInterface;
use Solarium\Client;
use Solarium\Exception\ExceptionInterface;

class Solr extends BaseCheck implements HealthCheckInterface
{

    /**
     *
     * {@inheritdoc}
     * @see \Health\Checks\HealthCheckInterface::call()
     */
    public function call()
    {
        $builder = $this->getBuilder();

        $options = $this->getParam('options', null);

        try {
            $client = new Client($options);
        } catch (\Exception $e) {
            $builder->down()->withData("error", "Solr Client Error - " . $e->getMessage());
        }

        try {
            $ping = $client->createPing();
            $client->ping($ping);
        } catch (ExceptionInterface $e) {
            $builder->down()->withData("error", "Could not open connection to server - " . $e->getMessage());
        }

        return $builder->build();
    }
}
