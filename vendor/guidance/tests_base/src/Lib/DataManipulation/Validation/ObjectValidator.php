<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\DataManipulation\Validation;

/**
 * @method $this assert($value)
 * @method $this assertNull($value)
 * @method $this assertNotNull($value)
 * @method $this assertInstanceOf($value, string $type)
 */
class ObjectValidator extends BaseAbstract
{
    // ########################################

    public function is($value): bool
    {
        return is_object($value);
    }

    // ########################################

    public function isNull($value): bool
    {
        return is_null($value);
    }

    public function isNotNull($value): bool
    {
        return ! $this->isNull($value);
    }

    public function isInstanceOf($value, string $type): bool
    {
        return $this->is($value) && ($value instanceof $type);
    }

    // ########################################
}
