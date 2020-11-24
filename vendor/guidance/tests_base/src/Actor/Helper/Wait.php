<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Actor\Helper;

class Wait extends \Codeception\Module
{
    /** @var \Guidance\Tests\Base\Actor\WebDriver */
    private $webDriver = null;

    //########################################

    public function _beforeSuite($settings = []): void
    {
        $this->webDriver = $this->getModule(\Guidance\Tests\Base\Actor\WebDriver::class);
    }

    //########################################

    public function waitForJsObjectLoad(string $objectName, int $timeout = 10)
    {
        $this->webDriver->waitForJS('return typeof ' . $objectName . ' != "undefined";', $timeout);
    }

    public function waitForPageLoad(int $timeout = 180, callable $callback = null)
    {
        $condition = function (\Facebook\WebDriver\Remote\RemoteWebDriver $remoteWebDriver) use ($callback) {

            $isPageLoaded = $this->webDriver->executeJS('return document.readyState == "complete";');

            return ($callback === null)
                ? $isPageLoaded
                : $isPageLoaded && $callback($remoteWebDriver);
        };

        $this->webDriver->executeInSelenium(
            function (\Facebook\WebDriver\Remote\RemoteWebDriver $remoteWebDriver) use ($timeout, $condition) {
                $remoteWebDriver->wait($timeout)->until($condition);
            }
        );
    }

    //########################################
}
