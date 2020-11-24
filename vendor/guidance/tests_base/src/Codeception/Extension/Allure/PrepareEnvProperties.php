<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Codeception\Extension\Allure;

use \Guidance\Tests\Base\RuntimeContainer;
use \Guidance\Tests\Base\Codeception\Extension\Allure\Integration as AllureIntegration;

class PrepareEnvProperties extends \Guidance\Tests\Base\Codeception\Extension\BaseAbstract
{
    private const STAND_PROPERTY = 'stand';
    private const WEBSITE_PROPERTY = 'website';
    private const BROWSER_PROPERTY = 'browser';

    /**
     * @Inject
     * @var \Guidance\Tests\Base\FoldersStructure
     */
    private $foldersStructure = null;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Lib\FileSystem\Manager\Factory
     */
    private $filesystemManagerFactory = null;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Lib\FileSystem\Directory\Factory
     */
    private $filesystemDirectoryFactory = null;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Lib\FileSystem\File\Factory
     */
    private $filesystemFileFactory = null;

    /**
     * @var array
     */
    public static $events = [\Codeception\Events::SUITE_INIT => 'prepareEnvProperties'];

    // ########################################

    public function prepareEnvProperties(\Codeception\Event\SuiteEvent $e)
    {
        $previousEnvFilePath = $this->foldersStructure->getProjectVarsPath() . 'output/'
            . AllureIntegration::DEFAULT_RESULTS_DIRECTORY . '/environment.properties';

        $filesystemManager = $this->filesystemManagerFactory->create();

        if ($filesystemManager->isFileExist($previousEnvFilePath)) {

            $previousEnvFile = $this->filesystemFileFactory->create($previousEnvFilePath);
            $previousEnvs    = $this->parseEnvFile($previousEnvFile);
            
            if ($this->getCurrentEnvs() != $previousEnvs) {

                $outputDirectoryPath  = $this->foldersStructure->getProjectVarsPath() . 'output';
                $outputDirectory      = $this->filesystemDirectoryFactory->create($outputDirectoryPath);
                $outputDirectoryItems = $filesystemManager->getDirectoryItems($outputDirectory);

                foreach ($outputDirectoryItems as $outputDirectoryItem) {
                    $filesystemManager->deleteItem($outputDirectoryItem);
                }

                $envFile = $filesystemManager->createFile($previousEnvFilePath);
                $envFile->writeData($this->envsToString($this->getCurrentEnvs()));
            }

        } else {
            $envFile = $filesystemManager->createFile($previousEnvFilePath);
            $envFile->writeData($this->envsToString($this->getCurrentEnvs()));
        }
    }

    // ########################################

    private function getConfigData()
    {
        $configFilePath = \Guidance\Tests\Base\Codeception\Launcher::getConfigFilePath();
        $configFile     = $this->filesystemFileFactory->create($configFilePath);

        return \Symfony\Component\Yaml\Yaml::parse($configFile->readData());
    }

    private function parseEnvFile(\Guidance\Tests\Base\Lib\FileSystem\File $envFile): array
    {
        $envData = $envFile->readData();

        $envDataArr = explode(PHP_EOL, trim($envData));

        $result = [];
        foreach ($envDataArr as $envDatavalue) {
            $keyValueRelation = explode('=', $envDatavalue);
            $result[trim($keyValueRelation[0])] = trim($keyValueRelation[1]);
        }

        return $result;
    }

    private function getCurrentEnvs(): array
    {
        $envProperties = [self::STAND_PROPERTY, self::WEBSITE_PROPERTY, self::BROWSER_PROPERTY];

        $result = [];
        foreach ($envProperties as $envProperty) {
            switch ($envProperty) {
                case self::STAND_PROPERTY: $result[self::STAND_PROPERTY] = RuntimeContainer::getEnvironment(); break;
                case self::WEBSITE_PROPERTY: $result[self::WEBSITE_PROPERTY] = RuntimeContainer::getWebsite(); break;
                case self::BROWSER_PROPERTY:

                    $configData = $this->getConfigData();

                    $browserName = $configData['suites'][RuntimeContainer::getSuite()]['modules']['config']
                    [\Guidance\Tests\Base\Actor\WebDriver::class]['browser'];

                    $result[self::BROWSER_PROPERTY] = $browserName; break;
            }
        }

        return $result;
    }

    private function envsToString(array $envs)
    {
        $result = '';
        foreach ($envs as $envKey => $envValue) {
            $result .= $envKey . ' = ' . $envValue . PHP_EOL;
        }

        return $result;
    }

    // ########################################
}
