<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Codeception\Extension;

class SendMail extends BaseAbstract
{
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

    /**
     * @Inject
     * @var \Guidance\Tests\Base\ProjectConfig\Factory
     */
    protected $configFactory = null;

    /**
     * @var array
     */
    public static $events = [\Codeception\Events::RESULT_PRINT_AFTER => 'sendMail'];

    // ########################################

    public function sendMail(\Codeception\Event\PrintResultEvent $e)
    {
        $isResultsEmailSendingEnabled = $this->configFactory->create()->get('/email/send_result/is_enabled/');

        if ($isResultsEmailSendingEnabled) {

            $mailer = New \Symfony\Component\Mailer\Mailer($this->gmailTransportFactory->create());

            $mailer->send($this->emailFactory->create());
        }
    }

    // ########################################
}
