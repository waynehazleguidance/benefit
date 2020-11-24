<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Module\BrowserStack\Api;

class Connector
{
    /** @var string */
    private $connectionCredential = null;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Lib\Curl\Message\Location\Factory
     */
    private $locationFactory = null;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Lib\Curl\Message\Request\Factory
     */
    private $requestFactory = null;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Lib\Curl\Processor
     */
    private $curlProcessor = null;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Lib\Curl\Message\Body\Factory
     */
    private $bodyFactory = null;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Lib\Curl\Message\Headers\Factory
     */
    private $headersFactory = null;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Lib\Curl\Message\Request\ConnectionInfo\Factory
     */
    private $connectionInfoFactory = null;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Lib\DataManipulation\Json
     */
    private $jsonManipulator = null;

    // ########################################

    public function __construct(string $connectionCredential)
    {
        $this->connectionCredential = $connectionCredential;
    }

    // ########################################

    public function getResponseData(string $url, array $headers = null, array $bodyParams = null, bool $isDelete = false): array
    {
        $response = $this->getResponse($url, $headers, $bodyParams, $isDelete);

        return $this->jsonManipulator->decode($response->getBody()->getData());
    }

    public function getResponse(string $url, array $headers = null, array $bodyParams = null, bool $isDelete = false): \Guidance\Tests\Base\Lib\Curl\Message\Response
    {
        $connectionInfo = $this->connectionInfoFactory->create()
            ->setConnectionTimeout(\Guidance\Tests\Base\Lib\Curl\Message\Request\ConnectionInfo::DEFAULT_CONNECTION_TIMEOUT)
            ->setExecutionTimeout(\Guidance\Tests\Base\Lib\Curl\Message\Request\ConnectionInfo::DEFAULT_EXECUTION_TIMEOUT)
            ->setAuthorization($this->connectionCredential)
            ->disableVerifySsl();

        $url = parse_url($url);

        $scheme          = 'https';
        $host            = $url['host'];
        $port            = \Guidance\Tests\Base\Lib\Curl\Message\Location::PORT_HTTPS;
        $path            = $url['path'];
        $queryParameters = [];
        $fragment        = null;

        $location = $this->locationFactory->create($scheme, $host, $port, $path, $queryParameters, $fragment);

        if (isset($bodyParams)) {
            /** @var \Guidance\Tests\Base\Lib\Curl\Message\Request $request */
            $request = $this->requestFactory->createPut(
                $connectionInfo,
                $location,
                $this->bodyFactory->json($bodyParams),
                [],
                $headers !== null ? $this->headersFactory->create($headers) : null
            );

        } elseif ($isDelete) {
            /** @var \Guidance\Tests\Base\Lib\Curl\Message\Request $request */
            $request = $this->requestFactory->createDelete(
                $connectionInfo,
                $location,
                [],
                $headers !== null ? $this->headersFactory->create($headers) : null
            );

        } else {
            /** @var \Guidance\Tests\Base\Lib\Curl\Message\Request $request */
            $request = $this->requestFactory->createGet(
                $connectionInfo,
                $location,
                [],
                $headers !== null ? $this->headersFactory->create($headers) : null
            );
        }

        try {
            /** @var \Guidance\Tests\Base\Lib\Curl\Message\Response $response */
            $response = $this->curlProcessor->process($request);

        } catch (\RuntimeException $e) {
            throw new \RuntimeException("Error while trying to get BrowserStack API response. " . $e->getMessage());
        }

        return $response;
    }

    // ########################################
}
