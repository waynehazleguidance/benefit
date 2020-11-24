<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Test;

class Describer extends \Guidance\Tests\Base\Object\ClassDescriber
{
    const TEST_CLASS_ENDING_PATTERN = '/Cest$/';

    // ########################################

    public function getName(): string
    {
        return preg_replace(self::TEST_CLASS_ENDING_PATTERN, '', $this->getName());
    }

    public function getRelativeNamespace(): string
    {
        $classFullName = $this->getFullName();

        $patterns = [
            '/'. preg_quote(\Guidance\Tests\Base\ProjectInfo::CHILD_NAMESPACE_PREFIX) . '/',
            \Guidance\Tests\Base\Test\Describer::TEST_CLASS_ENDING_PATTERN
        ];

        return preg_replace($patterns, '', $classFullName);
    }

    // ########################################

    public function getMethods(): array
    {
        $testMethodsNames = [];

        $publicMethods = $this->getPublicMethods();

        foreach ($publicMethods as $method) {

            if ($this->isMagicMethod($method)) {
                continue;
            }

            $testMethodsNames[] = $method->name;
        }

        return $testMethodsNames;
    }

    public function getFirstMethod(): ?string
    {
        $testsMethods = $this->getMethods();

        if ($testsMethods) {
            return $testsMethods[0];
        }

        return null;
    }

    public function getLastMethod(): ?string
    {
        $testsList = $this->getMethods();

        if ($testsList) {
            return $testsList[\count($testsList) - 1];
        }

        return null;
    }

    // ########################################

    private function isMagicMethod(\ReflectionMethod $method): bool
    {
        return 0 === strpos($method->name, '_');
    }

    // ########################################
}
