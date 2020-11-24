<?php

declare(strict_types=1);

namespace  Guidance\Tests\Base\Lib\Curl\Message\Headers;

class Factory
{
    use \Guidance\Tests\Base\Object\FactoryTrait;

    // ########################################

    public function create(array $headers): \Guidance\Tests\Base\Lib\Curl\Message\Headers
    {
        return $this->di->make(\Guidance\Tests\Base\Lib\Curl\Message\Headers::class, ['headers' => $headers]);
    }

    // ########################################
}
