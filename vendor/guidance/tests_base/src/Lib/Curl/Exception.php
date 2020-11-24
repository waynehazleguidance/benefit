<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\Curl;

class Exception extends \RuntimeException
{
    /** @var \Guidance\Tests\Base\Lib\Curl\Message\Request */
    private $request = null;

    private $additionalData = [];

    // ########################################

    public function __construct(
        string $message,
        \Guidance\Tests\Base\Lib\Curl\Message\Request $request,
        int $code = 0,
        array $additionalData = [],
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->request        = $request;
        $this->additionalData = $additionalData;
    }

    // ########################################

    public function getRequest(): \Guidance\Tests\Base\Lib\Curl\Message\Request
    {
        return $this->request;
    }

    // ########################################
}
