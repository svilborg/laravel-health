<?php
namespace Health\Checks\Servers;

use Health\Checks\BaseCheck;
use Health\Checks\HealthCheckInterface;
use Illuminate\Support\Facades\Cache as CacheFacade;

class Cache extends BaseCheck implements HealthCheckInterface
{

    const DEFAULT_KEY = 'health-check';

    const DEFAULT_VALUE = 'health-check-value';

    const DEFAULT_MINUTES = 1;

    /**
     *
     * {@inheritdoc}
     * @see \Health\Checks\HealthCheckInterface::call()
     */
    public function call()
    {
        $builder = $this->getBuilder();

        $key = $this->getParam('key', self::DEFAULT_KEY);
        $value = $this->getParam('value', self::DEFAULT_VALUE);
        $minutes = $this->getParam('minutes', self::DEFAULT_MINUTES);

        try {
            $result = CacheFacade::add($key, $value, $minutes);

            if ($result) {
                $valueCached = CacheFacade::get($key);

                if ($valueCached !== $value) {
                    $builder->down()->withData("error", "Value  mismatch.");
                }
            } else {
                $builder->down()->withData("error", "Could not add key.");
            }

            CacheFacade::delete($key);
        } catch (\Exception $exception) {
            $builder->down()->withData("error", "Cache Error - " . $exception->getMessage());
        }

        return $builder->build();
    }
}