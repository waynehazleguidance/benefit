<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\FileSystem\Directory;

class Items implements \Iterator
{
    /** @var \Guidance\Tests\Base\Lib\FileSystem\BaseAbstract[] */
    private $data = [];

    private $iteratePosition = 0;

    // ########################################

    public function addItem(\Guidance\Tests\Base\Lib\FileSystem\BaseAbstract $item)
    {
        $this->data[] = $item;
    }

    // ########################################

    /**
     * @return \Guidance\Tests\Base\Lib\FileSystem\File[]
     */
    public function getFiles(): array
    {
        $result = [];
        foreach ($this->getItems() as $item) {
            if ($item->isFile()) {
                $result[] = $item;
            }
        }

        return $result;
    }

    /**
     * @return \Guidance\Tests\Base\Lib\FileSystem\Directory[]
     */
    public function getDirectories(): array
    {
        $result = [];
        foreach ($this->getItems() as $item) {
            if ($item->isDirectory()) {
                $result[] = $item;
            }
        }

        return $result;
    }

    public function getItems()
    {
        return $this->data;
    }

    // ########################################

    public function isEmpty()
    {
        return empty($this->data);
    }

    public function count()
    {
        return count($this->data);
    }

    // ########################################

    public function current()
    {
        return $this->data[$this->key()];
    }

    public function next()
    {
        ++$this->iteratePosition;
    }

    public function key()
    {
        return $this->iteratePosition;
    }

    public function valid()
    {
        return isset($this->data[$this->key()]);
    }

    public function rewind()
    {
        $this->iteratePosition = 0;
    }

    // ########################################
}
