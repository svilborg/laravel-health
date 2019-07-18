<?php
namespace Health\Checks\Cli;

use Health\Checks\BaseCheck;
use Health\Checks\HealthCheckInterface;
use Symfony\Component\Process\Process;

class Exec extends BaseCheck implements HealthCheckInterface
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
            $result = $data['result'] ?? null;
            $dir = $data['dir'] ?? null;
            $timeout = $data['timeout'] ?? 5;

            $process = new Process($command, $dir);
            $process->run();

            if ($timeout) {
                $process->setTimeout($timeout);
            }

            $output = $process->getOutput();

            if (! $process->isSuccessful()) {
                $builder->down();
            } elseif ($result && ! preg_match("|{$result}|", $output)) {
                $builder->down();
            }
        }

        return $builder->build();
    }
}
