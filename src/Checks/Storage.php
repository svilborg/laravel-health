<?php
namespace Health\Checks;

use Illuminate\Support\Facades\Storage as StorageFacade;

class Storage extends BaseCheck implements HealthCheckInterface
{

    /**
     *
     * {@inheritdoc}
     * @see \Health\Checks\HealthCheckInterface::call()
     */
    public function call()
    {
        $builder = $this->getBuilder();

        $name = $this->getParam('name');
        $file = $this->getParam('file', '/health.txt');

        $contents = $this->getParam('contents', random_bytes(32));
        $options = $this->getParam('options', []);

        try {
            StorageFacade::disk($name)->put($file, $contents, $options);

            $fileContents = StorageFacade::disk($name)->get($file);

            if ($contents !== $fileContents) {
                $builder->down()->withData('error', 'Contents mismatch');
            }

            if (! StorageFacade::disk($name)->delete($file)) {
                $builder->down()->withData('error', 'Could not delete file');
            }
        } catch (\Exception $exception) {
            $builder->down()->withData('error', $exception->getMessage());
        }

        $builder->withData('name', $name)
            ->withData('file', $file)
            ->withData('contents', $contents);

        return $builder->build();
    }
}
