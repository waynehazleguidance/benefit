<?php

declare(strict_types=1);

namespace Guidance\Tests\Project\Test;

/**
 * @method \Guidance\Tests\Project\Actor getActor()
 */
class BaseAbstract extends \Guidance\Tests\Base\Test\BaseAbstract
{
    // ########################################

    protected function _beforeClass(): void
    {
        $I = $this->getActor();

        $I->retry(5, 200);
    }

    // ##########################################
}