<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Module\MailServices\TempMail\Api\Connector;

class Factory
{
    use \Guidance\Tests\Base\Object\FactoryTrait;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\ProjectConfig\Factory
     */
    private $configFactory = null;

    // ########################################

    public function create(): \Guidance\Tests\Base\Module\MailServices\TempMail\Api\Connector
    {
        $config = $this->configFactory->create();

        $key  = $config->get('/temp_mail_api/key/');
        $host = $config->get('/temp_mail_api/host/');

        $this->getStringValidator()
            ->assertNotEmpty($key)
            ->assertNotEmpty($host)
            ->assertNotConfigMock($key)
            ->assertNotConfigMock($host);

        return $this->di->make(
            \Guidance\Tests\Base\Module\MailServices\TempMail\Api\Connector::class,
            [
                'key'  => $key,
                'host' => $host
            ]
        );
    }
    // ########################################
}
