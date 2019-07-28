<?php
namespace Health\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository as Config;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Helper\TableSeparator;
use Health\Services\HealthService;
use Health\Health;
use Health\HealthCheck;

/**
 * Health Command
 */
class HealthCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'health';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Health Check.';

    /**
     * Configuration repository.
     *
     * @var Config
     */
    protected $config;

    /**
     *
     * @var HealthService
     */
    private $healthService;

    /**
     * Create a new command instance.
     *
     * @param \Illuminate\Contracts\Config\Repository $config
     * @return void
     */
    public function __construct(Config $config, HealthService $healthService)
    {
        $this->config = $config;
        $this->healthService = $healthService;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $health = $this->healthService->getHealth($this->config->get('health.checks'));

        $this->output($health->getState(), 'Health State');
        $this->line('');

        $statusCode = $health->isOk();
        foreach ($health->getChecks() as $check) {

            $this->output($check->getState(), $check->getName(), $check->getData());
            // $this->output($check->getState(), json_encode($check->getData()));
        }
    }

    /**
     * Write a string as standard output.
     *
     * @param string $string
     * @param string $style
     * @param int|string|null $verbosity
     * @return void
     */
    public function line($string, $style = null, $verbosity = null)
    {
        $styled = $style ? "<$style>$string</$style>" : $string;

        $this->output->writeln($styled, $this->parseVerbosity($verbosity));
    }

    /**
     * Output based on pipline/job status
     *
     * @param string $status
     * @param string $name
     * @param mixed $data
     */
    private function output(string $status, string $name, $data = null)
    {
        $this->line($this->formattedOutput($status, $name, $data));
    }

    /**
     * Output based on pipline/job status
     *
     * @param string $status
     * @param string $name
     * @param mixed $data
     */
    private function formattedOutput(string $status, string $name, $data = null)
    {
        $data = $data ? json_encode($data) : '';

        if ($status == HealthCheck::STATE_UP) {
            $result = '<info>✔ ' . $name . '</info> ' . $data;
        } else {
            $result = '<error>✖ ' . $name . '</error> ' . $data;
        }

        return $result;
    }
}