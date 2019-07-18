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
            $params = $data['params'] ?? [];
            $result = $data['result'] ?? null;
            $dir = $data['dir'] ?? null;
            $timeout = $data['timeout'] ?? 5;

            $params = ! is_array($params) ? [
                $params
            ] : $params;

            $process = new Process($command);
            $process->run();

            if ($timeout) {
                $process->setTimeout($timeout);
            }

            if ($dir) {
                $process->setWorkingDirectory($dir);
            }

            $output = $process->getOutput();

            if (! $process->isSuccessful()) {
                $builder->down();
            } else if ($result && ! preg_match("|{$result}|", $output)) {
                $builder->down();
            }
        }

        return $builder->build();
    }
}