<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\FileSystem;

abstract class BaseAbstract
{
    /** @var string */
    protected $path = null;

    /** @var string */
    protected $name = null;

    // ########################################

    public function __construct(string $path)
    {
        $pathInfo = pathinfo($path);

        $this->path = rtrim($path, '/\\');
        $this->name = $pathInfo['basename'];
    }

    // ########################################

    public function getPath(): string
    {
        return $this->path;
    }

    public function getName(): string
    {
        return $this->name;
    }

    // ########################################

    abstract public function isExist(): bool;

    // ########################################

    public function isDirectory(): bool
    {
        if ($this->isSymlink()) {
            return false;
        }

        return is_dir($this->getPath());
    }

    public function isFile(): bool
    {
        if ($this->isSymlink()) {
            return false;
        }

        return is_file($this->getPath());
    }

    public function isSymlink()
    {
        return is_link($this->getPath());
    }

    // ########################################

    public function isWritable(): bool
    {
        return is_writable($this->getPath());
    }

    public function isReadable(): bool
    {
        return is_readable($this->getPath());
    }

    public function isExecutable(): bool
    {
        return is_executable($this->getPath());
    }

    // ########################################

    /**
     * @param string|int $owner
     *
     * @return bool
     * @throws \LogicException
     */
    public function setOwner($owner): bool
    {
        if ( ! $this->isExist()) {
            throw new \LogicException("{$this->getPath()} is not found.");
        }

        return chown($this->getPath(), $owner);
    }

    /**
     * @param string|int $group
     *
     * @return bool
     * @throws \LogicException
     */
    public function setGroup($group): bool
    {
        if ( ! $this->isExist()) {
            throw new \LogicException("{$this->getPath()} is not found.");
        }

        return chgrp($this->getPath(), $group);
    }

    // ########################################
}
