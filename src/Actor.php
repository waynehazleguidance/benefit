<?php

declare(strict_types=1);

namespace Guidance\Tests\Project;

/**
 * Inherited Methods:
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * Custom:
 * @method void writeCase($description)
 *
 * @SuppressWarnings(PHPMD)
*/

class Actor extends \Guidance\Tests\Base\Actor\BaseAbstract
{
    use \Guidance\Tests\Project\_generated\ActorActions;

    use \Codeception\Lib\Actor\Shared\Retry;
    use \Codeception\Lib\Actor\Shared\Friend;

    public function __construct(\Codeception\Scenario $scenario)
    {
        parent::__construct($scenario);
    }
}
