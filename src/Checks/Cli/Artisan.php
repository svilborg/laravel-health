<?php
namespace Health\Checks\Cli;

use Health\Checks\BaseCheck;
use Health\Checks\HealthCheckInterface;
use Illuminate\Support\Facades\Artisan as ArtisanFacade;

class Artisan extends BaseCheck implements HealthCheckInterface
{

    /**
     *
     * {@inheritdoc}
     * @see \Health\Checks\HealthCheckInterface::call()
     */
    public function call()
    {
        $builder = $this->getBuilder();

        $commands = $this->getParam('commands', []);

        foreach ($commands as $command => $data) {
            $params = $data['params'] ?? [];
            $result = $data['result'] ?? null;

            $params = ! is_array($params) ? [
                $params
            ] : $params;

            try {
                ArtisanFacade::call($command, $params);

                $output = ArtisanFacade::output();

                if ($output) {
                    if ($result && ! preg_match("|{$result}|", $output)) {
                        $builder->down();
                    }
                } else {
                    $builder->down();
                }
            } catch (\Exception $e) {
                $builder->down()->withData('error', $e->getMessage());
            }
        }

        return $builder->build();
    }
}
