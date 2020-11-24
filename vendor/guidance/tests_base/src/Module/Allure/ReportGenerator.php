<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Module\Allure;

use \Guidance\Tests\Base\Codeception\Extension\Allure\Integration as AllureIntegration;

class ReportGenerator
{
    /** @var bool */
    private $isResultEmailSendingEnabled = null;

    /** @var array */
    private $emailRecipients = [];

    /** @var string  */
    private $commandPath = null;

    /** @var string */
    private $localPath = null;

    /** @var string */
    private $url = null;

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
     * @var \Guidance\Tests\Base\Lib\FileSystem\File\Factory
     */
    private $filesystemFileFactory = null;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Module\MailServices\Mailer\Email\Factory
     */
    private $emailFactory = null;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Module\MailServices\Mailer\Transport\Gmail\Factory
     */
    private $gmailTransportFactory = null;

    // ########################################

    public function __construct(
        string $localPath,
        string $url,
        bool $isResultEmailSendingEnabled,
        array $emailRecipients,
        string $commandPath
    ) {
        $this->localPath                   = $localPath;
        $this->url                         = $url;
        $this->isResultEmailSendingEnabled = $isResultEmailSendingEnabled;
        $this->emailRecipients             = $emailRecipients;
        $this->commandPath                 = $commandPath;
    }

    // ########################################

    public function process(): void
    {
        //copy categories.json allure config file to results directory
        $filesystemManager = $this->filesystemManagerFactory->create();

        $allureResultsDirectoryPath = $this->foldersStructure->getProjectVarsPath() . 'output/'
            . AllureIntegration::DEFAULT_RESULTS_DIRECTORY . '/';

        if ( ! $filesystemManager->isDirectoryExist($allureResultsDirectoryPath)) {
            throw new \LogicException('There is no '
                . \Guidance\Tests\Base\Codeception\Extension\Allure\Integration::DEFAULT_RESULTS_DIRECTORY
                . ' directory. You should run tests before launch report generation.');
        }

        $filesystemManager->copyFile(
            $this->foldersStructure->getProjectConfigsPath() . 'allure/categories.json',
            $allureResultsDirectoryPath . 'categories.json'
        );

        //prepare build hash
        $envPropertiesFilePath = $allureResultsDirectoryPath . 'environment.properties';

        if ( ! $filesystemManager->isFileExist($envPropertiesFilePath)) {
            throw new \LogicException('There is no Allure environment file "' . $envPropertiesFilePath . '"');
        }

        $envPropertiesFile = $this->filesystemFileFactory->create($envPropertiesFilePath);

        $envPropertiesData = trim($envPropertiesFile->readData());

        $buildHash = sha1($envPropertiesData);

        $buildDir = $this->prepareBuildDir($buildHash);

        //execute generate command
        $generateCommand = $this->commandPath . ' -v generate ' . $this->foldersStructure->getProjectVarsPath() . 'output/'
            . AllureIntegration::DEFAULT_RESULTS_DIRECTORY . ' -c -o ' . $buildDir . ' 2>&1';

        $generateCommandOutput = shell_exec($generateCommand);

        //write generate command output to log file
        $allureGenerateCommandLogFilePath = $this->foldersStructure->getProjectVarsPath()
            . 'output/allure/generate_command.log';

        $allureGenerateCommandLogFile = $filesystemManager->isFileExist($allureGenerateCommandLogFilePath)
            ? $filesystemManager->getFile($allureGenerateCommandLogFilePath)
            : $filesystemManager->createFile($allureGenerateCommandLogFilePath);

        $allureGenerateCommandLogFile->writeData($generateCommandOutput);

        echo "See report generate command output in '{$allureGenerateCommandLogFilePath}'";

        //add .htaccess file to get directory access
        $htaccessFilePath = $buildDir . '/.htaccess';

        $htaccessFile = $filesystemManager->isFileExist($htaccessFilePath)
            ? $filesystemManager->getFile($htaccessFilePath)
            : $filesystemManager->createFile($htaccessFilePath);

        $filesystemManager->changePermission($htaccessFile, 0777);

        $htaccessFile->writeData('Order allow,deny' . PHP_EOL . 'Allow from all');

        $buildUrl = trim($this->url, '/') . '/build/' . $buildHash;

        echo  PHP_EOL . 'Build url:' . PHP_EOL . $buildUrl . PHP_EOL;

        //log build
        $dateTime = new \DateTime();

        $logData = '[' . $dateTime->format('Y/m/d H:i:s') . '] properties: [';

        $envPropertiesArr = explode(PHP_EOL, $envPropertiesData);

        $i = 0;
        foreach ($envPropertiesArr as $envProperty) {
            $logData .= $envProperty;

            if (++$i != count($envPropertiesArr)) {
                $logData .= ', ';
            }
        }

        $logData .= ']; build_url: ' . $buildUrl . PHP_EOL;

        $buildLogFilePath = $this->foldersStructure->getProjectVarsPath()
            . 'output/allure/build.log';

        $buildLogFile = $filesystemManager->isFileExist($buildLogFilePath)
            ? $filesystemManager->getFile($buildLogFilePath)
            : $filesystemManager->createFile($buildLogFilePath);

        $buildLogFile->writeData($logData, FILE_APPEND);

        //send email
        if ($this->isResultEmailSendingEnabled) {

            $mailer = New \Symfony\Component\Mailer\Mailer($this->gmailTransportFactory->create());

            $email = $this->emailFactory->create($buildUrl);

            foreach ($this->emailRecipients as $emailRecipient) {
                $email->addTo($emailRecipient);
            }

            $mailer->send($email);
        }
    }

    // ########################################

    private function prepareBuildDir(string $buildHash)
    {
        $filesystemManager = $this->filesystemManagerFactory->create();

        $buildDir = rtrim($this->localPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'build';

        if ( ! $filesystemManager->isDirectoryExist($buildDir)) {
            $filesystemManager->createDirectory($buildDir);
        }

        $buildDir .= DIRECTORY_SEPARATOR . $buildHash;

        if ( ! $filesystemManager->isDirectoryExist($buildDir)) {
            echo 'Create New Build Directory : ' . $buildHash . PHP_EOL;
            $filesystemManager->createDirectory($buildDir);

        } else {
            echo 'Use Existing Build Directory : ' . $buildHash . PHP_EOL;
        }

        return $buildDir;
    }

    // ########################################
}
