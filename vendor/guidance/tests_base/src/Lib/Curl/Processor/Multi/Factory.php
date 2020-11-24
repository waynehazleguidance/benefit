<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\Curl\Processor\Multi;

class Factory
{
    use \Guidance\Tests\Base\Object\FactoryTrait;

    // ########################################

    public function create(?int $maxRunTime = null): \Guidance\Tests\Base\Lib\Curl\Processor\Multi
    {
        return $this->di->make(\Guidance\Tests\Base\Lib\Curl\Processor\Multi::class, ['maxRunTime' => $maxRunTime]);
    }

    // ########################################
}
