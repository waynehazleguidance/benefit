<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Module\BrowserStack\Capabilities;

class Factory
{
    use \Guidance\Tests\Base\Object\FactoryTrait;

    public const CREDENTIAL_KEYS = ['browserstack.user', 'browserstack.key'];

    /**
     * @Inject
     * @var \Guidance\Tests\Base\ProjectConfig\Factory
     */
    private $projectConfigFactory = null;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Lib\DataManipulation\ArrayWrapper\Factory
     */
    private $arrayWrapperFactory;

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

    public function create(): \Guidance\Tests\Base\Module\BrowserStack\Capabilities
    {
        $projectConfig = $this->projectConfigFactory->create();

        $capabilities = $projectConfig->get('/codecept/browserstack/suites/'
            . addcslashes(\Guidance\Tests\Base\RuntimeContainer::getSuite(), '\\/') . '/modules/config/'
            . \Guidance\Tests\Base\Actor\WebDriver::class . '/capabilities/'
        );

        $wrappedCapabilities = $this->arrayWrapperFactory->create();

        $wrappedCapabilities->set(null, $capabilities);

        return $this->di->make(\Guidance\Tests\Base\Module\BrowserStack\Capabilities::class,
            [
                'wrappedCapabilities' => $wrappedCapabilities
            ]
        );
    }

    // ########################################
}
