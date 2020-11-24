<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\Curl\Message\Location;

class Factory
{
    use \Guidance\Tests\Base\Object\FactoryTrait;

    // ########################################

    public function create(
        string $scheme,
        string $host,
        int $port,
        string $path,
        array $queryParameters = [],
        ?string $fragment = null
    ): \Guidance\Tests\Base\Lib\Curl\Message\Location {
        return $this->di->make(\Guidance\Tests\Base\Lib\Curl\Message\Location::class, [
            'scheme'           => $scheme,
            'host'             => $host,
            'port'             => $port,
            'path'             => $path,
            'queryParameters' => $queryParameters,
            'fragment'         => $fragment,
        ]);
    }

    // ########################################

    public function createFromUrl(string $url): \Guidance\Tests\Base\Lib\Curl\Message\Location
    {
        $url = parse_url($url);

        if ($url === false) {
            throw new  \Guidance\Tests\Base\Lib\Curl\Message\Location\Exception\InvalidUrl("Invalid URL.", ['url' => $url]);
        }

        $scheme          = 'http';
        $port            =  \Guidance\Tests\Base\Lib\Curl\Message\Location::PORT_HTTP;
        $path            = '';
        $queryParameters = [];
        $fragment        = null;

        $urlValidator = $this->createParamsValidator($url);

        $urlValidator->assertNotEmptyString('/host/');

        $host = $url['host'];

        if ($urlValidator->isNotEmptyString('/scheme/')) {
            if ($url['scheme'] === 'http' || $url['scheme'] === 'https') {
                $scheme = $url['scheme'];

                if ($url['scheme'] === 'https') {
                    $port = \Guidance\Tests\Base\Lib\Curl\Message\Location::PORT_HTTPS;
                }
            } else {
                throw new \Guidance\Tests\Base\Lib\Curl\Message\Location\Exception\InvalidScheme(
                    "Invalid URL scheme.",
                    ['url' => $url]
                );
            }
        }

        if ($urlValidator->isNotZeroInteger('/port/')) {
            $port = $url['port'];
        }

        if ($urlValidator->isNotEmptyString('/path/')) {
            $path = $url['path'];
        }

        if (isset($url['query'])) {
            parse_str($url['query'], $queryParameters);
        }

        if ($urlValidator->isNotEmptyString('/fragment/')) {
            $fragment = $url['fragment'];
        }

        return $this->create($scheme, $host, $port, $path, $queryParameters, $fragment);
    }

    // ########################################
}
