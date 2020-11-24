<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\DataManipulation;

class Json
{
    // ########################################

    public function encode(array $data): string
    {
        $encoded = json_encode($data);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $encoded;
        }

        try {
            $encoded = \Zend\Json\Encoder::encode($data, true);

        } catch (\Zend\Json\Exception\ExceptionInterface $e) {
            throw new \RuntimeException('Unable to encode JSON. ' . $e->getMessage());
        }

        return $encoded;
    }

    public function decode(string $data)
    {
        if (empty($data)) {
            throw new \LogicException('Unable to decode JSON. Data should not be an empty string.');
        }

        $decoded = json_decode($data, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $decoded;
        }

        try {
            $decoded = \Zend\Json\Decoder::decode($data, \Zend\Json\Json::TYPE_ARRAY);
        } catch (\Zend\Json\Exception\RuntimeException $e) {
            throw new \RuntimeException('Unable to decode JSON. ' . $e->getMessage());
        }

        return $decoded;
    }

    // ########################################
}
