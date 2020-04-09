<?php

namespace App\Services\Skazka;

use App\Services\Skazka\Entity\Product;

/**
 * Class Skazka
 * @package App\Services\Skazka
 */
class Skazka
{
    private $client;
    private $responseHandler;

    /**
     * Skazka constructor.
     * @param Client $client
     * @param ResponseHandler $responseHandler
     */
    public function __construct(Client $client, ResponseHandler $responseHandler)
    {
        $this->client = $client;
        $this->responseHandler = $responseHandler;
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
        $products = $this->client->getProducts($status);

        return $this->responseHandler->handleProductResponse($products);
    }
}
