<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\Curl\Message\Body;

class File extends \Guidance\Tests\Base\Lib\FileSystem\File
{
    /** @var string */
    private $mimeType = null;

    /** @var string */
    private $postName = null;

    // ########################################

    public function __construct(string $path, string $mimeType, string $postName)
    {
        parent::__construct($path);

        $this->mimeType = $mimeType;
        $this->postName = $postName;
    }

    // ########################################

    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    public function getPostName(): string
    {
        return $this->postName;
    }

    // ########################################
}
