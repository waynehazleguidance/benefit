<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Module\BrowserStack;

class Api
{
    public const API_URL = 'https://api.browserstack.com/automate/';

    public const PROJECT_URN_PREFIX = 'projects';
    public const BUILD_URN_PREFIX   = 'builds';
    public const SESSION_URN_PREFIX = 'sessions';

    public const DONE_FILTER    = 'done';
    public const RUNNING_FILTER = 'running';
    public const FAILED_FILTER  = 'failed';

    public const PASSED_TEST_STATUS  = 'passed';
    public const FAILED_TEST_STATUS  = 'failed';
    
    /** @var \Guidance\Tests\Base\Module\BrowserStack\Connector */
    private $browserStackConnector = null;

    // ########################################

    public function __construct(
        \Guidance\Tests\Base\Module\BrowserStack\Api\Connector\Factory $browserStackConnectorFactory
    ) {
        $this->browserStackConnector = $browserStackConnectorFactory->create();
    }

    // ########################################
    
    public function getApiStatus()
    {
        return $this->browserStackConnector->getResponseData(self::API_URL . 'plan.json');
    }

    public function getCapabilities()
    {
        return $this->browserStackConnector->getResponseData(self::API_URL . 'browsers.json');
    }

    // ########################################

    public function getProjects()
    {
        return $this->browserStackConnector->getResponseData(self::API_URL . self::PROJECT_URN_PREFIX . '.json');
    }

    public function getProject(string $projectId)
    {
        return $this->browserStackConnector->getResponseData(self::API_URL . self::PROJECT_URN_PREFIX . '/' . $projectId . '.json');
    }

    public function updateProjectName(string $projectId, string $projectName)
    {
        return $this->browserStackConnector->getResponseData(
            self::API_URL . self::PROJECT_URN_PREFIX . '/' . $projectId . '.json',
            ['Content-Type' => 'application/json'],
            ['name' => $projectName]
        );
    }

    public function deleteProject(string $projectId)
    {
        return $this->browserStackConnector->getResponseData(
            self::API_URL . self::PROJECT_URN_PREFIX . '/' . $projectId . '.json',
            null,
            null,
            true
        );
    }

    // ########################################

    public function getBuilds(string $filterStatus = null)
    {
        return is_null($filterStatus)
            ? $this->browserStackConnector->getResponseData(self::API_URL . self::BUILD_URN_PREFIX . '.json')
            : $this->browserStackConnector->getResponseData(self::API_URL . self::BUILD_URN_PREFIX . '.json' . '?status=' . $filterStatus);
    }

    public function getBuild(string $buildId)
    {
        return $this->browserStackConnector->getResponseData(self::API_URL . self::BUILD_URN_PREFIX . '/' . $buildId . '.json');
    }

    public function updateBuildName(string $buildId, string $buildName)
    {
        return $this->browserStackConnector->getResponseData(
            self::API_URL . self::BUILD_URN_PREFIX . '/' . $buildId . '.json',
            ['Content-Type' => 'application/json'],
            ['name' => $buildName]
        );
    }

    public function deleteBuild(string $buildId)
    {
        return $this->browserStackConnector->getResponseData(
            self::API_URL . self::BUILD_URN_PREFIX . '/' . $buildId . '.json',
            null,
            null,
            true
        );
    }

    // ########################################

    public function getSessions(string $buildId, string $filterStatus = null)
    {
        return is_null($filterStatus)
            ? $this->browserStackConnector->getResponseData(self::API_URL . self::BUILD_URN_PREFIX . '/' . $buildId . '/' . self::SESSION_URN_PREFIX . '.json')
            : $this->browserStackConnector->getResponseData(self::API_URL . self::BUILD_URN_PREFIX . '/' . $buildId . '/' . self::SESSION_URN_PREFIX . '.json' . '?status=' . $filterStatus);
    }

    public function getSession(string $sessionId)
    {
        return $this->browserStackConnector->getResponseData(self::API_URL . self::SESSION_URN_PREFIX . '/' . $sessionId . '.json');
    }

    public function getSessionLogs(string $buildId, string $sessionId)
    {
        return $this->browserStackConnector->getResponseData(self::API_URL . self::BUILD_URN_PREFIX . '/' . $buildId . '/'
            . self::SESSION_URN_PREFIX . '/' . $sessionId . '/logs');
    }

    public function getNetworkLogs(string $buildId, string $sessionId)
    {
        return $this->browserStackConnector->getResponseData(self::API_URL . self::BUILD_URN_PREFIX . '/' . $buildId . '/'
            . self::SESSION_URN_PREFIX . '/' . $sessionId . '/networklogs');
    }

    public function getSessionConsoleLogs(string $buildId, string $sessionId)
    {
        return $this->browserStackConnector->getResponseData(self::API_URL . self::BUILD_URN_PREFIX . '/' . $buildId . '/'
            . self::SESSION_URN_PREFIX . '/' . $sessionId . '/consolelogs');
    }

    public function getSessionSeleniumLogs(string $buildId, string $sessionId)
    {
        return $this->browserStackConnector->getResponseData(self::API_URL . self::BUILD_URN_PREFIX . '/' . $buildId . '/'
            . self::SESSION_URN_PREFIX . '/' . $sessionId . '/seleniumlogs');
    }

    public function deleteNetworkLogs(string $buildId, string $sessionId)
    {
        return $this->browserStackConnector->getResponseData(
            self::API_URL . self::BUILD_URN_PREFIX . '/' . $buildId . '/' . self::SESSION_URN_PREFIX . '/' . $sessionId . '/networklogs.json',
            null,
            null,
            true
        );
    }

    public function deleteSession(string $sessionId)
    {
        return $this->browserStackConnector->getResponseData(
            self::API_URL . self::SESSION_URN_PREFIX . '/' . $sessionId . '.json',
            null,
            null,
            true
        );
    }

    // ########################################

    public function markTestAsPassed(string $sessionId, string $reason = '')
    {
        return $this->browserStackConnector->getResponseData(
            self::API_URL . self::SESSION_URN_PREFIX . '/' . $sessionId . '.json',
            ['Content-Type' => 'application/json'],
            ['status' => self::PASSED_TEST_STATUS, 'reason' => $reason]
        );
    }

    public function markTestAsFailed(string $sessionId, string $reason = '')
    {
        return $this->browserStackConnector->getResponseData(
            self::API_URL . self::SESSION_URN_PREFIX . '/' . $sessionId . '.json',
            ['Content-Type' => 'application/json'],
            ['status' => self::FAILED_TEST_STATUS, 'reason' => $reason]
        );
    }

    public function updateTestName(string $sessionId, string $testName)
    {
        return $this->browserStackConnector->getResponseData(
            self::API_URL . self::SESSION_URN_PREFIX . '/' . $sessionId . '.json',
            ['Content-Type' => 'application/json'],
            ['name' => $testName]
        );
    }

    // ########################################
}
