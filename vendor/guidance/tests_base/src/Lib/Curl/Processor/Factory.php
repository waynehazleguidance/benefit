<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\Curl\Processor;

class Factory
{
    use \Guidance\Tests\Base\Object\FactoryTrait;

    // ########################################

    public function create(): \Guidance\Tests\Base\Lib\Curl\Processor
    {
        return $this->di->make(\Guidance\Tests\Base\Lib\Curl\Processor::class);
    }

    // ########################################
}
