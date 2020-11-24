<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\FileSystem\File;

class Factory
{
    use \Guidance\Tests\Base\Object\FactoryTrait;

    // ########################################

    public function create(string $path): \Guidance\Tests\Base\Lib\FileSystem\File
    {
        $this->getStringValidator()->assertNotEmpty($path);

        return $this->di->make(\Guidance\Tests\Base\Lib\FileSystem\File::class, ['path' => $path]);
    }

    // ########################################
}
