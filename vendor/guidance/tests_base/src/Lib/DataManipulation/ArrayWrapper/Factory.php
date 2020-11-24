<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\DataManipulation\ArrayWrapper;

class Factory
{
    use \Guidance\Tests\Base\Object\FactoryTrait;

    // ########################################

    public function create(array $data = []): \Guidance\Tests\Base\Lib\DataManipulation\ArrayWrapper
    {
        return $this->di->make(
            \Guidance\Tests\Base\Lib\DataManipulation\ArrayWrapper::class,
            [
                'data' => $data
            ]
        );
    }

    // ########################################
}
