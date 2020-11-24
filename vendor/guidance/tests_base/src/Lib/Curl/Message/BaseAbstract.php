<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\Curl\Message;

abstract class BaseAbstract
{
    /** @var \Guidance\Tests\Base\Lib\Curl\Message\Location */
    private $location = null;

    /** @var \Guidance\Tests\Base\Lib\Curl\Message\Headers */
    private $headers = null;

    /** @var \Guidance\Tests\Base\Lib\Curl\Message\Body|null */
    private $body = null;

    // ########################################

    public function __construct(
        Location $location,
        Headers $headers,
        ?Body $body
    ) {
        $this->location = $location;
        $this->headers  = $headers;
        $this->body     = $body;
    }

    // ########################################

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function getHeaders(): Headers
    {
        return $this->headers;
    }

    public function hasBody(): bool
    {
        return !is_null($this->body);
    }

    public function getBody(): Body
    {
        return $this->body;
    }

    // ########################################
}
