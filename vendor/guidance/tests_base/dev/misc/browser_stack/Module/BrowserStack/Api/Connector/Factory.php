<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Module\BrowserStack\Api\Connector;

class Factory
{
    use \Guidance\Tests\Base\Object\FactoryTrait;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Module\BrowserStack\Capabilities\Factory
     */
    private $capabilitiesFactory = null;

    // ########################################

    public function create(): \Guidance\Tests\Base\Module\BrowserStack\Api\Connector
    {
        $capabilities = $this->capabilitiesFactory->create();

        $user = $capabilities->get('/browserstack.user/');
        $key  = $capabilities->get('/browserstack.key/');

        $this->getStringValidator()
            ->assertNotEmpty($user)
            ->assertNotEmpty($key)
            ->assertNotConfigMock($user)
            ->assertNotConfigMock($user);

        return $this->di->make(\Guidance\Tests\Base\Module\BrowserStack\Api\Connector::class,
            [
                'connectionCredential' => $user . ':' . $key
            ]
        );
    }
    // ########################################
}
