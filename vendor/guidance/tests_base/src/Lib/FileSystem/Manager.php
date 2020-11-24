<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\FileSystem;

class Manager
{
    /** @var \Guidance\Tests\Base\Lib\FileSystem\Directory\Factory */
    private $directoryFactory = null;

    /** @var \Guidance\Tests\Base\Lib\FileSystem\Directory\Items\Factory */
    private $directoryItemsFactory = null;

    /** @var \Guidance\Tests\Base\Lib\FileSystem\File\Factory */
    private $fileFactory = null;

    // ########################################

    public function __construct(
        Directory\Factory $directoryFactory,
        Directory\Items\Factory $directoryItemsFactory,
        File\Factory $fileFactory
    ) {
        $this->directoryFactory      = $directoryFactory;
        $this->directoryItemsFactory = $directoryItemsFactory;
        $this->fileFactory           = $fileFactory;
    }

    // ########################################

    public function isDirectoryExist(string $path): bool
    {
        clearstatcache(true, $path);

        return is_dir($path);
    }

    public function createDirectory(string $path): \Guidance\Tests\Base\Lib\FileSystem\Directory
    {
        if ($this->isDirectoryExist($path)) {
            throw new \LogicException("Directory '{$path}' is already exists.");
        }

        if (mkdir($path, 0777, true) === false) {
            throw new \RuntimeException("Unable to create the directory $path.");
        }

        return $this->directoryFactory->create($path);
    }

    public function getParentDirectoryPath(string $path): string
    {
        return dirname($path) . '/';
    }

    public function getDirectory(string $path): \Guidance\Tests\Base\Lib\FileSystem\Directory
    {
        $realpath = realpath($path);
        if ($realpath === false) {
            throw new \LogicException("Directory '{$path}' is not found.");
        }

        return $this->directoryFactory->create($realpath);
    }

    public function getDirectoryItems(Directory $directory): Directory\Items
    {
        if ( ! $directory->isExist()) {
            throw new \LogicException("Directory {$directory->getPath()} is not found.");
        }

        $result = $this->directoryItemsFactory->create();
        foreach (array_diff(scandir($directory->getPath()), ['.', '..']) as $item) {
            $itemPath = $directory->getPath() . $item;
            if (is_file($itemPath)) {
                $item = $this->fileFactory->create($itemPath);
            } else {
                $item = $this->directoryFactory->create($itemPath);
            }

            $result->addItem($item);
        }

        return $result;
    }

    public function copyDirectory(
        $sourceDirectoryPath,
        $destinationDirectoryPath
    ): void {
        $sourceDirectoryPath      = rtrim($sourceDirectoryPath, '/\\') . '/';
        $destinationDirectoryPath = rtrim($destinationDirectoryPath, '/\\') . '/';

        if ( ! $this->isDirectoryExist($sourceDirectoryPath)) {
            throw new \LogicException('Source directory is not exist.');
        }

        if ( ! $this->isDirectoryExist($destinationDirectoryPath)) {
            $this->createDirectory($destinationDirectoryPath);
        } else {
            if ( ! $this->getDirectory($destinationDirectoryPath)->isWritable()) {
                throw new \LogicException('Unable to copy to destination directory.');
            }
        }

        $sourceDirectory = $this->getDirectory($sourceDirectoryPath);
        foreach ($this->getDirectoryItems($sourceDirectory) as $sourceDirectoryItem) {
            if ($sourceDirectoryItem->isDirectory()) {
                $this->copyDirectory(
                    $sourceDirectoryPath . $sourceDirectoryItem->getName(),
                    $destinationDirectoryPath . $sourceDirectoryItem->getName()
                );
            } else {
                $this->copyFile(
                    $sourceDirectoryPath . $sourceDirectoryItem->getFullName(),
                    $destinationDirectoryPath . $sourceDirectoryItem->getFullName()
                );
            }
        }
    }

    // ########################################

    public function isFileExist(string $path): bool
    {
        clearstatcache(true, $path);

        return is_file($path);
    }

    public function createFile(string $path): \Guidance\Tests\Base\Lib\FileSystem\File
    {
        if ($this->isFileExist($path)) {
            throw new \LogicException("File '{$path}' is already created.");
        }

        $parentDirectory = $this->getParentDirectoryPath($path);
        if ( ! $this->isDirectoryExist($parentDirectory)) {
            $this->createDirectory($parentDirectory);
        }

        if (touch($path) === false) {
            throw new \RuntimeException("Unable to create the file {$path}.");
        }

        return $this->fileFactory->create($path);
    }

    public function getFile(string $path): \Guidance\Tests\Base\Lib\FileSystem\File
    {
        $realpath = realpath($path);
        if ($realpath === false) {
            throw new \LogicException("File '{$path}' is not found.");
        }

        return $this->fileFactory->create($realpath);
    }

    public function copyFile(string $sourcePath, string $destinationPath): void
    {
        if (copy($sourcePath, $destinationPath) == false) {
            throw new \RuntimeException("Unable to copy file '{$sourcePath}' to '{$destinationPath}'.");
        }
    }

    // ########################################

    public function getSize(BaseAbstract $item): int
    {
        if ( ! $item->isExist()) {
            throw new \LogicException("{$item->getPath()} is not found.");
        }

        if ($item->isFile()) {
            return filesize($item->getPath());
        }

        $result = 0;
        /** @var \Guidance\Tests\Base\Lib\FileSystem\Directory $item */
        foreach ($this->getDirectoryItems($item) as $directoryItem) {
            $result += $this->getSize($directoryItem);
        }

        return $result;
    }

    public function deleteItem(BaseAbstract $item): void
    {
        if ( ! $item->isExist()) {
            return;
        }

        if ($item->isSymlink()) {
            if (!unlink($item->getPath())) {
                throw new \RuntimeException('Unable to delete symlink.');
            }

            return;
        }

        if ($item->isFile()) {
            if (!unlink($item->getPath())) {
                throw new \RuntimeException('Unable to delete file.');
            }

            return;
        }

        /** @var \Guidance\Tests\Base\Lib\FileSystem\Directory $item */
        foreach ($this->getDirectoryItems($item) as $directoryItem) {
            $this->deleteItem($directoryItem);
        }

        if (!rmdir($item->getPath())) {
            throw new \RuntimeException('Unable to delete directory.');
        }
    }

    // ########################################

    public function changePermission(BaseAbstract $item, $permission): void
    {
        if ( ! $item->isExist()) {
            throw new \LogicException("{$item->getPath()} is not found.");
        }

        if (chmod($item->getPath(), $this->preparePermission($permission)) === false) {
            throw new \RuntimeException('Unable to change permission for item.');
        }
    }

    private function preparePermission($permission): int
    {
        return is_string($permission) ? octdec($permission) : (int)$permission;
    }

    // #######################################
}
