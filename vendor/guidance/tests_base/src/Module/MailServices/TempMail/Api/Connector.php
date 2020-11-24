<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Module\MailServices\TempMail\Api;

class Connector
{
    /** @var string */
    private $key = null;

    /** @var string */
    private $host = null;

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

    public function __construct(string $key, $host)
    {
        $this->key  = $key;
        $this->host = $host;
    }

    // ########################################

    public function getResponseData(string $path): array
    {
        $connectionInfo = $this->connectionInfoFactory->create()
            ->setConnectionTimeout(\Guidance\Tests\Base\Lib\Curl\Message\Request\ConnectionInfo::DEFAULT_CONNECTION_TIMEOUT)
            ->setExecutionTimeout(\Guidance\Tests\Base\Lib\Curl\Message\Request\ConnectionInfo::DEFAULT_EXECUTION_TIMEOUT)
            ->disableVerifySsl();

        $location = $this->locationFactory->create(
            'https',
            $this->host,
            \Guidance\Tests\Base\Lib\Curl\Message\Location::PORT_HTTPS,
            $path
        );

        $headers = $this->headersFactory->create(
            [
                'x-rapidapi-host' => $this->host,
                'x-rapidapi-key'  => $this->key
            ]
        );

        /** @var \Guidance\Tests\Base\Lib\Curl\Message\Request $request */
        $request = $this->requestFactory->createGet($connectionInfo, $location, [], $headers);

        try {
            /** @var \Guidance\Tests\Base\Lib\Curl\Message\Response $response */
            $response = $this->curlProcessor->process($request);

        } catch (\RuntimeException $e) {
            throw new \RuntimeException("Error while trying to get TempMail API response. " . $e->getMessage());
        }

        return $this->jsonManipulator->decode($response->getBody()->getData());
    }

    // ########################################
}
