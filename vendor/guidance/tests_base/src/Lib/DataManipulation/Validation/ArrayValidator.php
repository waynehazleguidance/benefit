<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\DataManipulation\Validation;

/**
 * @method $this assert($value)
 * @method $this assertEmpty($value)
 * @method $this assertNotEmpty($value)
 * @method $this assertCountEqual($value, int $compared)
 * @method $this assertCountGreaterThan($value, int $compared)
 * @method $this assertCountLessThan($value, int $compared)
 * @method $this assertStringInArray($value)
 * @method $this assertEmptyStringInArray($value)
 * @method $this assertNotEmptyStringInArray($value)
 * @method $this assertNumberInArray($value)
 * @method $this assertNotNumberInArray($value)
 * @method $this assertIntegerInArray($value)
 * @method $this assertNotIntegerInArray($value)
 * @method $this assertNotZeroIntegerInArray($value)
 * @method $this assertZeroIntegerInArray($value)
 * @method $this assertFloatInArray($value)
 * @method $this assertNotFloatInArray($value)
 * @method $this assertNotZeroFloatInArray($value)
 * @method $this assertZeroFloatInArray($value)
 * @method $this assertBooleanInArray($value)
 * @method $this assertNotBooleanInArray($value)
 * @method $this assertCallableInArray($value)
 * @method $this assertNotCallableInArray($value)
 * @method $this assertResourceInArray($value)
 * @method $this assertNotResourceInArray($value)
 * @method $this assertInstanceOfInArray($value, string $type)
 * @method $this assertNotInstanceOfInArray($value, string $type)
 * @method $this assertNullInArray($value)
 * @method $this assertNotNullInArray($value)
 * @method $this assertArrayInArray($value)
 * @method $this assertNotArrayInArray($value)
 */
class ArrayValidator extends BaseAbstract
{
    /** @var \Guidance\Tests\Base\Lib\DataManipulation\Validation\StringValidator */
    private $stringValidator = null;

    /** @var \Guidance\Tests\Base\Lib\DataManipulation\Validation\NumberValidator */
    private $numberValidator = null;

    /** @var \Guidance\Tests\Base\Lib\DataManipulation\Validation\BoolValidator */
    private $boolValidator = null;

    /** @var \Guidance\Tests\Base\Lib\DataManipulation\Validation\ResourceValidator */
    private $resourceValidator = null;

    /** @var \Guidance\Tests\Base\Lib\DataManipulation\Validation\CallableValidator */
    private $callableValidator = null;

    /** @var \Guidance\Tests\Base\Lib\DataManipulation\Validation\ObjectValidator */
    private $objectValidator = null;

    // ########################################

    public function __construct(
        StringValidator $stringValidator,
        NumberValidator$numberValidator,
        BoolValidator $boolValidator,
        ResourceValidator $resourceValidator,
        CallableValidator $callableValidator,
        ObjectValidator $objectValidator
    ) {
        $this->stringValidator   = $stringValidator;
        $this->numberValidator   = $numberValidator;
        $this->boolValidator     = $boolValidator;
        $this->resourceValidator = $resourceValidator;
        $this->callableValidator = $callableValidator;
        $this->objectValidator   = $objectValidator;
    }

    // ########################################

    public function is($value): bool
    {
        return is_array($value);
    }

    // ########################################

    public function isEmpty($value): bool
    {
        return $this->is($value) && empty($value);
    }

    public function isNotEmpty($value): bool
    {
        return $this->is($value) && !empty($value);
    }

    public function isCountEqual($value, int $compared): bool
    {
        return $this->is($value) && count($value) == $compared;
    }

    public function isCountGreaterThan($value, int $compared): bool
    {
        return $this->is($value) && count($value) > $compared;
    }

    public function isCountLessThan($value, int $compared): bool
    {
        return $this->is($value) && count($value) < $compared;
    }

    // ########################################

    public function isStringInArray($value): bool
    {
        if ( ! $this->is($value) || $this->isEmpty($value)) {
            return false;
        }

        foreach ($value as $item) {
            if ( ! $this->stringValidator->is($item)) {
                return false;
            }
        }

        return true;
    }

    public function isEmptyStringInArray($value): bool
    {
        if ( ! $this->is($value) || $this->isEmpty($value)) {
            return false;
        }

        foreach ($value as $item) {
            if ($this->stringValidator->isNotEmpty($item)) {
                return false;
            }
        }

        return true;
    }

    public function isNotEmptyStringInArray($value): bool
    {
        if ( ! $this->is($value) || $this->isEmpty($value)) {
            return false;
        }

        foreach ($value as $item) {
            if ($this->stringValidator->isEmpty($item)) {
                return false;
            }
        }

        return true;
    }

    // ########################################

    public function isNumberInArray($value): bool
    {
        if ( ! $this->is($value) || $this->isEmpty($value)) {
            return false;
        }

        foreach ($value as $item) {
            if ( ! $this->numberValidator->is($item)) {
                return false;
            }
        }

        return true;
    }

    public function isNotNumberInArray($value): bool
    {
        if ( ! $this->is($value) || $this->isEmpty($value)) {
            return false;
        }

        foreach ($value as $item) {
            if ($this->numberValidator->is($item)) {
                return false;
            }
        }

        return true;
    }

    public function isIntegerInArray($value): bool
    {
        if ( ! $this->is($value) || $this->isEmpty($value)) {
            return false;
        }

        foreach ($value as $item) {
            if ( ! $this->numberValidator->isInteger($item)) {
                return false;
            }
        }

        return true;
    }

