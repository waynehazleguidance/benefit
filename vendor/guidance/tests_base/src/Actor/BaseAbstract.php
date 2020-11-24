<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Actor;

class BaseAbstract extends \Codeception\Actor
{
    use SharedLib;

    // ########################################

    public function __construct(\Codeception\Scenario $scenario)
    {
        parent::__construct($scenario);

        $di = \Guidance\Tests\Base\RuntimeContainer::getDi();

        $di->injectOn($this);

        \Guidance\Tests\Base\RuntimeContainer::setActor($this);
    }

    // ########################################
}
