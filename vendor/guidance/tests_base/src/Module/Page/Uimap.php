<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Module\Page;

class Uimap
{
    /** @var \Guidance\Tests\Base\Lib\DataManipulation\ArrayWrapper */
    private $wrappedData = null;

    // ########################################

    public function __construct(\Guidance\Tests\Base\Lib\DataManipulation\ArrayWrapper $wrappedData)
    {
        $this->wrappedData = $wrappedData;
    }

    // ########################################

    public function getSelector(string $key = '/')
    {
        return $this->wrappedData->get('/uimap' . $key);
    }

    public function getPath()
    {
        return $this->wrappedData->get('/path/');
    }

    public function getTitle()
    {
        $titleData = $this->wrappedData->get('/title/');

        if (is_string($titleData) && strpos($titleData, ' / ') !== false) {
            return explode(' / ', trim($titleData));
        }

        return ! empty($titleData) ? $titleData : null;
    }

    // ########################################
}
