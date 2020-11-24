<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Module\MailServices\Mailer\Email;

class Factory
{
    use \Guidance\Tests\Base\Object\FactoryTrait;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\ProjectConfig\Factory
     */
    private $configFactory = null;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\FoldersStructure
     */
    private $foldersStructure;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Lib\FileSystem\File\Factory
     */
    private $filesystemFileFactory = null;

    // ########################################

    public function create(string $allureBuildLink): \Symfony\Component\Mime\Email
    {
        $config = $this->configFactory->create();

        /** @var string $username */
        $username = $config->get('/allure/report/email/transport/gmail/username/');

        $this->getStringValidator()
            ->assertNotEmpty($username)
            ->assertNotConfigMock($username);

        $recipients = $config->get('/allure/report/email/data/recipients/');

        $this->getArrayValidator()->assertNotEmpty($recipients);

        $cc  = $config->get('/allure/report/email/data/cc/');
        $bcc = $config->get('/allure/report/email/data/bcc/');

        $email = new \Symfony\Component\Mime\Email();

        foreach ($recipients as $recipient) {
            $email->addTo($recipient);
        }

        if (!empty($cc)) {
            foreach ($cc as $ccValue) {
                $email->addCc($ccValue);
            }
        }

        if (!empty($bcc)) {
            foreach ($bcc as $bccValue) {
                $email->addBcc($bccValue);
            }
        }

        $emailHtml = '<div style="margin-bottom: 15px;color: #062784; font-size: 20px; "><a href="' . $allureBuildLink
            . '" style="color: inherit;" target="_blank">' . $allureBuildLink . '</a></div>';

        return $email
            ->from($username)
            ->subject('Allure report link')
            ->html($emailHtml);
    }

    // ########################################
}
