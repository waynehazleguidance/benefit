<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\Curl\Message\Response;

class Factory
{
    use \Guidance\Tests\Base\Object\FactoryTrait;

    /** @var \Guidance\Tests\Base\Lib\Curl\Message\Location\Factory */
    private $locationFactory;

    /** @var \Guidance\Tests\Base\Lib\Curl\Message\Headers\Factory */
    private $headersFactory;

    /** @var \Guidance\Tests\Base\Lib\Curl\Message\Body\Factory */
    private $bodyFactory;

    // ########################################

    public function __construct(
        \Guidance\Tests\Base\Lib\Curl\Message\Location\Factory $locationFactory,
        \Guidance\Tests\Base\Lib\Curl\Message\Headers\Factory $headersFactory,
        \Guidance\Tests\Base\Lib\Curl\Message\Body\Factory $bodyFactory
    ) {
        $this->locationFactory = $locationFactory;
        $this->headersFactory  = $headersFactory;
        $this->bodyFactory     = $bodyFactory;
    }

    // ########################################

    public function create(
        \Guidance\Tests\Base\Lib\Curl\Message\Request $request,
        \Guidance\Tests\Base\Lib\Curl\Message\Location $location,
        Info $info,
        \Guidance\Tests\Base\Lib\Curl\Message\Headers $headers,
        ?\Guidance\Tests\Base\Lib\Curl\Message\Body $body
    ): \Guidance\Tests\Base\Lib\Curl\Message\Response {
        return $this->di->make(\Guidance\Tests\Base\Lib\Curl\Message\Response::class, [
            'request'  => $request,
            'location' => $location,
            'info'     => $info,
            'headers'  => $headers,
            'body'     => $body,
        ]);
    }

    // ########################################

    public function createFromRawResponse(
        \Guidance\Tests\Base\Lib\Curl\Message\Request $request,
        Info $info,
        string $rawResponse
    ): \Guidance\Tests\Base\Lib\Curl\Message\Response {
        $headerSize = $info->getHeaderSize();

        $rawHeaders = explode("\r\n\r\n", substr($rawResponse, 0, $headerSize - 2));

        $rawHeaders = $rawHeaders[count($rawHeaders) - 1];

        $headers = $this->parseHeaders($rawHeaders);

        $body = null;

        if ($headers->hasHeader('Content-Type')) {
            $rawBody = substr($rawResponse, $headerSize);

            $body = $this->bodyFactory->create($headers->getHeader('Content-Type'), $rawBody);
        }

        $url = empty($info->getRedirectUrl()) ? $info->getUrl() : $info->getRedirectUrl();

        $response = $this->create($request, $this->locationFactory->createFromUrl($url), $info, $headers, $body);

        $code = $info->getHttpCode();

        if ($code >= 400) {
            throw new \Guidance\Tests\Base\Lib\Curl\Message\Response\Exception\HttpCode(
                "HTTP Error: $code",
                $request,
                $response,
                $code
            );
        }

        return $response;
    }

    // ########################################

    private function parseHeaders(string $rawHeaders): \Guidance\Tests\Base\Lib\Curl\Message\Headers
    {
        $headers = [];

        foreach (explode("\r\n", $rawHeaders) as $i => $line) {
            if ($i != 0 && !empty($line)) {
                list ($key, $value) = explode(':', $line, 2);

                $headers[$key] = $value;
            }
        }

        return $this->headersFactory->create($headers);
    }

    // ########################################
}
