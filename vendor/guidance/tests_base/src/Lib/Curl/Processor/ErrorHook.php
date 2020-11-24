<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\Curl\Processor;

class ErrorHook
{
    // ########################################

    public function hook(\Guidance\Tests\Base\Lib\Curl\Message\Request $request, int $code, string $message): void
    {
        if ($code != 0) {
            if ($code == CURLE_OPERATION_TIMEOUTED) {
                $connectionTimeoutMessage = 'Connection timed out';
                $executionTimeoutMessage  = 'Operation timed out';

                if (substr($message, 0, strlen($connectionTimeoutMessage)) == $connectionTimeoutMessage) {
                    throw new \Guidance\Tests\Base\Lib\Curl\Message\Response\Exception\ConnectionTimeout($message, $request);
                } elseif (substr($message, 0, strlen($executionTimeoutMessage)) == $executionTimeoutMessage) {
                    throw new \Guidance\Tests\Base\Lib\Curl\Message\Response\Exception\ExecutionTimeout($message, $request);
                }
            }

            throw new \Guidance\Tests\Base\Lib\Curl\Exception($message, $request, $code);
        }
    }

    // ########################################
}
