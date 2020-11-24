<?php

declare(strict_types=1);

namespace Guidance\Tests\Base;

class ProjectConfig
{
    /** @var \Guidance\Tests\Base\Lib\DataManipulation\ArrayWrapper */
    private $wrappedData = null;

    // ########################################

    public function __construct(\Guidance\Tests\Base\Lib\DataManipulation\ArrayWrapper $wrappedData)
    {
        $this->wrappedData = $wrappedData;
    }

    // ########################################

    public function get(string $key)
    {
        return $this->wrappedData->get($key);
    }

    // ########################################
}
