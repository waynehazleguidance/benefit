<?php

declare(strict_types=1);

namespace Guidance\Tests\Base;

class FoldersStructure
{
    /** @var string */
    private $projectRootPath;

    // ########################################

    public function __construct(string $projectRootPath)
    {
        $this->projectRootPath = $projectRootPath;
    }

    // ########################################

    public function getRootPath(string $layer): string
    {
        return ($layer == ProjectInfo::CHILD_LAYER_NAME) ? $this->projectRootPath : $this->getBaseRootPath();
    }

    public function getConfigsPath(string $layer): string
    {
        $rootPath = ($layer == ProjectInfo::CHILD_LAYER_NAME) ? $this->projectRootPath : $this->getBaseRootPath();
        return $rootPath . 'config' . DIRECTORY_SEPARATOR;
    }

    public function getDataPath(string $layer): string
    {
        $rootPath = ($layer == ProjectInfo::CHILD_LAYER_NAME) ? $this->projectRootPath : $this->getBaseRootPath();
        return $rootPath . 'data' . DIRECTORY_SEPARATOR;
    }

    // ########################################

    public function getProjectRootPath(): string
    {
        return $this->projectRootPath;
    }

    public function getProjectConfigsPath(): string
    {
        return $this->getProjectRootPath() . 'config' . DIRECTORY_SEPARATOR;
    }

    public function getProjectDataPath(): string
    {
        return $this->getProjectRootPath() . 'data' . DIRECTORY_SEPARATOR;
    }

    public function getProjectVarsPath(): string
    {
        return $this->getProjectRootPath() . 'vars' . DIRECTORY_SEPARATOR;
    }

    // ########################################

    public function getBaseRootPath(): string
    {
        return $this->projectRootPath
            . 'vendor'           . DIRECTORY_SEPARATOR
            . ProjectInfo::OWNER . DIRECTORY_SEPARATOR
            . ProjectInfo::NAME  . DIRECTORY_SEPARATOR;
    }

    public function getBaseConfigsPath(): string
    {
        return $this->getBaseRootPath() . 'config' . DIRECTORY_SEPARATOR;
    }

    public function getBaseDataPath(): string
    {
        return $this->getBaseRootPath() . 'data' . DIRECTORY_SEPARATOR;
    }

    // ########################################

    public function getDirectoryFilePaths(string $directory, array $extensions, array &$results = []): array
    {
        $directoryContent = array_diff(scandir($directory), array('.', '..'));

        foreach ($directoryContent as $value) {

            $path = realpath($directory . DIRECTORY_SEPARATOR . $value);

            if (is_dir($path)) {

                $this->getDirectoryFilePaths($path, $extensions, $results);
                continue;
            }

            if ( ! in_array(pathinfo($path)['extension'], $extensions)) {
                continue;
            }

            $results[] = $path;
        }
        return $results;
    }

    // ########################################
}
