<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\Curl\Message;

class Headers
{
    /** @var array */
    private $headers = [];

    /** @var array */
    private $originalKeys = [];

    // ########################################

    public function __construct(array $headers)
    {
        $this->headers      = [];
        $this->originalKeys = [];

        foreach ($headers as $key => $value) {
            $lowerKey = strtolower($key);

            $this->headers[$lowerKey]      = $value;
            $this->originalKeys[$lowerKey] = $key;
        }
    }

    // ########################################

    public function getHeader(string $name)
    {
        return $this->headers[strtolower($name)];
    }

    public function hasHeader(string $name): bool
    {
        return isset($this->headers[strtolower($name)]);
    }

    public function getAll(): array
    {
        $originalHeaders = [];

        foreach ($this->headers as $key => $value) {
            $originalHeaders[$this->originalKeys[$key]] = $value;
        }

        return $originalHeaders;
    }

    // ########################################
}
