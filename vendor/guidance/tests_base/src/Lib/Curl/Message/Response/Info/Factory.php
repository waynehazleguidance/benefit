<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\Curl\Message\Response\Info;

class Factory
{
    use \Guidance\Tests\Base\Object\FactoryTrait;

    // ########################################

    public function create(
        array $data
    ): \Guidance\Tests\Base\Lib\Curl\Message\Response\Info {
        return $this->di->make(
            \Guidance\Tests\Base\Lib\Curl\Message\Response\Info::class,
            [
                'url'         => $data['url'],
                'redirectUrl' => $data['redirect_url'],

                'primaryIp'   => $data['primary_ip'],
                'primaryPort' => $data['primary_port'],

                'redirectCount' => $data['redirect_count'],
                'redirectTime'  => $data['redirect_time'],

                'httpCode'    => $data['http_code'],
                'contentType' => $data['content_type'],

                'totalTime'         => $data['total_time'],
                'nameLookupTime'    => $data['namelookup_time'],
                'connectTime'       => $data['connect_time'],
                'preTransferTime'   => $data['pretransfer_time'],
                'startTransferTime' => $data['starttransfer_time'],

                'headerSize'  => $data['header_size'],
                'requestSize' => $data['request_size'],

                'downloadContentLength' => $data['download_content_length'],
                'downloadSize'          => $data['size_download'],
                'downloadSpeed'         => $data['speed_download'],
                'uploadContentLength'   => $data['upload_content_length'],
                'uploadSize'            => $data['size_upload'],
                'uploadSpeed'           => $data['speed_upload'],

                'sslVerifyResult' => $data['ssl_verify_result'],
                'certInfo'        => $data['certinfo'],
            ]
        );
    }

    // ########################################
}
