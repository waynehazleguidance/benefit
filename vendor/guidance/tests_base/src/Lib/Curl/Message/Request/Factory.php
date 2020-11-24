<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\Curl\Message\Request;

class Factory
{
    use \Guidance\Tests\Base\Object\FactoryTrait;

    /** @var \Guidance\Tests\Base\Lib\Curl\Message\Headers\Factory */
    private $headersFactory = null;

    // ########################################

    public function __construct(\Guidance\Tests\Base\Lib\Curl\Message\Headers\Factory $headersFactory)
    {
        $this->headersFactory = $headersFactory;
    }

    // ########################################

    public function createGet(
        \Guidance\Tests\Base\Lib\Curl\Message\Request\ConnectionInfo $connectionInfo,
        \Guidance\Tests\Base\Lib\Curl\Message\Location $location,
        array $cookies = [],
        ?\Guidance\Tests\Base\Lib\Curl\Message\Headers $headers = null
    ): \Guidance\Tests\Base\Lib\Curl\Message\Request {
        return $this->create(
            \Guidance\Tests\Base\Lib\Curl\Message\Request::METHOD_GET,
            $connectionInfo,
            $location,
            $cookies,
            $headers,
            null
        );
    }

    public function createPost(
        \Guidance\Tests\Base\Lib\Curl\Message\Request\ConnectionInfo $connectionInfo,
        \Guidance\Tests\Base\Lib\Curl\Message\Location $location,
        \Guidance\Tests\Base\Lib\Curl\Message\Body $body,
        array $cookies = [],
        ?\Guidance\Tests\Base\Lib\Curl\Message\Headers $headers = null
    ): \Guidance\Tests\Base\Lib\Curl\Message\Request {
        return $this->create(
            \Guidance\Tests\Base\Lib\Curl\Message\Request::METHOD_POST,
            $connectionInfo,
            $location,
            $cookies,
            $headers,
            $body
        );
    }

    public function createPut(
        \Guidance\Tests\Base\Lib\Curl\Message\Request\ConnectionInfo $connectionInfo,
        \Guidance\Tests\Base\Lib\Curl\Message\Location $location,
        \Guidance\Tests\Base\Lib\Curl\Message\Body $body,
        array $cookies = [],
        ?\Guidance\Tests\Base\Lib\Curl\Message\Headers $headers = null
    ): \Guidance\Tests\Base\Lib\Curl\Message\Request {
        return $this->create(
            \Guidance\Tests\Base\Lib\Curl\Message\Request::METHOD_PUT,
            $connectionInfo,
            $location,
            $cookies,
            $headers,
            $body
        );
    }

    public function createPatch(
        \Guidance\Tests\Base\Lib\Curl\Message\Request\ConnectionInfo $connectionInfo,
        \Guidance\Tests\Base\Lib\Curl\Message\Location $location,
        \Guidance\Tests\Base\Lib\Curl\Message\Body $body,
        array $cookies = [],
        ?\Guidance\Tests\Base\Lib\Curl\Message\Headers $headers = null
    ): \Guidance\Tests\Base\Lib\Curl\Message\Request {
        return $this->create(
            \Guidance\Tests\Base\Lib\Curl\Message\Request::METHOD_PATCH,
            $connectionInfo,
            $location,
            $cookies,
            $headers,
            $body
        );
    }

    public function createDelete(
        \Guidance\Tests\Base\Lib\Curl\Message\Request\ConnectionInfo $connectionInfo,
        \Guidance\Tests\Base\Lib\Curl\Message\Location $location,
        array $cookies = [],
        ?\Guidance\Tests\Base\Lib\Curl\Message\Headers $headers = null
    ): \Guidance\Tests\Base\Lib\Curl\Message\Request {
        return $this->create(
            \Guidance\Tests\Base\Lib\Curl\Message\Request::METHOD_DELETE,
            $connectionInfo,
            $location,
            $cookies,
            $headers,
            null
        );
    }

    public function createHead(
        \Guidance\Tests\Base\Lib\Curl\Message\Request\ConnectionInfo $connectionInfo,
        \Guidance\Tests\Base\Lib\Curl\Message\Location $location,
        array $cookies = [],
        ?\Guidance\Tests\Base\Lib\Curl\Message\Headers $headers = null
    ): \Guidance\Tests\Base\Lib\Curl\Message\Request {
        return $this->create(
            \Guidance\Tests\Base\Lib\Curl\Message\Request::METHOD_HEAD,
            $connectionInfo,
            $location,
            $cookies,
            $headers,
            null
        );
    }

    public function createOption(
        \Guidance\Tests\Base\Lib\Curl\Message\Request\ConnectionInfo $connectionInfo,
        \Guidance\Tests\Base\Lib\Curl\Message\Location $location,
        array $cookies = [],
        ?\Guidance\Tests\Base\Lib\Curl\Message\Headers $headers = null
    ): \Guidance\Tests\Base\Lib\Curl\Message\Request {
        return $this->create(
            \Guidance\Tests\Base\Lib\Curl\Message\Request::METHOD_OPTION,
            $connectionInfo,
            $location,
            $cookies,
            $headers,
            null
        );
    }

    // ########################################

    public function create(
        string $httpMethod,
        \Guidance\Tests\Base\Lib\Curl\Message\Request\ConnectionInfo $connectionInfo,
        \Guidance\Tests\Base\Lib\Curl\Message\Location $location,
        array $cookies,
        ?\Guidance\Tests\Base\Lib\Curl\Message\Headers $headers,
        ?\Guidance\Tests\Base\Lib\Curl\Message\Body $body
    ): \Guidance\Tests\Base\Lib\Curl\Message\Request {
        if (is_null($headers)) {
            $headers = $this->headersFactory->create([]);
        }

        return $this->di->make(\Guidance\Tests\Base\Lib\Curl\Message\Request::class, [
                'httpMethod'     => $httpMethod,
                'connectionInfo' => $connectionInfo,
                'location'       => $location,
                'cookies'        => $cookies,
                'headers'        => $headers,
                'body'           => $body,
            ]
        );
    }

    // ########################################
}
