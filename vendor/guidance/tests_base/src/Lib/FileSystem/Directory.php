<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\FileSystem;

class Directory extends BaseAbstract
{
    // ########################################

    public function __construct(string $path)
    {
        parent::__construct($path);

        $this->path .= DIRECTORY_SEPARATOR;
    }

    // ########################################

    public function isExist(): bool
    {
        clearstatcache(true, $this->getPath());
        return is_dir($this->getPath());
    }

    // ########################################
}
