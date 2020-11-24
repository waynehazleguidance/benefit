<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\Curl\Processor\Handle;

class Factory
{
    use \Guidance\Tests\Base\Object\FactoryTrait;

    /** @var \Guidance\Tests\Base\Lib\Curl\Message\Location\Converter */
    private $locationConverter = null;

    // ########################################

    public function __construct(\Guidance\Tests\Base\Lib\Curl\Message\Location\Converter $locationConverter)
    {
        $this->locationConverter = $locationConverter;
    }

    // ########################################

    public function create(\Guidance\Tests\Base\Lib\Curl\Message\Request $request)
    {
        $url            = $this->locationConverter->toString($request->getLocation());
        $connectionInfo = $request->getConnectionInfo();

        $handle = curl_init();

        if ($handle === false) {
            throw new \RuntimeException('Unable create handle.');
        }

        try {
            $options = [
                CURLOPT_URL            => $url,
                CURLOPT_CONNECTTIMEOUT => $connectionInfo->getConnectionTimeout(),
                CURLOPT_TIMEOUT        => $connectionInfo->getExecutionTimeout(),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER         => true,
                CURLOPT_SSL_VERIFYPEER => $connectionInfo->isVerifySsl(),
                CURLOPT_SSL_VERIFYHOST => $connectionInfo->isVerifySsl() ? 2 : 0,
                CURLOPT_SSLVERSION     => $connectionInfo->getSslVersion(),
                CURLOPT_CUSTOMREQUEST  => $request->getHttpMethod(),
                CURLOPT_USERPWD        => $connectionInfo->getAuthorization()
            ];

            if ($connectionInfo->isFollowLocation()) {
                $options[CURLOPT_FOLLOWLOCATION] = true;

                $options[CURLOPT_POSTREDIR] = 3;
            }

            $options[CURLOPT_MAXREDIRS] = $connectionInfo->getMaxRedirecting();

            if ($request->hasBody()) {
                $post = $request->getBody()->getData();

                $options[CURLOPT_POSTFIELDS] = $post;
            }

            $headers = $request->getHeaders()->getAll();

            $preparedHeaders = [];
            foreach ($headers as $key => $value) {
                $preparedHeaders[] = "{$key}: {$value}";
            }

            $options[CURLOPT_HTTPHEADER] = $preparedHeaders;

            if (!empty($request->getCookies())) {
                $preparedCookies = '';
                foreach ($request->getCookies() as $key => $value) {
                    if (!empty($preparedCookies)) {
                        $preparedCookies .= ';';
                    }

                    $preparedCookies .= "{$key}={$value}";
                }

                $options[CURLOPT_COOKIE] = $preparedCookies;
            }

            curl_setopt_array($handle, $options);

            return $handle;
        } catch (\Throwable $throwable) {
            curl_close($handle);
            throw $throwable;
        }
    }

    // ########################################
}