    public function isNotIntegerInArray($value): bool
    {
        if ( ! $this->is($value) || $this->isEmpty($value)) {
            return false;
        }

        foreach ($value as $item) {
            if ($this->numberValidator->isInteger($item)) {
                return false;
            }
        }

        return true;
    }

    public function isNotZeroIntegerInArray($value): bool
    {
        if ( ! $this->is($value) || $this->isEmpty($value)) {
            return false;
        }

        foreach ($value as $item) {
            if ( ! $this->numberValidator->isNotZeroInteger($item)) {
                return false;
            }
        }

        return true;
    }

    public function isZeroIntegerInArray($value): bool
    {
        if ( ! $this->is($value) || $this->isEmpty($value)) {
            return false;
        }

        foreach ($value as $item) {
            if ( ! $this->numberValidator->isZeroInteger($item)) {
                return false;
            }
        }

        return true;
    }

    public function isFloatInArray($value): bool
    {
        if ( ! $this->is($value) || $this->isEmpty($value)) {
            return false;
        }

        foreach ($value as $item) {
            if ( ! $this->numberValidator->isFloat($item)) {
                return false;
            }
        }

        return true;
    }

    public function isNotFloatInArray($value): bool
    {
        if ( ! $this->is($value) || $this->isEmpty($value)) {
            return false;
        }

        foreach ($value as $item) {
            if ($this->numberValidator->isFloat($item)) {
                return false;
            }
        }

        return true;
    }

    public function isNotZeroFloatInArray($value): bool
    {
        if ( ! $this->is($value) || $this->isEmpty($value)) {
            return false;
        }

        foreach ($value as $item) {
            if ( ! $this->numberValidator->isNotZeroFloat($item)) {
                return false;
            }
        }

        return true;
    }

    public function isZeroFloatInArray($value): bool
    {
        if ( ! $this->is($value) || $this->isEmpty($value)) {
            return false;
        }

        foreach ($value as $item) {
            if ($this->numberValidator->isZeroFloat($item)) {
                return false;
            }
        }

        return true;
    }


    // ########################################

    public function isBooleanInArray($value): bool
    {
        if ( ! $this->is($value) || $this->isEmpty($value)) {
            return false;
        }

        foreach ($value as $item) {
            if ( ! $this->boolValidator->is($item)) {
                return false;
            }
        }

        return true;
    }

    public function isNotBooleanInArray($value): bool
    {
        if ( ! $this->is($value) || $this->isEmpty($value)) {
            return false;
        }

        foreach ($value as $item) {
            if ($this->boolValidator->is($item)) {
                return false;
            }
        }

        return true;
    }

    public function isCallableInArray($value): bool
    {
        if ( ! $this->is($value) || $this->isEmpty($value)) {
            return false;
        }

        foreach ($value as $item) {
            if ( ! $this->callableValidator->is($item)) {
                return false;
            }
        }

        return true;
    }

    public function isNotCallableInArray($value): bool
    {
        if ( ! $this->is($value) || $this->isEmpty($value)) {
            return false;
        }

        foreach ($value as $item) {
            if ($this->callableValidator->is($item)) {
                return false;
            }
        }

        return true;
    }

    public function isResourceInArray($value): bool
    {
        if ( ! $this->is($value) || $this->isEmpty($value)) {
            return false;
        }

        foreach ($value as $item) {
            if ( ! $this->resourceValidator->is($item)) {
                return false;
            }
        }

        return true;
    }

    public function isNotResourceInArray($value): bool
    {
        if ( ! $this->is($value) || $this->isEmpty($value)) {
            return false;
        }

        foreach ($value as $item) {
            if ($this->resourceValidator->is($item)) {
                return false;
            }
        }

        return true;
    }

    public function isInstanceOfInArray($value, string $type): bool
    {
        if ( ! $this->is($value) || $this->isEmpty($value)) {
            return false;
        }

        foreach ($value as $item) {
            if ( ! $this->objectValidator->isInstanceOf($item, $type)) {
                return false;
            }
        }

        return true;
    }

    public function isNotInstanceOfInArray($value, string $type): bool
    {
        if ( ! $this->is($value) || $this->isEmpty($value)) {
            return false;
        }

        foreach ($value as $item) {
            if ($this->objectValidator->isInstanceOf($item, $type)) {
                return false;
            }
        }

        return true;
    }

    public function isNullInArray($value): bool
    {
        if ( ! $this->is($value) || $this->isEmpty($value)) {
            return false;
        }

        foreach ($value as $item) {
            if ( ! $this->objectValidator->isNull($item)) {
                return false;
            }
        }

        return true;
    }

    public function isNotNullInArray($value): bool
    {
        if ( ! $this->is($value) || $this->isEmpty($value)) {
            return false;
        }

        foreach ($value as $item) {
            if ( ! $this->objectValidator->isNotNull($item)) {
                return false;
            }
        }

        return true;
    }

    public function isArrayInArray($value): bool
    {
        if ( ! $this->is($value) || $this->isEmpty($value)) {
            return false;
        }

        foreach ($value as $item) {
            if ( ! $this->is($item)) {
                return false;
            }
        }

        return true;
    }

    public function isNotArrayInArray($value): bool
    {
        if ( ! $this->is($value) || $this->isEmpty($value)) {
            return false;
        }

        foreach ($value as $item) {
            if ($this->is($item)) {
                return false;
            }
        }

        return true;
    }

    // ########################################
}
