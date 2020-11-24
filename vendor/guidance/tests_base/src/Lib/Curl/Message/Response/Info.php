<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\Curl\Message\Response;

class Info
{
    /** @var string */
    private $url = null;

    /** @var string */
    private $redirectUrl = null;

    /** @var string */
    private $primaryIp = null;

    /** @var int */
    private $primaryPort = null;

    /** @var int */
    private $redirectCount = null;

    /** @var float */
    private $redirectTime = null;

    /** @var int */
    private $httpCode = null;

    /** @var string */
    private $contentType = null;

    /** @var float */
    private $totalTime = null;

    /** @var float */
    private $nameLookupTime = null;

    /** @var float */
    private $connectTime = null;

    /** @var float */
    private $preTransferTime = null;

    /** @var float */
    private $startTransferTime = null;

    /** @var int */
    private $headerSize = null;

    /** @var int */
    private $requestSize = null;

    /** @var float */
    private $downloadContentLength = null;

    /** @var float */
    private $downloadSize = null;

    /** @var float */
    private $downloadSpeed = null;

    /** @var float */
    private $uploadContentLength = null;

    /** @var float */
    private $uploadSize = null;

    /** @var float */
    private $uploadSpeed = null;

    /** @var int */
    private $sslVerifyResult = null;

    /** @var array */
    private $certInfo = null;

    // ########################################

    public function __construct(
        string $url,
        string $redirectUrl,
        string $primaryIp,
        int $primaryPort,
        int $redirectCount,
        float $redirectTime,
        int $httpCode,
        string $contentType,
        float $totalTime,
        float $nameLookupTime,
        float $connectTime,
        float $preTransferTime,
        float $startTransferTime,
        int $headerSize,
        int $requestSize,
        float $downloadContentLength,
        float $downloadSize,
        float $downloadSpeed,
        float $uploadContentLength,
        float $uploadSize,
        float $uploadSpeed,
        int $sslVerifyResult,
        array $certInfo
    ) {
        $this->url         = $url;
        $this->redirectUrl = $redirectUrl;

        $this->primaryIp   = $primaryIp;
        $this->primaryPort = $primaryPort;

        $this->redirectCount = $redirectCount;
        $this->redirectTime  = $redirectTime;

        $this->httpCode    = $httpCode;
        $this->contentType = $contentType;

        $this->totalTime         = $totalTime;
        $this->nameLookupTime    = $nameLookupTime;
        $this->connectTime       = $connectTime;
        $this->preTransferTime   = $preTransferTime;
        $this->startTransferTime = $startTransferTime;

        $this->headerSize  = $headerSize;
        $this->requestSize = $requestSize;

        $this->downloadContentLength = $downloadContentLength;
        $this->downloadSize          = $downloadSize;
        $this->downloadSpeed         = $downloadSpeed;
        $this->uploadContentLength   = $uploadContentLength;
        $this->uploadSize            = $uploadSize;
        $this->uploadSpeed           = $uploadSpeed;

        $this->sslVerifyResult = $sslVerifyResult;
        $this->certInfo        = $certInfo;
    }

    // ########################################

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getRedirectUrl(): string
    {
        return $this->redirectUrl;
    }

    // ########################################

    public function getPrimaryIp(): string
    {
        return $this->primaryIp;
    }

    public function getPrimaryPort(): int
    {
        return $this->primaryPort;
    }

    // ########################################

    public function hasRedirected(): bool
    {
        return $this->getRedirectCount() > 0;
    }

    public function getRedirectCount(): int
    {
        return $this->redirectCount;
    }

    public function getRedirectTime(): float
    {
        return $this->redirectTime;
    }

    // ########################################

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    public function getContentType(): string
    {
        return $this->contentType;
    }

    // ########################################

    public function getTotalTime(): float
    {
        return $this->totalTime;
    }

    public function getNameLookupTime(): float
    {
        return $this->nameLookupTime;
    }

    public function getConnectTime(): float
    {
        return $this->connectTime;
    }

    public function getPreTransferTime(): float
    {
        return $this->preTransferTime;
    }

    public function getStartTransferTime(): float
    {
        return $this->startTransferTime;
    }

    // ########################################

    public function getHeaderSize(): int
    {
        return $this->headerSize;
    }

    public function getRequestSize(): int
    {
        return $this->requestSize;
    }

    // ########################################

    public function getDownloadContentLength(): float
    {
        return $this->downloadContentLength;
    }

    public function getDownloadSize(): float
    {
        return $this->downloadSize;
    }

    public function getDownloadSpeed(): float
    {
        return $this->downloadSpeed;
    }

    public function getUploadContentLength(): float
    {
        return $this->uploadContentLength;
    }

    public function getUploadSize(): float
    {
        return $this->uploadSize;
    }

    public function getUploadSpeed(): float
    {
        return $this->uploadSpeed;
    }

    // ########################################

    public function getSslVerifyResult(): int
    {
        return $this->sslVerifyResult;
    }

    public function getCertInfo(): array
    {
        return $this->certInfo;
    }

    // ########################################

    public function __toArray()
    {
        return [
            'url'              => $this->getUrl(),
            'redirect_url'     => $this->getRedirectUrl(),
            'primary_location' => [
                'ip'   => $this->getPrimaryIp(),
                'port' => $this->getPrimaryPort(),
            ],
            'redirect_data'    => [
                'is_redirected'  => $this->hasRedirected(),
                'redirect_count' => $this->getRedirectCount(),
                'redirect_time'  => $this->getRedirectTime(),
            ],
            'http_code'        => $this->getHttpCode(),
            'content_type'     => $this->getContentType(),
            'time'              => [
                'total'          => $this->getTotalTime(),
                'name_lookup'    => $this->getNameLookupTime(),
                'connect'        => $this->getConnectTime(),
                'pre_transfer'   => $this->getPreTransferTime(),
                'start_transfer' => $this->getStartTransferTime(),
            ],
            'header_size'       => $this->getHeaderSize(),
            'request_size'      => $this->getRequestSize(),
            'download'          => [
                'content_length' => $this->getDownloadContentLength(),
                'size'           => $this->getDownloadSize(),
                'speed'          => $this->getDownloadSpeed(),
            ],
            'upload'            => [
                'content_length' => $this->getUploadContentLength(),
                'size'           => $this->getUploadSize(),
                'speed'          => $this->getUploadSpeed(),
            ],
            'ssl_verify_result' => $this->getSslVerifyResult(),
            'cert_info'         => $this->getCertInfo(),
        ];
    }

    // ########################################
}
