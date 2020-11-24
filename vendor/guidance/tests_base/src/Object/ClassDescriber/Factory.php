<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Object\ClassDescriber;

class Factory
{
    use \Guidance\Tests\Base\Object\FactoryTrait;

    // ########################################

    public function create($instance): \Guidance\Tests\Base\Object\ClassDescriber
    {
        return $this->di->make(\Guidance\Tests\Base\Object\ClassDescriber::class,
            [
                'reflectionClass' => new \ReflectionClass($instance)
            ]
        );
    }

    // ########################################
}
