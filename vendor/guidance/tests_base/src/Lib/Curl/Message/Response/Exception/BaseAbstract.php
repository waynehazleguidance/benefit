<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\Curl\Message\Response\Exception;

abstract class BaseAbstract extends \Guidance\Tests\Base\Lib\Curl\Exception
{
    // ########################################

    public function __construct(
        string $message,
        \Guidance\Tests\Base\Lib\Curl\Message\Request $request,
        int $code,
        array $additionalData = [],
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $request, $code, $additionalData, $previous);
    }

    // ########################################
}
