<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Actor\Helper;

class Tab extends \Codeception\Module
{
    /** @var \Guidance\Tests\Base\Actor\WebDriver */
    private $webDriver = null;

    //########################################

    public function _beforeSuite($settings = []): void
    {
        $this->webDriver = $this->getModule(\Guidance\Tests\Base\Actor\WebDriver::class);
    }

    //########################################

    public function openUrlInCurrentTab(string $url)
    {
        $this->webDriver->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $remoteWebDriver) use ($url) {
            $remoteWebDriver->get($url);
        });
    }

    public function openUrlInNewTab(string $url)
    {
        $this->webDriver->executeJS("window.open('{$url}', '_blank');");
        $this->webDriver->switchToNextTab();
    }

    public function openUrlInNewTabOverFixedTime(string $url, int $timeout = 10, callable $callback = null)
    {
        if ($this->webDriver->_getConfig('browser') !== 'chrome') {

            throw new \RuntimeException(__METHOD__ . ' only works with Chrome browser.');
        }

        $this->openUrlInNewTab($url);

        $windowHandle = $this->getWindowHandle();

        $this->webDriver->executeInSelenium(
            function (\Facebook\WebDriver\Remote\RemoteWebDriver $remoteWebDriver) use ($timeout, $callback) {
                ($callback === null)
                    ? $remoteWebDriver->wait($timeout)
                    : $remoteWebDriver->wait($timeout)->until($callback);
            }
        );

        $this->openUrlInNewTab('chrome://net-internals/#sockets');

        $this->webDriver->click(['id' => 'sockets-view-flush-button']);
        $this->webDriver->closeTab();

        $this->switchToTabByHandle($windowHandle);
    }

    //########################################

    public function getWindowHandle(): string
    {
        return $this->webDriver->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webDriver) {
            return $webDriver->getWindowHandle();
        });
    }

    public function getWindowHandles(): array
    {
        return $this->webDriver->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webDriver) {
            return $webDriver->getWindowHandles();
        });
    }

    //########################################

    public function getOpenedTabsCount(): int
    {
        $windowHandles = $this->webDriver->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
            return $webdriver->getWindowHandles();
        });

        return \count($windowHandles);
    }

    public function haveOpenedTabsCount(int $tabsCount)
    {
        $this->assertEquals($this->getOpenedTabsCount(), $tabsCount);
    }

    //########################################

    public function switchToFirstTab()
    {
        $this->webDriver->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
            $handles = $webdriver->getWindowHandles();

            $firstWindow = reset($handles);

            $webdriver->switchTo()->window($firstWindow);
        });
    }

    public function switchToLastTab()
    {
        $this->webDriver->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
            $handles = $webdriver->getWindowHandles();

            $lastWindow = end($handles);

            $webdriver->switchTo()->window($lastWindow);
        });
    }

    public function switchToTabByHandle(string $handle)
    {
        $this->webDriver->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webDriver) use ($handle) {
            $webDriver->switchTo()->window($handle);
        });
    }

    //########################################
}
