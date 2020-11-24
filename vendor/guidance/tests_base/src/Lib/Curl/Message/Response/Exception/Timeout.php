<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\Curl\Message\Response\Exception;

abstract class Timeout extends BaseAbstract
{
    // ########################################

    public function __construct(
        string $message,
        \Guidance\Tests\Base\Lib\Curl\Message\Request $request,
        array $additionalData = [],
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $request, CURLE_OPERATION_TIMEOUTED, $additionalData, $previous);
    }

    // ########################################
}
