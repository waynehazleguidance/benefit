<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Module\BrowserStack\Local;

class Factory
{
    use \Guidance\Tests\Base\Object\FactoryTrait;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Module\BrowserStack\Capabilities\Factory
     */
    private $capabilitiesFactory = null;

    // ########################################

    public function create(): \Guidance\Tests\Base\Module\BrowserStack\Local
    {
        $capabilities = $this->capabilitiesFactory->create();

        return $this->di->make(\Guidance\Tests\Base\Module\BrowserStack\Local::class,
            [
                'credentialKey' => $capabilities->get('/browserstack.key/'),
                'bsLocalArgs'   => $capabilities->get('/browserstackLocalArgs/')
            ]
        );
    }
    // ########################################
}
