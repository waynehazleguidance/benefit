<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\FileSystem;

class File extends BaseAbstract
{
    /** @var string */
    private $fullName = null;

    /** @var string | null */
    private $extension = null;

    // ########################################

    public function __construct(string $path)
    {
        parent::__construct($path);

        $pathInfo = pathinfo($this->getPath());

        $this->name     = $pathInfo['filename'];
        $this->fullName = $pathInfo['basename'];

        if (!empty($pathInfo['extension'])) {
            $this->extension = $pathInfo['extension'];
        }
    }

    // ########################################

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function hasExtension(): bool
    {
        return !is_null($this->extension);
    }

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    // ########################################

    public function isExist(): bool
    {
        clearstatcache(true, $this->getPath());

        return is_file($this->getPath());
    }

    // ########################################

    public function writeData(string $data, $flags = 0): void
    {
        if ( ! $this->isExist()) {
            throw new \LogicException('Unable to write data to file, file is not exist.');
        }

        if (file_put_contents($this->getPath(), $data, $flags) === false) {
            throw new \RuntimeException('Unable to write data.');
        }
    }

    public function readData(): string
    {
        if ( ! $this->isExist()) {
            throw new \LogicException('Unable to read data from file, file is not exist.');
        }

        if ( ! $this->isReadable()) {
            throw new \LogicException('Unable to read data from file, file is not readable.');
        }

        return file_get_contents($this->getPath());
    }

    // ########################################
}
