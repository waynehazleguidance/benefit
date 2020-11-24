<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Actor;

class WebDriver extends \Codeception\Module\WebDriver
{
    // ########################################

    public function _getWebElement($selector): \Facebook\WebDriver\WebDriverElement
    {
        $arr = $this->findFields($selector);
        return reset($arr);
    }

    // ########################################
}
