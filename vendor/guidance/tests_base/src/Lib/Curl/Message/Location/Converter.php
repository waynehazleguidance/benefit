<?php

declare(strict_types=1);

namespace  Guidance\Tests\Base\Lib\Curl\Message\Location;

class Converter
{
    // ########################################

    public function toString(\Guidance\Tests\Base\Lib\Curl\Message\Location $location): string
    {
        $url = '';
        $url .= $location->getScheme() . '://';

        $url .= $location->getHost();

        $defaultSchemePort = $location->isSSL() ? \Guidance\Tests\Base\Lib\Curl\Message\Location::PORT_HTTPS
                                                : \Guidance\Tests\Base\Lib\Curl\Message\Location::PORT_HTTP;

        if ($location->getPort() !== $defaultSchemePort) {
            $url .= ":{$location->getPort()}";
        }

        $url .= $location->getPath();

        if (count($location->getQueryParameters()) > 0) {
            $url .= '?' . http_build_query($location->getQueryParameters());
        }

        if ( ! is_null($location->getFragment())) {
            $url .= '#' . $location->getFragment();
        }

        return $url;
    }

    // ########################################
}
