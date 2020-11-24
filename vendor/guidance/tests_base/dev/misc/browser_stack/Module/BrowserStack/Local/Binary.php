<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Module\BrowserStack\Local;

use \Guidance\Tests\Base\Lib\System;

class Binary
{
    /** @var \Guidance\Tests\Base\Lib\FileSystem\File */
    private $binaryFile = null;

    // ########################################

    public function __construct(\Guidance\Tests\Base\Lib\FileSystem\File $binaryFile)
    {
        $this->binaryFile = $binaryFile;
    }

    // ########################################

    public function getFile(): \Guidance\Tests\Base\Lib\FileSystem\File
    {
        return $this->binaryFile;
    }

    public function isFileExist(): bool
    {
        return $this->binaryFile->isExist();
    }

    public function download(): void
    {
        $file = fopen($this->binaryFile->getPath(), "w+");
        $ch = curl_init("");

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_URL, $this->getDownloadUrl());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FILE, $file);

        if ( ! curl_exec ($ch)) {
            throw new \RuntimeException("Error trying to download BrowserStack Local binary");
        }
        curl_close ($ch);

        chmod($this->binaryFile->getPath(), 0755);
    }

    // ########################################

    private function getDownloadUrl(): string
    {
        $urlPrefix = 'https://s3.amazonaws.com/browserStack/browserstack-local/BrowserStackLocal';

        if (System::getOS() == System::OS_OSX) {
            return "{$urlPrefix}-darwin-x64";

        } elseif (System::getOS() == System::OS_WIN) {
            return "{$urlPrefix}.exe";

        } else {

            if (PHP_INT_SIZE * 8 == 64) {
                return "{$urlPrefix}-linux-x64";

            } else {
                return "{$urlPrefix}-linux-ia32";
            }
        }
    }

    // ########################################
}
