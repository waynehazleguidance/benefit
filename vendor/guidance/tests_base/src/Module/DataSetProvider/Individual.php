<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Module\DataSetProvider;

class Individual implements BaseInterface
{
    /** @var \Guidance\Tests\Base\Lib\DataManipulation\ArrayWrapper\Factory */
    private $arrayWrapperFactory = null;

    /** @var \Guidance\Tests\Base\FoldersStructure */
    private $foldersStructure = null;

    /** @var \Guidance\Tests\Base\Lib\FileSystem\File\Factory */
    private $filesystemFileFactory = null;

    /** @var \Guidance\Tests\Base\Object\ClassDescriber */
    private $describer = null;

    /** @var \Guidance\Tests\Base\Lib\DataManipulation\Json */
    private $json = null;

    // ########################################

    public function __construct(
        \Guidance\Tests\Base\Object\ClassDescriber $describer,
        \Guidance\Tests\Base\Lib\DataManipulation\ArrayWrapper\Factory $arrayWrapperFactory,
        \Guidance\Tests\Base\FoldersStructure $foldersStructure,
        \Guidance\Tests\Base\Lib\FileSystem\File\Factory $filesystemFileFactory,
        \Guidance\Tests\Base\Lib\DataManipulation\Json $json
    ) {
        $this->describer             = $describer;
        $this->arrayWrapperFactory   = $arrayWrapperFactory;
        $this->foldersStructure      = $foldersStructure;
        $this->filesystemFileFactory = $filesystemFileFactory;
        $this->json                  = $json;
    }

    // ########################################

    public function getFile(string $fileName): \Guidance\Tests\Base\Lib\FileSystem\File
    {
        return $this->filesystemFileFactory->create($this->getDataSetPath() . $fileName);
    }

    public function getData(string $wrappedDataPath)
    {
        $file = $this->filesystemFileFactory->create($this->getDataSetPath() . 'data.json');

        $data = $this->arrayWrapperFactory->create($this->json->decode($file->readData()));

        return $data->get($wrappedDataPath);
    }

    // ########################################

    private function getDataSetPath(): string
    {
        return $this->foldersStructure->getProjectDataPath() . 'individual' . DIRECTORY_SEPARATOR
            . str_replace('\\', DIRECTORY_SEPARATOR, lcfirst($this->describer->getRelativeNamespace()))
            . DIRECTORY_SEPARATOR;
    }

    // ########################################
}
