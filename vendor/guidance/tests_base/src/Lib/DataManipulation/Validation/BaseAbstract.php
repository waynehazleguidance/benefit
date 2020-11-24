<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\DataManipulation\Validation;

abstract class BaseAbstract
{
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

        throw new \LogicException("Fail validation in {$validationClass}->{$method}() from {$initiator}.");
    }

    // ########################################
}
