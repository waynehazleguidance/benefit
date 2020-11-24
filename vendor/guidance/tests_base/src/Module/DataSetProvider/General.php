<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Module\DataSetProvider;

class General implements BaseInterface
{
    /** @var \Guidance\Tests\Base\Lib\DataManipulation\ArrayWrapper */
    private $wrappedData = null;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\FoldersStructure
     */
    private $foldersStructure = null;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Lib\FileSystem\File\Factory
     */
    private $filesystemFileFactory = null;

    // ########################################

    public function __construct(\Guidance\Tests\Base\Lib\DataManipulation\ArrayWrapper $wrappedData)
    {
        $this->wrappedData = $wrappedData;
    }

    // ########################################

    public function getFile(string $relativeFilePath): \Guidance\Tests\Base\Lib\FileSystem\File
    {
        $relativeFilePath = ltrim($relativeFilePath, '/');

        $filePath = $this->foldersStructure->getProjectDataPath() . 'general/' . $relativeFilePath;

        return $this->filesystemFileFactory->create($filePath);
    }

    public function getData(string $key)
    {
        return $this->wrappedData->get($key);
    }

    // ########################################
}
