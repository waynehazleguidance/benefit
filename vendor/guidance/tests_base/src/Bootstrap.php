<?php

declare(strict_types=1);

namespace Guidance\Tests\Base;

class Bootstrap
{
    /** @var bool */
    private $isInitialized = false;

    /** @var string */
    private $projectRootPath;

    // ########################################

    final public function __construct(string $projectRootPath)
    {
        $projectRootPath = realpath($projectRootPath) . DIRECTORY_SEPARATOR;

        if ( ! is_dir($projectRootPath)) {
            throw new \LogicException('Invalid project root path: ' . $projectRootPath);
        }

        $this->projectRootPath = $projectRootPath;
    }

    // ########################################

    public function initialize(): void
    {
        if ($this->isInitialized) {
            throw new \LogicException('Bootstrap has already been initialized.');
        }

        try {
            $definitions = $this->getDiConfigForImplicitCreation();

            $containerBuilder = new \DI\ContainerBuilder();
            $containerBuilder->useAnnotations(true);
            $containerBuilder->addDefinitions($definitions);

            $di = $containerBuilder->build();

            /** @var \Guidance\Tests\Base\FoldersStructure $folderStructure */
            $folderStructure = $di->make(\Guidance\Tests\Base\FoldersStructure::class, ['projectRootPath' => $this->projectRootPath]);

            $di->set(\Guidance\Tests\Base\FoldersStructure::class, $folderStructure);

            RuntimeContainer::setDi($di);

        } catch (\Throwable $e) {
            throw new \LogicException($e->getMessage());
        }

        $this->isInitialized = true;
    }

    // ########################################

    private function getDiConfigForImplicitCreation()
    {
        $relativeConfigPath = 'config' . DIRECTORY_SEPARATOR . 'di' . DIRECTORY_SEPARATOR .'configure_creation.php';

        $projectDiConfigFilePath = $this->projectRootPath . $relativeConfigPath;
        $baseDiConfigFilePath    = $this->projectRootPath . 'vendor' . DIRECTORY_SEPARATOR
            . ProjectInfo::OWNER . DIRECTORY_SEPARATOR . ProjectInfo::NAME . DIRECTORY_SEPARATOR . $relativeConfigPath;

        $result = [];
        foreach ([$projectDiConfigFilePath, $baseDiConfigFilePath] as $path) {
            $result = array_merge($result, include $path);
        }

        return $result;
    }
}
