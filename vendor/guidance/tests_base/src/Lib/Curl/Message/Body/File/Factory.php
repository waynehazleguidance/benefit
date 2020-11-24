<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\Curl\Message\Body\File;

class Factory
{
    use \Guidance\Tests\Base\Object\FactoryTrait;

    // ########################################

    public function create(
        \Guidance\Tests\Base\Lib\FileSystem\File $file,
        string $mimeType = 'application/octet-stream',
        string $postName = null
    ) {
        if (is_null($postName)) {
            $postName = $file->getName();
        }

        return $this->di->make(\Guidance\Tests\Base\Lib\Curl\Message\Body\File::class, [
            'path'      => $file->getPath(),
            'mime_type' => $mimeType,
            'post_name' => $postName,
        ]);
    }

    // ########################################
}
