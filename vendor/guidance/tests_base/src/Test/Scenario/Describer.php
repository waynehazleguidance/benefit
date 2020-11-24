<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Test\Scenario;

class Describer
{
    /** @var \Codeception\Scenario */
    private $scenario = null;

    /** @var \ReflectionObject */
    private $reflectionObject = null;

    // ########################################

    public function __construct(\Codeception\Scenario $scenario)
    {
        $this->scenario         = $scenario;
        $this->reflectionObject = new \ReflectionObject($scenario);
    }

    // ########################################

    public function getCurrentTestMethod(): string
    {
        /** @var \ReflectionProperty $reflectionProperty */
        $reflectionProperty = $this->reflectionObject->getProperty('metadata');
        $reflectionProperty->setAccessible(true);

        /** @var \Codeception\Test\Metadata $metadata */
        $metadata = $reflectionProperty->getValue($this->scenario);

        return $metadata->getName();
    }

    // ########################################
}
