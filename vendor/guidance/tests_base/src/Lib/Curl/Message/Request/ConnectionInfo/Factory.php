<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\Curl\Message\Request\ConnectionInfo;

class Factory
{
    use \Guidance\Tests\Base\Object\FactoryTrait;

    // ########################################

    public function create(): \Guidance\Tests\Base\Lib\Curl\Message\Request\ConnectionInfo
    {
        return $this->di->make(\Guidance\Tests\Base\Lib\Curl\Message\Request\ConnectionInfo::class);
    }

    // ########################################
}
