<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Test\Scenario\Describer;

class Factory
{
    use \Guidance\Tests\Base\Object\FactoryTrait;

    // ########################################

    public function create(\Codeception\Scenario $scenario): \Guidance\Tests\Base\Test\Scenario\Describer
    {
        return $this->di->make(\Guidance\Tests\Base\Test\Scenario\Describer::class,
            [
                'scenario' => $scenario
            ]
        );
    }

    // ########################################
}
