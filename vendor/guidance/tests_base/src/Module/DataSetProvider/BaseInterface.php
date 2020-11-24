<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Module\DataSetProvider;

interface BaseInterface
{
    public function getFile(string $fileName): \Guidance\Tests\Base\Lib\FileSystem\File;

    public function getData(string $key);
}
