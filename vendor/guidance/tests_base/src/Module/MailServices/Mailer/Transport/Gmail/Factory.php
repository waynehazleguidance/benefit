<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Module\MailServices\Mailer\Transport\Gmail;

class Factory
{
    use \Guidance\Tests\Base\Object\FactoryTrait;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\ProjectConfig\Factory
     */
    private $configFactory = null;

    // ########################################

    public function create(): \Symfony\Component\Mailer\Bridge\Google\Transport\GmailSmtpTransport
    {
        $config = $this->configFactory->create();
        /** @var string $username */
        $username = $config->get('/allure/report/email/transport/gmail/username/');

        /** @var string $password */
        $password = $config->get('/allure/report/email/transport/gmail/api_password/');

        $this->getStringValidator()
            ->assertNotEmpty($username)
            ->assertNotEmpty($password)
            ->assertNotConfigMock($username)
            ->assertNotConfigMock($password);

        $gmailTransport = new \Symfony\Component\Mailer\Bridge\Google\Transport\GmailSmtpTransport($username, $password);

        /** @var \Symfony\Component\Mailer\Transport\Smtp\Stream\SocketStream $stream */
        $stream = $gmailTransport->getStream();

        $stream->setStreamOptions(array('ssl' => array(
            'verify_peer'       => false,
            'verify_peer_name'  => false,
            'allow_self_signed' => true
        )));

        return $gmailTransport;
    }

    // ########################################
}