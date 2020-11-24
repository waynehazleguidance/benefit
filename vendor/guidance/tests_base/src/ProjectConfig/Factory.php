<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\ProjectConfig;

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

    public function create(): \Guidance\Tests\Base\ProjectConfig
    {
        $path = $this->foldersStructure->getProjectConfigsPath();

        $configDirectoryFilePaths = $this->foldersStructure->getDirectoryFilePaths($path, ['json', 'yml']);

        $wrappedData = $this->arrayWrapperFactory->create();

        foreach ($configDirectoryFilePaths as $filePath) {

            $file = $this->filesystemFileFactory->create($filePath);

            switch ($file->getExtension()) {
                case 'json': $data = $this->json->decode($file->readData());                 break;
                case 'yml' : $data = \Symfony\Component\Yaml\Yaml::parse($file->readData()); break;
                default:     $data = null;
            }

            $wrappedData->set($this->getKeyPrefix($filePath), $data);
        }

        return $this->di->make(
            \Guidance\Tests\Base\ProjectConfig::class,
            [
                'wrappedData' => $wrappedData
            ]
        );
    }

    // ########################################

    private function getKeyPrefix(string $filePath): string
    {
        $needle = DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR;

        $relativePath = substr($filePath, strpos($filePath, $needle) + strlen($needle));

        $pathInfo = pathinfo($relativePath);

        $directoryName = $pathInfo['dirname'] == '.'
            ? ''
            : '/' . str_replace(DIRECTORY_SEPARATOR, '/', $pathInfo['dirname']);

        return $directoryName . '/' . $pathInfo['filename'] . '/';
    }

    // ########################################
}
