<?php

declare(strict_types=1);

namespace Guidance\Tests\Project;

class RuntimeContainer extends \Guidance\Tests\Base\RuntimeContainer
{
    /** @var \Guidance\Tests\Project\Module\Object\Page\Frontend\MyAccount */
    private static $myAccount = null;

    // ########################################

    public static function setMyAccount(Module\Object\Page\Frontend\MyAccount $myAccount): void
    {
        self::$myAccount = $myAccount;
    }

    public static function getMyAccount(): ? Module\Object\Page\Frontend\MyAccount
    {
        return self::$myAccount;
    }

    // ########################################
}
