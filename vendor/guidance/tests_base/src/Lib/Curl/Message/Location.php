<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\Curl\Message;

class Location
{
    public const PORT_HTTP  = 80;
    public const PORT_HTTPS = 443;

    /** @var string */
    private $scheme = null;

    /** @var string */
    private $host = null;

    /** @var integer */
    private $port = null;

    /** @var string */
    private $path = null;

    /** @var array */
    private $queryParameters = [];

    /** @var string|null */
    private $fragment = null;

    // ########################################

    public function __construct(
        string $scheme,
        string $host,
        int $port,
        string $path,
        array $queryParameters = [],
        ?string $fragment = null
    ) {
        $this->scheme          = $scheme;
        $this->host            = $host;
        $this->port            = $port;
        $this->path            = $path;
        $this->queryParameters = $queryParameters;
        $this->fragment        = $fragment;
    }

    // ########################################

    public function isSSL(): bool
    {
        return $this->scheme === 'https';
    }

    public function getScheme(): string
    {
        return $this->scheme;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getQueryParameters(): array
    {
        return $this->queryParameters;
    }

    public function getFragment(): ?string
    {
        return $this->fragment;
    }

    // ########################################
}
