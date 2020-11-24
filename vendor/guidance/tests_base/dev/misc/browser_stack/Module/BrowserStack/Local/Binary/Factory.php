<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Module\BrowserStack\Local\Binary;

use \Guidance\Tests\Base\Lib\System;

class Factory
{
    use \Guidance\Tests\Base\Object\FactoryTrait;

    const BINARY_NAME = 'BrowserStackLocal';

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

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Lib\FileSystem\Manager\Factory
     */
    private $filesystemManagerFactory = null;

    // ########################################

    public function create(): \Guidance\Tests\Base\Module\BrowserStack\Local\Binary
    {
        if (System::getOS() === System::OS_UNKNOWN) {
            throw new \LogicException('Unknown Operation System: ' . PHP_OS);
        }

        $binaryFileDirectory = $this->foldersStructure->getProjectVarsPath() . 'data' . DIRECTORY_SEPARATOR
            . 'browserstack' . DIRECTORY_SEPARATOR . 'local' . DIRECTORY_SEPARATOR;

        $filesystemManager = $this->filesystemManagerFactory->create();

        if ( ! $filesystemManager->isDirectoryExist($binaryFileDirectory)) {
            $filesystemManager->createDirectory($binaryFileDirectory);
        }

        $fileExtension  = System::getOS() === System::OS_WIN ? '.exe' : '';

        $binaryFile = $this->filesystemFileFactory->create($binaryFileDirectory . self::BINARY_NAME . $fileExtension);

        return $this->di->make(\Guidance\Tests\Base\Module\BrowserStack\Local\Binary::class,
            [
                'binaryFile' => $binaryFile
            ]
        );
    }

    // ########################################
}
