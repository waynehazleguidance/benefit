<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Module\DataSetProvider\General;

class Factory
{
    use \Guidance\Tests\Base\Object\FactoryTrait;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Lib\DataManipulation\Json
     */
    private $json;

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

    public function create(): \Guidance\Tests\Base\Module\DataSetProvider\General
    {
        $path = $this->foldersStructure->getProjectDataPath() . 'general' . DIRECTORY_SEPARATOR;

        /** @var \Guidance\Tests\Base\Lib\FileSystem\File[] $dataDirectoryJsonFiles */
        $dataDirectoryJsonFilePaths = $this->foldersStructure->getDirectoryFilePaths($path, ['json']);

        $wrappedData = $this->arrayWrapperFactory->create();

        foreach ($dataDirectoryJsonFilePaths as $jsonFilePath) {

            $jsonFile = $this->filesystemFileFactory->create($jsonFilePath);
            $jsonData = $this->json->decode($jsonFile->readData());

            $wrappedData->set($this->getKeyPrefix($jsonFilePath), $jsonData);
        }

        return $this->di->make(
            \Guidance\Tests\Base\Module\DataSetProvider\General::class,
            [
                'wrappedData' => $wrappedData
            ]
        );
    }

    // ########################################

    private function getKeyPrefix(string $filePath): string
    {
        $needle = DIRECTORY_SEPARATOR . 'general' . DIRECTORY_SEPARATOR;

        $relativePath = substr($filePath, strpos($filePath, $needle) + strlen($needle));

        $pathInfo = pathinfo($relativePath);

        $directoryName = $pathInfo['dirname'] == '.'
            ? ''
            : '/' . str_replace(DIRECTORY_SEPARATOR, '/', $pathInfo['dirname']);

        return $directoryName . '/' . $pathInfo['filename'] . '/';
    }

    // ########################################
}
