<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\DataManipulation;

/**
 * @method $this assertExist(string $path)
 * @method $this assertNotExist(string $path)
 * @method $this assertNull(string $path)
 * @method $this assertNotNull(string $path)
 * @method $this assertBool(string $path)
 * @method $this assertNotBool(string $path)
 * @method $this assertString(string $path)
 * @method $this assertNotString(string $path)
 * @method $this assertEmptyString(string $path)
 * @method $this assertNotEmptyString(string $path)
 * @method $this assertNumber(string $path)
 * @method $this assertNotNumber(string $path)
 * @method $this assertZeroNumber(string $path)
 * @method $this assertNotZeroNumber(string $path)
 * @method $this assertNumberLessThan(string $path, $compared)
 * @method $this assertNumberGreaterThan(string $path, $compared)
 * @method $this assertNumberEqual(string $path, $compared)
 * @method $this assertInteger(string $path)
 * @method $this assertNotInteger(string $path)
 * @method $this assertZeroInteger(string $path)
 * @method $this assertNotZeroInteger(string $path)
 * @method $this assertIntegerGreaterThan(string $path, $compared)
 * @method $this assertIntegerLessThan(string $path, $compared)
 * @method $this assertIntegerEqual(string $path, float $compared)
 * @method $this assertFloat(string $path)
 * @method $this assertNotFloat(string $path)
 * @method $this assertZeroFloat(string $path)
 * @method $this assertNotZeroFloat(string $path)
 * @method $this assertArray(string $path)
 * @method $this assertNotArray(string $path)
 * @method $this assertEmptyArray(string $path)
 * @method $this assertNotEmptyArray(string $path)
 * @method $this assertArrayWithCountEqual(string $path, int $compared)
 * @method $this assertArrayWithCountLessThan(string $path, int $compared)
 * @method $this assertArrayWithCountGreaterThan(string $path, int $compared)
 * @method $this assertResource(string $path)
 * @method $this assertNotResource(string $path)
 * @method $this assertCallable(string $path)
 * @method $this assertNotCallable(string $path)
 * @method $this assertInstanceOf(string $path, string $type)
 * @method $this assertNotInstanceOf(string $path, string $type)
 * @method $this assertStringInArray(string $path)
 * @method $this assertEmptyStringInArray(string $path)
 * @method $this assertNotEmptyStringInArray(string $path)
 * @method $this assertNumberInArray(string $path)
 * @method $this assertNotNumberInArray(string $path)
 * @method $this assertIntegerInArray(string $path)
 * @method $this assertNotIntegerInArray(string $path)
 * @method $this assertZeroIntegerInArray(string $path)
 * @method $this assertNotZeroIntegerInArray(string $path)
 * @method $this assertFloatInArray(string $path)
 * @method $this assertNotFloatInArray(string $path)
 * @method $this assertZeroFloatInArray(string $path)
 * @method $this assertNotZeroFloatInArray(string $path)
 * @method $this assertFloatGreaterThan(string $path, $compared)
 * @method $this assertFloatLessThan(string $path, $compared)
 * @method $this assertFloatEqual(string $path, float $compared)
 * @method $this assertBooleanInArray(string $path)
 * @method $this assertNotBooleanInArray(string $path)
 * @method $this assertCallableInArray(string $path)
 * @method $this assertNotCallableInArray(string $path)
 * @method $this assertResourceInArray(string $path)
 * @method $this assertNotResourceInArray(string $path)
 * @method $this assertInstanceOfInArray(string $path, string $type)
 * @method $this assertNotInstanceOfInArray(string $path, string $type)
 * @method $this assertNullInArray(string $path)
 * @method $this assertNotNullInArray(string $path)
 * @method $this assertArrayInArray(string $path)
 * @method $this assertNotArrayInArray(string $path)
 */
class ArrayDataValidator
{
    /** @var \Guidance\Tests\Base\Lib\DataManipulation\ArrayWrapper */
    private $wrappedData;

    /**
     * @Inject
     * @var Validation\StringValidator
     */
    private $stringValidator = null;

    /**
     * @Inject
     * @var Validation\NumberValidator
     */
    private $numberValidator = null;

    /**
     * @Inject
     * @var Validation\BoolValidator
     */
    private $boolValidator = null;

    /**
     * @Inject
     * @var Validation\ResourceValidator
     */
    private $resourceValidator = null;

    /**
     * @Inject
     * @var Validation\CallableValidator
     */
    private $callableValidator = null;

    /**
     * @Inject
     * @var Validation\ObjectValidator
     */
    private $objectValidator = null;

