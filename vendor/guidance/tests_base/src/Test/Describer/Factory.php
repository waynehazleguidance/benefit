<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Test\Describer;

class Factory
{
    use \Guidance\Tests\Base\Object\FactoryTrait;

    /** @var \Guidance\Tests\Base\Object\ClassDescriber\Factory */
    private $classDescriberFactory = null;

    // ########################################

    public function __construct(\Guidance\Tests\Base\Object\ClassDescriber\Factory $classDescriberFactory)
    {
        $this->classDescriberFactory = $classDescriberFactory;
    }

    // ########################################

    public function create(\Guidance\Tests\Base\Test\BaseAbstract $test): \Guidance\Tests\Base\Test\Describer
    {
        return $this->di->make(\Guidance\Tests\Base\Test\Describer::class,
            [
                'reflectionClass' => new \ReflectionClass($test)
            ]
        );
    }

    // ########################################
}
