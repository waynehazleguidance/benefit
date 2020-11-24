<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Actor\Helper;

class Common extends \Codeception\Module
{
    /** @var \Guidance\Tests\Base\Actor\WebDriver */
    private $webDriver = null;

    //########################################

    public function _beforeSuite($settings = []): void
    {
        $this->webDriver = $this->getModule(\Guidance\Tests\Base\Actor\WebDriver::class);
    }

    //########################################

    public function attachFile(string $field, string $file)
    {
        $filename = basename($file);

        $newfile = codecept_data_dir() . $filename;

        copy($file, $newfile);

        $this->webDriver->attachFile($field, $filename);

        unlink($newfile);
    }

    //########################################

    public function scrollToTop()
    {
        $this->webDriver->scrollTo('body', 0, 0);
    }

    public function scrollToBottom()
    {
        $this->webDriver->executeJS('window.scrollTo(0,document.body.scrollHeight);');
        $this->webDriver->wait(0.5);
    }

    public function fillSensitiveField($field, $value)
    {
        $this->webDriver->fillField($field, new \Codeception\Step\Argument\PasswordArgument($value));
    }

    public function selectRandomOption($cssSelector, $excludeFirstOption = true): string
    {
        $options = $this->webDriver->grabMultiple($cssSelector . ' option');

        if ($excludeFirstOption) {
            unset($options[0]);
        }

        $options = array_filter($this->webDriver->grabMultiple($cssSelector . ' option'));

        /** @var string $randomOptions */
        $randomOptions = $options[array_rand($options)];

        $this->webDriver->selectOption($cssSelector, $randomOptions);

        return $randomOptions;
    }

    public function selectRandomMultipleOption($cssSelector, $optionsAmount = 1): array
    {
        $optionsText = array_filter($this->webDriver->grabMultiple($cssSelector . ' option'));

        $randomOptions = $this->arrayRandom($optionsText, $optionsAmount);

        $this->webDriver->selectOption($cssSelector, $this->arrayRandom($optionsText, $optionsAmount));

        return $randomOptions;
    }

    public function grabAllCookies(): array
    {
        return $this->webDriver->executeJS('
            var getCookies = function(){
              var pairs = document.cookie.split(";");
              var cookies = {};
              for (var i=0; i<pairs.length; i++){
                var pair = pairs[i].split("=");
                cookies[(pair[0]+\'\').trim()] = unescape(pair.slice(1).join(\'=\'));
              }
              return cookies;
            }
            return getCookies();
        ');
    }

    //########################################

    public function reconfigureUrl(string $url = null)
    {
        $url = is_null($url)
            ? $this->webDriver->_getConfig('url')
            : rtrim($url, '/') . '/';

        $this->webDriver->_reconfigure(['url' => $url]);
        $this->webDriver->debugSection('Host', $url);
    }

    //########################################

    public function getUrlDomainName(): string
    {
        return $this->webDriver->_getUrl();
    }

    public function getUrl(): string
    {
        return $this->webDriver->executeJS('return location.href;');
    }

    public function getUrlResourceAddress(): string
    {
        return $this->webDriver->_getCurrentUri();
    }

    public function getIdFromCurrentUrl(): string
    {
        $matches = [];

        $url = $this->getUrl();

        preg_match('/id\/(.*?)\//', $url, $matches);

        return $matches[1];
    }

    //########################################

    private function arrayRandom(array $array, int $amount = 1)
    {
        $keys = array_rand($array, $amount);

        if ($amount == 1) {
            return $array[$keys];
        }

        $results = [];
        foreach ($keys as $key) {
            $results[] = $array[$key];
        }

        return $results;
    }

    //########################################
}
