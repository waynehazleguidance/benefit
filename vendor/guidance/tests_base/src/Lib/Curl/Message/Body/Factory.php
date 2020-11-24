<?php

declare(strict_types=1);

namespace Guidance\Tests\Base\Lib\Curl\Message\Body;

class Factory
{
    use \Guidance\Tests\Base\Object\FactoryTrait;

    /**
     * @Inject
     * @var \Guidance\Tests\Base\Lib\DataManipulation\Json
     */
    private $json = null;

    // ########################################

    public function create(string $contentType, $data): \Guidance\Tests\Base\Lib\Curl\Message\Body
    {
        return $this->di->make(\Guidance\Tests\Base\Lib\Curl\Message\Body::class, [
            'contentType' => $contentType,
            'data'        => $data,
        ]);
    }

    // ########################################

    public function json($data): \Guidance\Tests\Base\Lib\Curl\Message\Body
    {
        return $this->create('application/json', $this->json->encode($data));
    }

    // ########################################

    public function multipartFormUrlEncoded(array $form): \Guidance\Tests\Base\Lib\Curl\Message\Body
    {
        $post = http_build_query($form, '', '&');

        return $this->create('application/x-www-form-urlencoded', $post);
    }

    // ########################################

    public function multipartFormData(array $form): \Guidance\Tests\Base\Lib\Curl\Message\Body
    {
        foreach ($form as &$value) {
            if ($value instanceof \Guidance\Tests\Base\Lib\FileSystem\File) {
                $curlFile = new \CURLFile($value->getPath());

                if ($value instanceof File) {
                    $curlFile->setMimeType($value->getMimeType());
                    $curlFile->setPostFilename($value->getPostName());
                }

                $value = $curlFile;
            }
        }

        return $this->create('multipart/form-data', $form);
    }

    // ########################################
}