    /**
     * @Inject
     * @var Validation\ArrayValidator
     */
    private $arrayValidator = null;

    // ########################################

    public function __construct(array $data, ArrayWrapper\Factory $wrappedDataFactory)
    {
        $this->wrappedData = $wrappedDataFactory->create($data);
    }

    // ########################################

    public function __call(string $method, array $arguments)
    {
        if (strpos($method, 'assert') !== 0) {
            throw new \LogicException("Method '{$method}' is not defined in class.");
        }

        $validateMethod = preg_replace('/^assert/', 'is', $method);

        if (!method_exists($this, $validateMethod)) {
            throw new \LogicException("Method '{$validateMethod}' is not defined in class.");
        }

        if ($this->$validateMethod(...$arguments)) {
            return $this;
        }

        $validationClass = explode('\\', static::class);
        $validationClass = array_pop($validationClass);

        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $initiator = $trace[1];
        if (isset($initiator['class'])) {
            $initiator = $initiator['class'] . $initiator['type'] . $initiator['function'] . '()';
        } else {
            $initiator = $initiator['function'] . '()';
        }

        $path = array_shift($arguments);
        throw new \LogicException(
            "Fail validation in {$validationClass}->{$method}() for parameter '{$path}' from {$initiator}.",
            [
                'arguments'   => $arguments,
                'source_data' => $this->wrappedData->get(null)
            ]
        );
    }

    // ########################################

    public function isExist(string $path): bool
    {
        return $this->wrappedData->has($path);
    }

    public function isNotExist(string $path): bool
    {
        return ! $this->isExist($path);
    }

    // ########################################

    public function isNull(string $path): bool
    {
        return $this->isExist($path) && $this->objectValidator->isNull($this->wrappedData->get($path));
    }

    public function isNotNull(string $path): bool
    {
        return $this->isExist($path) && $this->objectValidator->isNotNull($this->wrappedData->get($path));
    }

    // ########################################

    public function isBool(string $path): bool
    {
        return $this->isExist($path) && $this->boolValidator->is($this->wrappedData->get($path));
    }

    public function isNotBool(string $path): bool
    {
        return $this->isExist($path) && ! $this->boolValidator->is($this->wrappedData->get($path));
    }

    // ########################################

    public function isString(string $path): bool
    {
        return $this->isExist($path) && $this->stringValidator->is($this->wrappedData->get($path));
    }

    public function isNotString(string $path): bool
    {
        return $this->isExist($path) && ! $this->stringValidator->is($this->wrappedData->get($path));
    }

    public function isEmptyString(string $path): bool
    {
        return $this->isExist($path) && $this->stringValidator->isEmpty($this->wrappedData->get($path));
    }

    public function isNotEmptyString(string $path): bool
    {
        return $this->isExist($path) && $this->stringValidator->isNotEmpty($this->wrappedData->get($path));
    }

    // ########################################

    public function isNumber(string $path): bool
    {
        return $this->isExist($path) && $this->numberValidator->is($this->wrappedData->get($path));
    }

    public function isNotNumber(string $path): bool
    {
        return $this->isExist($path) && ! $this->numberValidator->is($this->wrappedData->get($path));
    }

    public function isZeroNumber(string $path): bool
    {
        return $this->isExist($path) && $this->numberValidator->isZero($this->wrappedData->get($path));
    }

    public function isNotZeroNumber(string $path): bool
    {
        return $this->isExist($path) && $this->numberValidator->isNotZero($this->wrappedData->get($path));
    }

    public function isNumberLessThan(string $path, $compared): bool
    {
        return $this->isExist($path) && $this->numberValidator->isLessThan($this->wrappedData->get($path), $compared);
    }

    public function isNumberGreaterThan(string $path, $compared): bool
    {
        return $this->isExist($path) && $this->numberValidator->isGreaterThan(
            $this->wrappedData->get($path),
            $compared
        );
    }

    public function isNumberEqual(string $path, $compared): bool
    {
        return $this->isExist($path) && $this->numberValidator->isEqual($this->wrappedData->get($path), $compared);
    }

    // ########################################

    public function isInteger(string $path): bool
    {
        return $this->isExist($path) && $this->numberValidator->isInteger($this->wrappedData->get($path));
    }

    public function isNotInteger(string $path): bool
    {
        return $this->isExist($path) && $this->numberValidator->isNotInteger($this->wrappedData->get($path));
    }

    public function isZeroInteger(string $path): bool
    {
        return $this->isExist($path) && $this->numberValidator->isZeroInteger($this->wrappedData->get($path));
    }

