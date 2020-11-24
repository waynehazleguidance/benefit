<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\Curl\Message\Request;

class ConnectionInfo
{
    const DEFAULT_CONNECTION_TIMEOUT = 15;
    const DEFAULT_EXECUTION_TIMEOUT  = 300;

    /** @var int */
    private $connectionTimeout = self::DEFAULT_CONNECTION_TIMEOUT;

    /** @var int */
    private $executionTimeout = self::DEFAULT_EXECUTION_TIMEOUT;

    /** @var bool */
    private $isFollowLocation = false;

    /** @var int */
    private $maxRedirecting = 0;

    /** @var bool */
    private $isVerifySsl = true;

    /** @var int */
    private $sslVersion = 0;

    /** @var string */
    private $authorization = null;

    // ########################################

    public function setConnectionTimeout(int $seconds): self
    {
        $this->connectionTimeout = (int)$seconds;

        return $this;
    }

    public function getConnectionTimeout()
    {
        return $this->connectionTimeout;
    }

    // ########################################

    public function setExecutionTimeout(int $seconds)
    {
        $this->executionTimeout = (int)$seconds;

        return $this;
    }

    public function getExecutionTimeout(): int
    {
        return $this->executionTimeout;
    }

    // ########################################

    public function setAuthorization(string $authorization): self
    {
        $this->authorization = $authorization;

        return $this;
    }

    public function getAuthorization(): ?string
    {
        return $this->authorization;
    }

    // ########################################

    public function isFollowLocation(): bool
    {
        return $this->isFollowLocation;
    }

    /**
     * Follow HTTP 3xx redirects
     *
     * @return $this
     */
    public function enableFollowLocation(): self
    {
        $this->isFollowLocation = true;

        return $this;
    }

    public function disableFollowLocation(): self
    {
        $this->isFollowLocation = false;

        return $this;
    }

    public function setMaxRedirecting(int $value): self
    {
        $this->maxRedirecting = (int)$value;

        return $this;
    }

    public function setUnlimitedRedirecting(): self
    {
        $this->setMaxRedirecting(-1);

        return $this;
    }

    public function getMaxRedirecting(): int
    {
        return $this->maxRedirecting;
    }

    // ########################################

    public function isVerifySsl(): bool
    {
        return $this->isVerifySsl;
    }

    public function enableVerifySsl(): self
    {
        $this->isVerifySsl = true;

        return $this;
    }

    public function disableVerifySsl(): self
    {
        $this->isVerifySsl = false;

        return $this;
    }

    public function setSslVersion($version): self
    {
        $this->sslVersion = (int)$version;

        return $this;
    }

    public function getSslVersion(): int
    {
        if (is_null($this->sslVersion)) {
            return CURL_SSLVERSION_DEFAULT;
        }

        if ( ! in_array($this->sslVersion, [
            CURL_SSLVERSION_TLSv1,
            CURL_SSLVERSION_SSLv2,
            CURL_SSLVERSION_SSLv3,
            CURL_SSLVERSION_TLSv1_0,
            CURL_SSLVERSION_TLSv1_1,
            CURL_SSLVERSION_TLSv1_2
        ])
        ) {
            return CURL_SSLVERSION_DEFAULT;
        }

        return $this->sslVersion;
    }

    // ########################################
}
