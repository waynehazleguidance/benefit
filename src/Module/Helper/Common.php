<?php

declare(strict_types=1);

namespace Guidance\Tests\Project\Module\Helper;

abstract class Common
{
    // ########################################

    public static function toPrice(float $price, bool $round = true): string
    {
        $formattedPrice = $round ? number_format($price, 2) : floor($price * 100) / 100;

        return empty($price) ? 'Free' : '$' . $formattedPrice;
    }

    // ########################################

    public static function amIOnPage(\Guidance\Tests\Base\Module\Page\BaseAbstract $page): bool
    {
        /** @var \Guidance\Tests\Project\Actor $I */
        $I = \Guidance\Tests\Project\RuntimeContainer::getActor();

        return $I->executeJs('return window.location.pathname == \'' . $page->getPath() . '\'');
    }

    // ########################################
}
