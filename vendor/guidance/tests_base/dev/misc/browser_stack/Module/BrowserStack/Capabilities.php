<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Module\BrowserStack;

class Capabilities
{
    /** @var \Guidance\Tests\Base\Lib\DataManipulation\ArrayWrapper */
    private $wrappedCapabilities = null;

    // ########################################

    public function __construct(\Guidance\Tests\Base\Lib\DataManipulation\ArrayWrapper $wrappedCapabilities)
    {
        $this->wrappedCapabilities = $wrappedCapabilities;
    }

    // ########################################

    public function get(string $key)
    {
        return $this->wrappedCapabilities->get($key);
    }

    // ########################################
}
