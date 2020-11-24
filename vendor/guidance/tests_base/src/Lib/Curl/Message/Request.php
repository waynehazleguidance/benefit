<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\Curl\Message;

class Request extends BaseAbstract
{
    public const METHOD_GET    = 'GET';
    public const METHOD_POST   = 'POST';
    public const METHOD_PUT    = 'PUT';
    public const METHOD_PATCH  = 'PATCH';
    public const METHOD_DELETE = 'DELETE';
    public const METHOD_HEAD   = 'HEAD';
    public const METHOD_OPTION = 'OPTION';

    /** @var string */
    private $httpMethod = null;

    /** @var \Guidance\Tests\Base\Lib\Curl\Message\Request\ConnectionInfo */
    private $connectionInfo = null;

    /** @var array */
    private $cookies = [];

    // ########################################

    public function __construct(
        string $httpMethod,
        \Guidance\Tests\Base\Lib\Curl\Message\Request\ConnectionInfo $connectionInfo,
        \Guidance\Tests\Base\Lib\Curl\Message\Location $location,
        array $cookies,
        \Guidance\Tests\Base\Lib\Curl\Message\Headers $headers,
        ?\Guidance\Tests\Base\Lib\Curl\Message\Body $body
    ) {
        parent::__construct($location, $headers, $body);
        $this->httpMethod     = $httpMethod;
        $this->connectionInfo = $connectionInfo;
        $this->cookies        = $cookies;
    }

    // ########################################

    public function getConnectionInfo(): \Guidance\Tests\Base\Lib\Curl\Message\Request\ConnectionInfo
    {
        return $this->connectionInfo;
    }

    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    // ########################################

    public function getCookies(): array
    {
        return $this->cookies;
    }

    // ########################################
}
