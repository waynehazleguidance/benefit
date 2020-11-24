<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\FileSystem\File;

class Php extends \Guidance\Tests\Base\Lib\FileSystem\File
{
    // ########################################

    /**
     * @return mixed
     * @throws \RuntimeException
     */
    public function interpret()
    {
        if ( ! $this->isExist() || ! $this->isReadable()) {
            throw new \RuntimeException("Can not interpret php file '{$this->getPath()}'.");
        }

        return include $this->getPath();
    }

    // ########################################
}
