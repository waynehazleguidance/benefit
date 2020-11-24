<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Object;

class ClassDescriber
{
    /** @var \ReflectionClass */
    protected $reflectionClass = null;

    // ########################################

    public function __construct(\ReflectionClass $reflectionClass)
    {
        $this->reflectionClass = $reflectionClass;
    }

    // ########################################

    public function getName(): string
    {
        return $this->reflectionClass->getShortName();
    }

    public function getNamespace(): string
    {
        return $this->reflectionClass->getNamespaceName();
    }

    public function getRelativeNamespace(): string
    {
        $classFullName = $this->getFullName();

        $pattern = '/'. preg_quote(\Guidance\Tests\Base\ProjectInfo::CHILD_NAMESPACE_PREFIX) . '/';

        return preg_replace($pattern, '', $classFullName);
    }

    public function getFullName(): string
    {
        return $this->reflectionClass->getName();
    }

    public function getPath(): string
    {
        return \dirname($this->reflectionClass->getFileName()) . DIRECTORY_SEPARATOR;
    }

    public function getPublicMethods(): array
    {
        return $this->reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC);
    }

    // ########################################
}
