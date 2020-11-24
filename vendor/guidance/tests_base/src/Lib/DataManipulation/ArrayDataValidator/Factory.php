<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\DataManipulation\ArrayDataValidator;

class Factory
{
    // ########################################

    public function create(array $data): \Guidance\Tests\Base\Lib\DataManipulation\ArrayDataValidator
    {
        $di = \Guidance\Tests\Base\RuntimeContainer::getDi();
        return $di->make(
            \Guidance\Tests\Base\Lib\DataManipulation\ArrayDataValidator::class,
            ['data' => $data]
        );
    }

    // ########################################
}
