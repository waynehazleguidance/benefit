<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\DataManipulation\Validation;

/**
 * @method $this assert($value)
 * @method $this assertZero($value)
 * @method $this assertNotZero($value)
 * @method $this assertEqual($value, $compared)
 * @method $this assertGreaterThan($value, $compared)
 * @method $this assertLessThan($value, $compared)
 * @method $this assertInteger($value)
 * @method $this assertNotInteger($value)
 * @method $this assertZeroInteger($value)
 * @method $this assertNotZeroInteger($value)
 * @method $this assertIntegerGreaterThan($value, $compared)
 * @method $this assertIntegerLessThan($value, $compared)
 * @method $this assertIntegerEqual($value, int $compared)
 * @method $this assertFloat($value)
 * @method $this assertNotFloat($value)
 * @method $this assertZeroFloat($value)
 * @method $this assertNotZeroFloat($value)
 * @method $this assertFloatGreaterThan($value, $compared)
 * @method $this assertFloatLessThan($value, $compared)
 * @method $this assertFloatEqual($value, float $compared)
 */
class NumberValidator extends BaseAbstract
{
    // ########################################

    public function is($value): bool
    {
        return is_numeric($value) && !is_string($value);
    }

    // ########################################

    public function isZero($value): bool
    {
        return $this->is($value) && $value == 0;
    }

    public function isNotZero($value): bool
    {
        return $this->is($value) && $value != 0;
    }

    // ----------------------------------------

    public function isEqual($value, $compared): bool
    {
        return $this->is($value) && $this->is($compared) && $value == $compared;
    }

    public function isNotEqual($value, $compared): bool
    {
        return $this->is($value) && $this->is($compared) && $value !== $compared;
    }

    // ----------------------------------------

    public function isGreaterThan($value, $compared): bool
    {
        return $this->is($value) && $value > $compared;
    }

    public function isLessThan($value, $compared): bool
    {
        return $this->is($value) && $value < $compared;
    }

    // ----------------------------------------

    public function isInteger($value): bool
    {
        return $this->is($value) && is_int($value);
    }

    public function isNotInteger($value): bool
    {
        return $this->is($value) && !is_int($value);
    }

    public function isZeroInteger($value): bool
    {
        return $this->isInteger($value) && $value == 0;
    }

    public function isNotZeroInteger($value): bool
    {
        return $this->isInteger($value) && $value != 0;
    }

    public function isIntegerGreaterThan($value, $compared)
    {
        return $this->isInteger($value) && $this->isGreaterThan($value, $compared);
    }

    public function isIntegerLessThan($value, $compared)
    {
        return $this->isInteger($value) && $this->isLessThan($value, $compared);
    }

    public function isIntegerEqual($value, int $compared)
    {
        return $this->isInteger($value) && $this->isEqual($value, $compared);
    }

    // ----------------------------------------

    public function isFloat($value): bool
    {
        return $this->is($value) && is_float($value);
    }

    public function isNotFloat($value): bool
    {
        return $this->is($value) && !is_float($value);
    }

    public function isZeroFloat($value): bool
    {
        return $this->isFloat($value) && $value == 0;
    }

    public function isNotZeroFloat($value): bool
    {
        return $this->isFloat($value) && $value != 0;
    }

    public function isFloatGreaterThan($value, $compared)
    {
        return $this->isFloat($value) && $this->isGreaterThan($value, $compared);
    }

    public function isFloatLessThan($value, $compared)
    {
        return $this->isFloat($value) && $this->isLessThan($value, $compared);
    }

    public function isFloatEqual($value, float $compared)
    {
        return $this->isFloat($value) && $this->isEqual($value, $compared);
    }

    // ########################################
}
