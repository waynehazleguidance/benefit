<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Module\MailServices\TempMail;

class Api
{
    /** @var \Guidance\Tests\Base\Module\DataGenerator */
    private $dataGenerator = null;

    /** @var \Guidance\Tests\Base\Module\MailServices\TempMail\Api\Connector */
    private $tempMailApiConnector = null;

    /** @var array */
    private $domains = null;

    // ########################################

    public function __construct(
        \Guidance\Tests\Base\Module\MailServices\TempMail\Api\Connector\Factory $tempMailApiConnectorFactory,
        \Guidance\Tests\Base\Module\DataGenerator\Factory $dataGeneratorFactory
    ) {
        $this->tempMailApiConnector = $tempMailApiConnectorFactory->create();
        $this->dataGenerator        = $dataGeneratorFactory->create();
    }

    // ########################################

    public function createEmail(string $emailPrefix = null): string
    {
        $domains      = $this->getDomains();
        $randomDomain = $domains[array_rand($domains)];
        $emailPrefix  = $emailPrefix ?? $this->dataGenerator->getFirstName() . $this->dataGenerator->getLastName();

        return strtolower($emailPrefix) . $randomDomain;
    }

    public function getMessages(string $email): array
    {
        return $this->tempMailApiConnector->getResponseData('/request/mail/id/' . md5($email) . '/');
    }

    public function waitForAndGrabMessageByTitle(string $email, string $mailTitle, $timeout = 60, $delayBetweenCall = 5): array
    {
        sleep(3);

        $callQty = (int) round($timeout / $delayBetweenCall);

        for ($i = 0; $i < $callQty; $i++) {

            $messages = $this->getMessages($email);

            foreach ($messages as $message) {

                if (isset($message['mail_subject']) && strpos($message['mail_subject'], $mailTitle) !== false) {
                    return $message;
                }
            }
            sleep($delayBetweenCall);
        }

        throw new \RuntimeException("{$timeout} seconds passed, but email do not received yet.");
    }

    public function getDomains()
    {
        return $this->domains ?? $this->domains = $this->tempMailApiConnector->getResponseData('/request/domains/');
    }

    // ########################################
}