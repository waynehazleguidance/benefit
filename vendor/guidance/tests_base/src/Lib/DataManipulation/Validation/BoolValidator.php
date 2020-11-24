<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\DataManipulation\Validation;

/**
 * @method $this assert($value)
 */
class BoolValidator extends BaseAbstract
{
    // ########################################

    public function is($value): bool
    {
        return is_bool($value);
    }

    // ########################################
}
