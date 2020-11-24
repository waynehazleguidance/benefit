<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Module\DataSetProvider\Individual;

class Factory
{
    use \Guidance\Tests\Base\Object\FactoryTrait;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Object\ClassDescriber\Factory
     */
    private $classDescriberFactory = null;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Test\Describer\Factory
     */
    private $testDescriberFactory = null;

    // ########################################

    public function create($instance): \Guidance\Tests\Base\Module\DataSetProvider\Individual
    {
        if ($instance instanceof \Guidance\Tests\Base\Test\BaseAbstract) {
            $describer = $this->testDescriberFactory->create($instance);
        } else {
            $describer = $this->classDescriberFactory->create($instance);
        }

        return $this->di->make(
            \Guidance\Tests\Base\Module\DataSetProvider\Individual::class,
            [
                'describer' => $describer
            ]
        );
    }

    // ########################################
}
