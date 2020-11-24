<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\DataManipulation\Validation;

/**
 * @method $this assert($value)
 * @method $this assertEmpty($value)
 * @method $this assertNotEmpty($value)
 * @method $this assertLengthEqual($value, int $length)
 * @method $this assertLengthLessThan($value, int $length)
 * @method $this assertLengthGreaterThan($value, int $length)
 * @method $this assertContainsSubstring($value, string $substring)
 * @method $this assertRegexMatch($value, string $pattern)
 * @method $this assertNotConfigMock($value)
 */
class StringValidator extends BaseAbstract
{
    // ########################################

    public function is($value): bool
    {
        return is_string($value);
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

    public function isLengthEqual($value, int $length): bool
    {
        return $this->is($value) && strlen($value) == $length;
    }

    public function isLengthLessThan($value, int $length): bool
    {
        return $this->is($value) && strlen($value) < $length;
    }

    public function isLengthGreaterThan($value, int $length): bool
    {
        return $this->is($value) && strlen($value) > $length;
    }

    public function isContainsSubstring($value, string $substring): bool
    {
        return $this->is($value) && strpos($value, $substring) !== false;
    }

    public function isRegexMatch($value, string $pattern): bool
    {
        return $this->is($value) && preg_match($pattern, $value);
    }

    public function isNotConfigMock($value): bool
    {
        return $this->is($value) && $value[0] !== '#' && substr($value, -1) !== '#';
    }

    // ########################################
}
