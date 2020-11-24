<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\DataManipulation\Json\Tools;

class StripComments
{
    // ########################################

    public function process(string $json): string
    {
        if ( ! is_string($json)) {
            throw new \LogicException('Json is not valid.');
        }

        if (empty($json)) {
            return '';
        }

        $result = preg_replace('#//.*#', '', $json);
        if (is_null($result)) {
            throw new \RuntimeException('Unable to strip comments.');
        }

        return $result;
    }

    // ########################################
}
