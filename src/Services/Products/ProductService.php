<?php

namespace App\Services\Products;

use App\Services\Skazka\Entity\Product;
use App\Services\Skazka\Skazka;

class ProductService
{
    /**
     * @var Skazka
     */
    private $skazkaService;

    /**
     * ProductService constructor.
     * @param Skazka $skazka
     */
    public function __construct(Skazka $skazka)
    {
        $this->skazkaService = $skazka;
    }

    /**
     * @param string $status
     * @return array
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getProducts(string $status = Product::STATUS_NEW)
    {
        return $this->skazkaService->getProducts($status);
    }
}
