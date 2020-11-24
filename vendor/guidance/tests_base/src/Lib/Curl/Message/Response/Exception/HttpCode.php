<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\Curl\Message\Response\Exception;

class HttpCode extends BaseAbstract
{
    /** @var \Guidance\Tests\Base\Lib\Curl\Message\Response */
    private $response = null;

    // ########################################

    public function __construct(
        string $message,
        \Guidance\Tests\Base\Lib\Curl\Message\Request $request,
        \Guidance\Tests\Base\Lib\Curl\Message\Response $response,
        int $code,
        array $additionalData = [],
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $request, $code, $additionalData, $previous);
        $this->response = $response;
    }

    // ########################################

    public function getResponse(): \Guidance\Tests\Base\Lib\Curl\Message\Response
    {
        return $this->response;
    }

    // ########################################
}