    public function isNotZeroInteger(string $path): bool
    {
        return $this->isExist($path) && $this->numberValidator->isNotZeroInteger($this->wrappedData->get($path));
    }

    public function isIntegerGreaterThan(string $path, $compared): bool
    {
        return $this->isExist($path) && $this->numberValidator->isIntegerGreaterThan(
            $this->wrappedData->get($path),
            $compared
        );
    }
    
    public function isIntegerLessThan(string $path, $compared): bool
    {
        return $this->isExist($path) && $this->numberValidator->isIntegerLessThan(
            $this->wrappedData->get($path),
            $compared
        );
    }

    public function isIntegerEqual(string $path, int $compared)
    {
        return $this->isExist($path) && $this->numberValidator->isIntegerEqual(
            $this->wrappedData->get($path),
            $compared
        );
    }

    // ########################################

    public function isFloat(string $path): bool
    {
        return $this->isExist($path) && $this->numberValidator->isFloat($this->wrappedData->get($path));
    }

    public function isNotFloat(string $path): bool
    {
        return $this->isExist($path) && $this->numberValidator->isNotFloat($this->wrappedData->get($path));
    }

    public function isZeroFloat(string $path): bool
    {
        return $this->isExist($path) && $this->numberValidator->isZeroFloat($this->wrappedData->get($path));
    }

    public function isNotZeroFloat(string $path): bool
    {
        return $this->isExist($path) && $this->numberValidator->isNotZeroFloat($this->wrappedData->get($path));
    }

    public function isFloatGreaterThan(string $path, $compared): bool
    {
        return $this->isExist($path) && $this->numberValidator->isFloatGreaterThan(
            $this->wrappedData->get($path),
            $compared
        );
    }

    public function isFloatLessThan(string $path, $compared): bool
    {
        return $this->isExist($path) && $this->numberValidator->isFloatLessThan(
            $this->wrappedData->get($path),
            $compared
        );
    }

    public function isFloatEqual(string $path, float $compared)
    {
        return $this->isExist($path) && $this->numberValidator->isFloatEqual(
            $this->wrappedData->get($path),
            $compared
        );
    }

    // ########################################

    public function isArray(string $path): bool
    {
        return $this->isExist($path) && $this->arrayValidator->is($this->wrappedData->get($path));
    }

    public function isNotArray(string $path): bool
    {
        return $this->isExist($path) && ! $this->arrayValidator->is($this->wrappedData->get($path));
    }

    public function isEmptyArray(string $path): bool
    {
        return $this->isExist($path) && $this->arrayValidator->isEmpty($this->wrappedData->get($path));
    }

    public function isNotEmptyArray(string $path): bool
    {
        return $this->isExist($path) && $this->arrayValidator->isNotEmpty($this->wrappedData->get($path));
    }

    public function isArrayWithCountEqual(string $path, $compared): bool
    {
        return $this->isExist($path) && $this->arrayValidator->isCountEqual($this->wrappedData->get($path), $compared);
    }

    public function isArrayWithCountLessThan(string $path, $compared): bool
    {
        return $this->isExist($path) && $this->arrayValidator->isCountLessThan(
            $this->wrappedData->get($path),
            $compared
        );
    }

    public function isArrayWithCountGreaterThan(string $path, $compared): bool
    {
        return $this->isExist($path) && $this->arrayValidator->isCountGreaterThan(
            $this->wrappedData->get($path),
            $compared
        );
    }

    // ########################################

    public function isResource(string $path): bool
    {
        return $this->isExist($path) && $this->resourceValidator->is($this->wrappedData->get($path));
    }

    public function isNotResource(string $path): bool
    {
        return $this->isExist($path) && ! $this->resourceValidator->is($this->wrappedData->get($path));
    }

    // ########################################

    public function isCallable(string $path): bool
    {
        return $this->isExist($path) && $this->callableValidator->is($this->wrappedData->get($path));
    }

    public function isNotCallable(string $path): bool
    {
        return $this->isExist($path) && ! $this->callableValidator->is($this->wrappedData->get($path));
    }

    // ########################################

    public function isInstanceOf(string $path, string $type): bool
    {
        return $this->isExist($path) && $this->objectValidator->isInstanceOf($this->wrappedData->get($path), $type);
    }

    public function isNotInstanceOf(string $path, string $type): bool
    {
        return $this->isExist($path) && ! $this->objectValidator->isInstanceOf($this->wrappedData->get($path), $type);
    }

    // ########################################

    public function isStringInArray(string $path): bool
    {
        return $this->isExist($path) && $this->arrayValidator->isStringInArray($this->wrappedData->get($path));
    }

