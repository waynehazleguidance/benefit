<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Object;

trait FactoryTrait
{
    /**
     * @Inject
     * @var \DI\Container
     */
    protected $di = null;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Lib\DataManipulation\ArrayDataValidator\Factory
     */
    private $arrayDataValidatorFactory = null;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Lib\DataManipulation\Validation\ArrayValidator
     */
    private $arrayValidator = null;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Lib\DataManipulation\Validation\BoolValidator
     */
    private $boolValidator = null;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Lib\DataManipulation\Validation\CallableValidator
     */
    private $callableValidator = null;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Lib\DataManipulation\Validation\NumberValidator
     */
    private $numberValidator = null;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Lib\DataManipulation\Validation\ObjectValidator
     */
    private $objectValidator = null;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Lib\DataManipulation\Validation\ResourceValidator
     */
    private $resourceValidator = null;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Lib\DataManipulation\Validation\StringValidator
     */
    private $stringValidator = null;

    // ########################################

    protected function createParamsValidator(array $params): \Guidance\Tests\Base\Lib\DataManipulation\ArrayDataValidator
    {
        return $this->arrayDataValidatorFactory->create($params);
    }

    // ########################################

    protected function getArrayValidator(): \Guidance\Tests\Base\Lib\DataManipulation\Validation\ArrayValidator
    {
        return $this->arrayValidator;
    }

    protected function getBooleanValidator(): \Guidance\Tests\Base\Lib\DataManipulation\Validation\BoolValidator
    {
        return $this->boolValidator;
    }

    protected function getCallableValidator(): \Guidance\Tests\Base\Lib\DataManipulation\Validation\CallableValidator
    {
        return $this->callableValidator;
    }

    protected function getNumberValidator(): \Guidance\Tests\Base\Lib\DataManipulation\Validation\NumberValidator
    {
        return $this->numberValidator;
    }

    protected function getObjectValidator():\Guidance\Tests\Base\Lib\DataManipulation\Validation\ObjectValidator
    {
        return $this->objectValidator;
    }

    protected function getResourceValidator(): \Guidance\Tests\Base\Lib\DataManipulation\Validation\ResourceValidator
    {
        return $this->resourceValidator;
    }

    protected function getStringValidator(): \Guidance\Tests\Base\Lib\DataManipulation\Validation\StringValidator
    {
        return $this->stringValidator;
    }

    // ########################################
}
