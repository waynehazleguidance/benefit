<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Module\Allure\ReportGenerator;

class Factory
{
    use \Guidance\Tests\Base\Object\FactoryTrait;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\ProjectConfig\Factory
     */
    private $projectConfigFactory = null;

    // ########################################

    public function create(array $options): \Guidance\Tests\Base\Module\Allure\ReportGenerator
    {
        $projectConfig = $this->projectConfigFactory->create();

        $configData = $projectConfig->get('/allure/report/');

        $commandPath = isset($options['command_path']) && ! empty($options['command_path'])
            ? $options['command_path']
            : 'allure';

        $emailRecipients = isset($options['email_recipients']) && ! empty($options['email_recipients'])
            ? explode(',', $options['email_recipients'])
            : [];

        $isResultEmailSendingEnabled = $configData['email']['is_enabled'] || ! empty($emailRecipients);

        return $this->di->make(
            \Guidance\Tests\Base\Module\Allure\ReportGenerator::class,
            [
                'localPath'                    => $configData['local_path'],
                'url'                          => $configData['url'],
                'commandPath'                  => $commandPath,
                'isResultEmailSendingEnabled'  => $isResultEmailSendingEnabled,
                'emailRecipients'              => $emailRecipients
            ]
        );
    }

    // ########################################
}
