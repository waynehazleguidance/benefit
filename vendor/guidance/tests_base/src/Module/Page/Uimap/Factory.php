<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Module\Page\Uimap;

class Factory
{
    use \Guidance\Tests\Base\Object\FactoryTrait;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Lib\DataManipulation\ArrayWrapper\Factory
     */
    private $arrayWrapperFactory = null;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\FoldersStructure
     */
    private $foldersStructure = null;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Lib\FileSystem\Manager
     */
    private $fileSystemManager = null;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Lib\FileSystem\File\Factory
     */
    private $fileSystemFile = null;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Object\ClassDescriber\Factory
     */
    private $classDescriberFactory = null;

    // ########################################

    public function create(\Guidance\Tests\Base\Module\Page\BaseAbstract $pageObject): \Guidance\Tests\Base\Module\Page\Uimap
    {
        $uimapConfigPath = $this->getUimapConfigFilePath($pageObject);

        if ( ! $this->fileSystemManager->isFileExist($uimapConfigPath)) {

            $templateFile = $this->fileSystemFile->create(
                $this->foldersStructure->getProjectConfigsPath() . 'uimap' . DIRECTORY_SEPARATOR . 'Template.yml');

            $configFile = $this->fileSystemManager->createFile($uimapConfigPath);
            $configFile->writeData($templateFile->readData());
        }

        $uimap = $this->di->make(
            \Guidance\Tests\Base\Module\Page\Uimap::class,
            [
                'wrappedData' => $this->getUimapData($uimapConfigPath)
            ]
        );

        $this->di->set(\Guidance\Tests\Base\Module\Page\Uimap::class, $uimap);

        return $uimap;
    }

    // ########################################

    private function getUimapConfigFilePath($pageObject): string
    {
        $classDescriber = $this->classDescriberFactory->create($pageObject);

        $pos = strpos($classDescriber->getRelativeNamespace(), 'Page');

        $relativeUimapPath = substr($classDescriber->getRelativeNamespace(), $pos + strlen('Page'));
        $relativeUimapPath = str_replace('\\', DIRECTORY_SEPARATOR, $relativeUimapPath);

        return $this->foldersStructure->getProjectConfigsPath() . 'uimap'   . $relativeUimapPath . '.yml';
    }

    private function getUimapData(string $configFilePath): \Guidance\Tests\Base\Lib\DataManipulation\ArrayWrapper
    {
        $wrappedData = $this->arrayWrapperFactory->create();
        $data        = \Symfony\Component\Yaml\Yaml::parseFile($configFilePath);

        return $wrappedData->set(null, $data);
    }

    // ########################################
}
