<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\Curl\Processor;

class Multi
{
    /** @var \Guidance\Tests\Base\Lib\Curl\Processor\Handle\Factory */
    private $handleFactory = null;

    /** @var \Guidance\Tests\Base\Lib\Curl\Message\Response\Factory */
    private $responseFactory = null;

    /** @var \Guidance\Tests\Base\Lib\Curl\Message\Response\Info\Factory */
    private $responseInfoFactory = null;

    /** @var \Guidance\Tests\Base\Lib\Curl\Processor\ErrorHook */
    private $errorHook = null;

    /** @var array */
    private $responses = [];

    // ########################################

    public function __construct(
        \Guidance\Tests\Base\Lib\Curl\Processor\Handle\Factory $handleFactory,
        \Guidance\Tests\Base\Lib\Curl\Message\Response\Factory $responseFactory,
        \Guidance\Tests\Base\Lib\Curl\Message\Response\Info\Factory $responseInfoFactory,
        ErrorHook $errorHook
    ) {
        $this->handleFactory       = $handleFactory;
        $this->responseFactory     = $responseFactory;
        $this->responseInfoFactory = $responseInfoFactory;
        $this->errorHook           = $errorHook;
    }

    // ########################################

    /**
     * @param \Guidance\Tests\Base\Lib\Curl\Message\Request[] $requests
     * @param int $maxParallelRequests
     */
    public function process(
        array $requests,
        int $maxParallelRequests = 10
    ): void {
        $maxParallelRequests = (count($requests) < $maxParallelRequests) ? count($requests) : $maxParallelRequests;
        try {
            $multiHandle = curl_multi_init();

            $handles = [];

            for ($i = 0; $i < $maxParallelRequests; $i++) {
                $request = array_pop($requests);
                $handle  = $this->handleFactory->create($request);

                $handles[(int)$handle] = $request;

                curl_multi_add_handle($multiHandle, $handle);
            }

            do {
                while (($execRun = curl_multi_exec($multiHandle, $running)) == CURLM_CALL_MULTI_PERFORM) {
                }

                if ($execRun != CURLM_OK) {
                    break;
                }

                while ($done = curl_multi_info_read($multiHandle)) {
                    $handle = $done['handle'];

                    $this->finalizeRequest(
                        $handle,
                        $handles[(int)$handle],
                        curl_multi_getcontent($handle)
                    );

                    $request = array_pop($requests);

                    if (isset($request)) {
                        $handle = $this->handleFactory->create($request);

                        $handles[(int)$handle] = $request;

                        curl_multi_add_handle($multiHandle, $handle);
                    }

                    curl_multi_remove_handle($multiHandle, $done['handle']);

                    curl_close($done['handle']);
                }
            } while ($running);
        } finally {
            curl_multi_close($multiHandle);
        }
    }

    // ########################################

    public function hasError(\Guidance\Tests\Base\Lib\Curl\Message\Request $request): bool
    {
        return $this->responses[spl_object_hash($request)] instanceof \Throwable;
    }

    public function popError(\Guidance\Tests\Base\Lib\Curl\Message\Request $request): \Throwable
    {
        $error = $this->responses[spl_object_hash($request)];

        unset($this->responses[spl_object_hash($request)]);

        return $error;
    }

    public function popResponse(\Guidance\Tests\Base\Lib\Curl\Message\Request $request): \Guidance\Tests\Base\Lib\Curl\Message\Response
    {
        $result = $this->responses[spl_object_hash($request)];

        unset($this->responses[spl_object_hash($request)]);

        if ($result instanceof \Throwable) {
            throw $result;
        }

        return $result;
    }

    // ########################################

    private function finalizeRequest(
        $handle,
        \Guidance\Tests\Base\Lib\Curl\Message\Request $request,
        string $rawResponse
    ) {
        try {
            $this->errorHook->hook($request, curl_errno($handle), curl_error($handle));

            $info = $this->responseInfoFactory->create(curl_getinfo($handle));

            $result = $this->responseFactory->createFromRawResponse($request, $info, $rawResponse);
        } catch (\Throwable $throwable) {
            $result = $throwable;
        }

        $this->responses[spl_object_hash($request)] = $result;
    }

    // ########################################
}
