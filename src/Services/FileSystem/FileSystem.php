<?php

namespace App\Services\FileSystem;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem as ParentFilesystem;

class FileSystem extends ParentFilesystem
{

    private $container;
    private $storagePath;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->storagePath = $container->getParameter('kernel.project_dir') . $container->getParameter('app.storage.path');
    }

    /**
     * @param $data
     * @return string
     * @throws \Exception
     */
    public function saveXml($data)
    {
        $productXml = new \SimpleXMLElement($data);
        $productFilePath = bin2hex(random_bytes(4));
        $productFileName = md5(time()) . '.xml';
        $relativePath = DIRECTORY_SEPARATOR . $productFilePath . DIRECTORY_SEPARATOR . $productFileName;
        $this->mkdir($this->storagePath . DIRECTORY_SEPARATOR . $productFilePath);

        $productXml->saveXML($this->storagePath . $relativePath);

        return $relativePath;
    }

    /**
     * @param $path
     * @return \SimpleXMLElement
     */
    public function getXml($path)
    {
        $path = $this->storagePath . $path;

        if (file_exists($path)) {
            return new \SimpleXMLElement($path, 0, true);
        }

        return null;
    }
}
