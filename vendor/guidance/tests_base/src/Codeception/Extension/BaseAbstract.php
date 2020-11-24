<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Codeception\Extension;

abstract class BaseAbstract extends \Codeception\Extension
{
    // ########################################

    public function __construct($config, $options)
    {
        parent::__construct($config, $options);

        $di = \Guidance\Tests\Base\RuntimeContainer::getDi();

        $di->injectOn($this);
    }

    // ########################################
}
