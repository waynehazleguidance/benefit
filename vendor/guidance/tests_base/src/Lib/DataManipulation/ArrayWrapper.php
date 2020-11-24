<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\DataManipulation;

class ArrayWrapper
{
    /** @var array */
    private $data;

    /** @var array */
    private $cache = [];

    /** @var \Guidance\Tests\Base\Lib\DataManipulation\ArrayWrapper\Factory */
    private $arrayWrapperFactory;

    // ########################################

    public function __construct(array $data, ArrayWrapper\Factory $arrayWrapperFactory)
    {
        $this->data                = $data;
        $this->arrayWrapperFactory = $arrayWrapperFactory;
    }

    // ########################################

    public function isEmpty(): bool
    {
        return empty($this->get());
    }

    // ########################################

    public function has($path): bool
    {
        try {
            $this->get($path);
        } catch (\Throwable $e) {
            return false;
        }

        return true;
    }

    public function set(?string $path, $value): self
    {
        if (is_null($path)) {
            $this->data = $value;

            return $this;
        }

        $this->validatePath($path);

        $storage = &$this->data;

        foreach ($this->explodePath($path) as $node) {
            if (!array_key_exists($node, $storage) || ! $this->isArray($storage[$node])) {
                $storage[$node] = [];
            }

            $storage = &$storage[$node];
        }

        $storage = $value;

        $this->cache[$path] = $value;

        return $this;
    }

    public function get(?string $path = null)
    {
        if (is_null($path)) {
            return $this->data;
        }

        $this->validatePath($path);

        if (array_key_exists($path, $this->cache)) {
            return $this->cache[$path];
        }

        $result = $this->data;
        foreach ($this->explodePath($path) as $node) {
            if ( ! $this->isArray($result) || !array_key_exists($node, $result)) {
                throw new \LogicException("Path {$path} is not exist.");
            }

            $result = $result[$node];
        }

        $this->cache[$path] = $result;

        return $result;
    }

    public function slice(string $path): self
    {
        $result = $this->get($path);

        if ($this->isArray($result) === false) {
            throw new \LogicException(
                "Path '{$path}' is not an array.");
        }

        return $this->arrayWrapperFactory->create($result);
    }

    public function delete(?string $path = null)
    {
        if (is_null($path)) {
            $this->data = [];

            return $this;
        }

        $this->validatePath($path);

        $storage = &$this->data;

        $explodedPath = $this->explodePath($path);
        while ($node = array_shift($explodedPath)) {
            if ( ! $this->isArray($storage)) {
                return $this;
            }

            if (!array_key_exists($node, $storage)) {
                return $this;
            }

            if (empty($explodedPath)) { // last node
                unset($storage[$node], $this->cache[$path]);

                return $this;
            }

            $storage = &$storage[$node];
        }

        return $this;
    }

    // ########################################

    public function merge(ArrayWrapper $another): self
    {
        $this->data = $this->internalMerge($this->data, $another->get());

        return $this;
    }

    // ----------------------------------------

    private function internalMerge(array $mainStorage, array $source): array
    {
        foreach ($source as $key => $sourceValue) {
            if (isset($mainStorage[$key]) || array_key_exists($key, $mainStorage)) {
                if (is_array($sourceValue) && is_array($mainStorage[$key])) {
                    $mainStorage[$key] = $this->internalMerge($mainStorage[$key], $sourceValue);
                } else {
                    $mainStorage[$key] = $sourceValue;
                }
            } else {
                $mainStorage[$key] = $sourceValue;
            }
        }

        return $mainStorage;
    }

    // ########################################

    private function explodePath(string $path): array
    {
        $exploded = explode('/', trim($path, '/'));

        $count = count($exploded);

        for ($i = 0; $i < $count; $i++) {
            $chunk = $exploded[$i];

            if ($chunk === '' || trim($chunk) !== $chunk) {
                throw new \LogicException("Path '{$path}' is not valid.");
            }

            if (substr($chunk, -1) === '\\') {
                $next = $i + 1;

                $exploded[$next] = substr($chunk, 0, -1) . '/' . $exploded[$next];

                unset($exploded[$i]);
            }
        }

        return array_values($exploded);
    }

    // ########################################

    private function validatePath(string $path): void
    {
        if (strlen($path) > 2 && $path[0] === '/' && substr($path, -1) === '/') {
            return;
        }

        throw new \LogicException("Path '{$path}' is not valid. ");
    }

    // ########################################

    private function isArray($value): bool
    {
        return is_array($value) || $value instanceof \ArrayObject;
    }

    // ########################################
}