    public function isEmptyStringInArray(string $path): bool
    {
        return $this->isExist($path) && $this->arrayValidator->isEmptyStringInArray($this->wrappedData->get($path));
    }

    public function isNotEmptyStringInArray(string $path): bool
    {
        return $this->isExist($path) && $this->arrayValidator->isNotEmptyStringInArray($this->wrappedData->get($path));
    }

    public function isNumberInArray(string $path): bool
    {
        return $this->isExist($path) && $this->arrayValidator->isNumberInArray($this->wrappedData->get($path));
    }

    public function isNotNumberInArray(string $path): bool
    {
        return $this->isExist($path) && $this->arrayValidator->isNotNumberInArray($this->wrappedData->get($path));
    }

    public function isIntegerInArray(string $path): bool
    {
        return $this->isExist($path) && $this->arrayValidator->isIntegerInArray($this->wrappedData->get($path));
    }

    public function isNotIntegerInArray(string $path): bool
    {
        return $this->isExist($path) && $this->arrayValidator->isNotIntegerInArray($this->wrappedData->get($path));
    }

    public function isZeroIntegerInArray(string $path): bool
    {
        return $this->isExist($path) && $this->arrayValidator->isZeroIntegerInArray($this->wrappedData->get($path));
    }

    public function isNotZeroIntegerInArray(string $path): bool
    {
        return $this->isExist($path) && $this->arrayValidator->isNotZeroIntegerInArray($this->wrappedData->get($path));
    }

    // ########################################

    public function isFloatInArray(string $path): bool
    {
        return $this->isExist($path) && $this->arrayValidator->isFloatInArray($this->wrappedData->get($path));
    }

    public function isNotFloatInArray(string $path): bool
    {
        return $this->isExist($path) && $this->arrayValidator->isFloatInArray($this->wrappedData->get($path));
    }

    public function isZeroFloatInArray(string $path): bool
    {
        return $this->isExist($path) && $this->arrayValidator->isZeroFloatInArray($this->wrappedData->get($path));
    }

    public function isNotZeroFloatInArray(string $path): bool
    {
        return $this->isExist($path) && $this->arrayValidator->isNotZeroFloatInArray($this->wrappedData->get($path));
    }

    // ########################################

    public function isBooleanInArray(string $path): bool
    {
        return $this->isExist($path) && $this->arrayValidator->isBooleanInArray($this->wrappedData->get($path));
    }

    public function isNotBooleanInArray(string $path): bool
    {
        return $this->isExist($path) && $this->arrayValidator->isNotBooleanInArray($this->wrappedData->get($path));
    }

    // ########################################

    public function isCallableInArray(string $path): bool
    {
        return $this->isExist($path) && $this->arrayValidator->isCallableInArray($this->wrappedData->get($path));
    }

    public function isNotCallableInArray(string $path): bool
    {
        return $this->isExist($path) && $this->arrayValidator->isNotCallableInArray($this->wrappedData->get($path));
    }

    // ########################################

    public function isResourceInArray(string $path): bool
    {
        return $this->isExist($path) && $this->arrayValidator->isResourceInArray($this->wrappedData->get($path));
    }

    public function isNotResourceInArray(string $path): bool
    {
        return $this->isExist($path) && $this->arrayValidator->isNotResourceInArray($this->wrappedData->get($path));
    }

    // ########################################

    public function isInstanceOfInArray(string $path, string $type): bool
    {
        return $this->isExist($path) && $this->arrayValidator->isInstanceOfInArray(
            $this->wrappedData->get($path),
            $type
        );
    }

    public function isNotInstanceOfInArray(string $path, string $type): bool
    {
        return $this->isExist($path) && $this->arrayValidator->isNotInstanceOfInArray(
            $this->wrappedData->get($path),
            $type
        );
    }

    // ########################################

    public function isNullInArray(string $path): bool
    {
        return $this->isExist($path) && $this->arrayValidator->isNullInArray($this->wrappedData->get($path));
    }

    public function isNotNullInArray(string $path): bool
    {
        return $this->isExist($path) && $this->arrayValidator->isNotNullInArray($this->wrappedData->get($path));
    }

    // ########################################

    public function isArrayInArray(string $path): bool
    {
        return $this->isExist($path) && $this->arrayValidator->isArrayInArray($this->wrappedData->get($path));
    }

    public function isNotArrayInArray(string $path): bool
    {
        return $this->isExist($path) && $this->arrayValidator->isNotArrayInArray($this->wrappedData->get($path));
    }

    // ########################################
}
