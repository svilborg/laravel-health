<?php
namespace Health\Checks\File;

use Health\Checks\BaseCheck;

abstract class Base extends BaseCheck
{

    /**
     * List of files
     *
     * @var array
     */
    protected $files = [];

    /**
     *
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        parent::__construct($params);

        $this->files = $this->getParam('files', []);
    }

    /**
     *
     * {@inheritdoc}
     * @see \Health\Checks\HealthCheckInterface::call()
     */
    public function call()
    {
        $builder = $this->getBuilder();

        $errors = [];

        foreach ($this->files as $file) {
            if (! is_file($file) || ! $this->isValid($file)) {
                $errors[] = $file;
            }
        }

        if ($errors) {
            $builder->down()->withData('errors', $errors);
        }

        return $builder->withData('files', $this->files)->build();
    }

    /**
     *
     * @param string $file
     * @return boolean
     */
    abstract protected function isValid($file);
}
