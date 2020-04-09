<?php

namespace App\Services\Skazka;

use App\Services\Skazka\Entity\Product;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpClient\HttpClient;

class Client
{
    const URL_PREFIX = '/api/v1/';

    private $client;
    private $container;

    /**
     * Client constructor.
     * @param \Symfony\Component\DependencyInjection\Container $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->client = HttpClient::createForBaseUri($container->getParameter('app.skazka.api.base_url'));
    }

    /**
     * @return \Symfony\Contracts\HttpClient\HttpClientInterface
     */
    public function getClient(): \Symfony\Contracts\HttpClient\HttpClientInterface
    {
        return $this->client;
    }

    /**
     * @param \Symfony\Contracts\HttpClient\HttpClientInterface $client
     */
    public function setClient(\Symfony\Contracts\HttpClient\HttpClientInterface $client): void
    {
        $this->client = $client;
    }

    /**
     * @param string $status
     * @return array|mixed
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getProducts(string $status = Product::STATUS_NEW)
    {
        $response = $this->client->request('GET', $this->getUrlPrefix('products'), [
            'query' => [
                'marketplace' => 'amazon',
                'marketplace_status' => $status
            ]
        ])->toArray();

        return array_key_exists('data', $response) ? $response['data'] : [];
    }

    /**
     * @param $url
     * @return string
     */
    private function getUrlPrefix(string $url): string
    {
        return self::URL_PREFIX . $url;
    }
}
