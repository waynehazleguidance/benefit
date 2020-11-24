<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Actor\Helper;

class LogProvider extends \Codeception\Module
{
    /**
     * Look for deteils on:
     * https://github.com/SeleniumHQ/selenium/wiki/JsonWireProtocol#log-type
     */
    private const CLIENT_LOG_TYPE  = 'client';
    private const DRIVER_LOG_TYPE  = 'driver';
    private const BROWSER_LOG_TYPE = 'browser';
    private const SERVER_LOG_TYPE  = 'server';

    /**
     * Look for deteils on:
     * https://github.com/SeleniumHQ/selenium/wiki/JsonWireProtocol#log-levels
     */
    private const INFO_MESSAGES_LEVEL    = 'INFO';
    private const WARNING_MESSAGES_LEVEL = 'WARNING';
    private const ERROR_MESSAGES_LEVEL   = 'SEVERE';

    /** @var \Guidance\Tests\Base\Actor\WebDriver */
    private $webDriver = null;

    //########################################

    public function _beforeSuite($settings = []): void
    {
        $this->webDriver = $this->getModule(\Guidance\Tests\Base\Actor\WebDriver::class);
    }

    //########################################

    public function getAvailableLogTypes(): array
    {
        return $this->webDriver->executeInSelenium(function(\Facebook\WebDriver\Remote\RemoteWebDriver $remoteWebDriver) {
            return $remoteWebDriver->manage()->getAvailableLogTypes();
        });
    }

    public function getClientLog(): array
    {
        return $this->webDriver->executeInSelenium(function(\Facebook\WebDriver\Remote\RemoteWebDriver $remoteWebDriver) {
            return $remoteWebDriver->manage()->getLog(self::CLIENT_LOG_TYPE);
        });
    }

    public function getDriverLog(): array
    {
        return $this->webDriver->executeInSelenium(function(\Facebook\WebDriver\Remote\RemoteWebDriver $remoteWebDriver) {
            return $remoteWebDriver->manage()->getLog(self::DRIVER_LOG_TYPE);
        });
    }

    public function getBrowserLog(): array
    {
        return $this->webDriver->executeInSelenium(function(\Facebook\WebDriver\Remote\RemoteWebDriver $remoteWebDriver) {
            return $remoteWebDriver->manage()->getLog(self::BROWSER_LOG_TYPE);
        });
    }

    public function getServerLog(): array
    {
        return $this->webDriver->executeInSelenium(function(\Facebook\WebDriver\Remote\RemoteWebDriver $remoteWebDriver) {
            return $remoteWebDriver->manage()->getLog(self::SERVER_LOG_TYPE);
        });
    }

    //########################################

    public function isErrorOccur(array $logs): bool
    {
        return $this->isLogLevelExist($logs, self::ERROR_MESSAGES_LEVEL);
    }

    public function isWarningOccur(array $logs): bool
    {
        return $this->isLogLevelExist($logs, self::WARNING_MESSAGES_LEVEL);
    }

    public function isInfoMessageOccur(array $logs): bool
    {
        return $this->isLogLevelExist($logs, self::INFO_MESSAGES_LEVEL);
    }

    //########################################

    public function getErrorMessages(array $logs): array
    {
        return $this->getLogLevelMessages($logs, self::ERROR_MESSAGES_LEVEL);
    }

    public function getWarningMessages(array $logs): array
    {
        return $this->getLogLevelMessages($logs, self::WARNING_MESSAGES_LEVEL);
    }

    public function getInfoMessages(array $logs): array
    {
        return $this->getLogLevelMessages($logs, self::INFO_MESSAGES_LEVEL);
    }

    //########################################

    private function isLogLevelExist(array $logs, string $logLevel): bool
    {
        foreach ($logs as $log) {
            if (isset($log['level']) && $log['level'] == $logLevel) {
                return true;
            }
        }
        return false;
    }

    private function getLogLevelMessages(array $logs, string $logLevel): array
    {
        $messages = [];
        foreach ($logs as $log) {
            if (isset($log['level']) && $log['level'] == $logLevel) {
                isset($log['message']) && $messages[] = $log['message'];
            }
        }
        return $messages;
    }

    //########################################
}
