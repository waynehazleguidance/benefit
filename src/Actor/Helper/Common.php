<?php

declare(strict_types=1);

namespace Guidance\Tests\Project\Actor\Helper;

class Common extends \Codeception\Module
{
    private const EXECUTIONS_NUMBER_BEFORE_FAIL = 3;

    /**@var \Guidance\Tests\Base\Actor\WebDriver */
    private $webDriver = null;

    //########################################

    public function _beforeSuite($settings = []): void
    {
        $this->webDriver = $this->getModule(\Guidance\Tests\Base\Actor\WebDriver::class);
    }

    //########################################

    public function waitForNoActiveAjax(int $timeout = 30, callable  $callback = null): void
    {
        $waitCondition = function(\Facebook\WebDriver\Remote\RemoteWebDriver $remoteWebDriver) use ($callback) {

            $isJsCompleted = true;

            if ($this->webDriver->executeJS('return typeof jQuery != "undefined";')) {
                $isJsCompleted = $isJsCompleted && $this->webDriver->executeJS('return jQuery.active == 0;');
            }

            if ($this->webDriver->executeJS('return typeof Ajax != "undefined";')) {
                $isJsCompleted = $isJsCompleted && $this->webDriver->executeJS('return Ajax.activeRequestCount == 0;');
            }

            return ($callback === null)
                ? $isJsCompleted
                : $isJsCompleted && $callback($remoteWebDriver);
        };

        /** @var \Guidance\Tests\Base\Actor\Helper\Wait $helper */
        $helper = $this->getModule(\Guidance\Tests\Base\Actor\Helper\Wait::class);
        $helper->waitForPageLoad($timeout, $waitCondition);
    }

    //########################################

    public function click($link, $context = null): void
    {
        $executionsNumber = 0;
        while (true) {

            try {
                $this->webDriver->click($link, $context);
                break;

            } catch (\Exception $e) {

                if ($executionsNumber < self::EXECUTIONS_NUMBER_BEFORE_FAIL) {

                    $this->webDriver->wait(1);
                    $this->waitForNoActiveAjax();
                    $executionsNumber++;
                    continue;
                }

                throw $e;
            }
        }
    }

    //########################################
}
