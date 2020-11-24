<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\FileSystem\File\Php;

class Factory
{
    use \Guidance\Tests\Base\Object\FactoryTrait;

    // ########################################

    public function create(string $path): \Guidance\Tests\Base\Lib\FileSystem\File\Php
    {
        $this->getStringValidator()->assertNotEmpty($path);

        $result = $this->di->make(\Guidance\Tests\Base\Lib\FileSystem\File\Php::class, ['path' => $path]);
        if ($result->getExtension() !== 'php') {
            throw new \LogicException('File must have the extension \'php\'.');
        }

        return $result;
    }

    // ########################################
}
