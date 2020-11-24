<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\Curl;

class Processor
{
    /** @var \Guidance\Tests\Base\Lib\Curl\Processor\Handle\Factory */
    private $handleFactory = null;

    /** @var \Guidance\Tests\Base\Lib\Curl\Message\Response\Factory */
    private $responseFactory = null;

    /** @var \Guidance\Tests\Base\Lib\Curl\Message\Response\Info\Factory */
    private $responseInfoFactory = null;

    /** @var \Guidance\Tests\Base\Lib\Curl\Processor\ErrorHook */
    private $errorHook = null;

    // ########################################

    public function __construct(
        \Guidance\Tests\Base\Lib\Curl\Processor\Handle\Factory $handleFactory,
        \Guidance\Tests\Base\Lib\Curl\Message\Response\Factory $responseFactory,
        \Guidance\Tests\Base\Lib\Curl\Message\Response\Info\Factory $responseInfoFactory,
        \Guidance\Tests\Base\Lib\Curl\Processor\ErrorHook $errorHook
    ) {
        $this->responseFactory     = $responseFactory;
        $this->responseInfoFactory = $responseInfoFactory;
        $this->handleFactory       = $handleFactory;
        $this->errorHook           = $errorHook;
    }

    // ########################################

    public function process(\Guidance\Tests\Base\Lib\Curl\Message\Request $request): \Guidance\Tests\Base\Lib\Curl\Message\Response
    {
        $handle = $this->handleFactory->create($request);

        try {
            $rawResponse = curl_exec($handle);

            $this->errorHook->hook($request, curl_errno($handle), curl_error($handle));

            $info = $this->responseInfoFactory->create(curl_getinfo($handle));

            return $this->responseFactory->createFromRawResponse($request, $info, $rawResponse);
        } finally {
            curl_close($handle);
        }
    }

    // ########################################
}
