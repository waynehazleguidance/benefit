<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\Curl\Message;

class Body
{
    /** @var string */
    private $contentType = null;

    /** @var mixed */
    private $data = null;

    // ########################################

    public function __construct(string $contentType, $data)
    {
        $this->contentType = $contentType;
        $this->data        = $data;
    }

    // ########################################

    public function getContentType(): string
    {
        return $this->contentType;
    }

    public function getData()
    {
        return $this->data;
    }

    // ########################################
}
