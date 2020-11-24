<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\FileSystem\Directory;

class Factory
{
    use \Guidance\Tests\Base\Object\FactoryTrait;

    // ########################################

    public function create(string $path): \Guidance\Tests\Base\Lib\FileSystem\Directory
    {
        $this->getStringValidator()->assertNotEmpty($path);

        return $this->di->make(\Guidance\Tests\Base\Lib\FileSystem\Directory::class, ['path' => $path]);
    }

    // ########################################
}
