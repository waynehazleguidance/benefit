<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\Curl\Message;

class Response extends \Guidance\Tests\Base\Lib\Curl\Message\BaseAbstract
{
    /** @var \Guidance\Tests\Base\Lib\Curl\Message\Request */
    private $request = null;

    /** @var \Guidance\Tests\Base\Lib\Curl\Message\Response\Info */
    private $info = null;

    // ########################################

    public function __construct(
        Request $request,
        \Guidance\Tests\Base\Lib\Curl\Message\Response\Info $info,
        Location $location,
        Headers $headers,
        ?Body $body
    ) {
        parent::__construct($location, $headers, $body);

        $this->request = $request;
        $this->info    = $info;
    }

    // ########################################

    public function getRequest(): \Guidance\Tests\Base\Lib\Curl\Message\Request
    {
        return $this->request;
    }

    // ########################################

    public function getInfo(): \Guidance\Tests\Base\Lib\Curl\Message\Response\Info
    {
        return $this->info;
    }

    // ########################################

    public function getRawCookies(): array
    {
        if ($this->getHeaders()->hasHeader('set-cookie')) {
            return $this->getHeaders()->getHeader('set-cookie');
        }

        return [];
    }

    // ########################################
}
