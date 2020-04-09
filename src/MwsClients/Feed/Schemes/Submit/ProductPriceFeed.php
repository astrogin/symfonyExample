<?php

namespace App\MwsClients\Feed\Schemes\Submit;

class ProductPriceFeed
{
    /***
     * @var string
     */
    private $sku;
    /***
     * @var string
     */
    private $currency;
    /**
     * @var string
     */
    private $price;

    /**
     * ProductPriceFeed constructor.
     * @param string $currency
     * @param string $price
     * @param string $sku
     */
    public function __construct(string $currency, string $price, string $sku)
    {
        $this->setPrice($price);
        $this->setCurrency($currency);
        $this->setSku($sku);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'SKU' => $this->getSku(),
            'StandardPrice' => ['@currency' => $this->getCurrency(), '#' => $this->getPrice()]
        ];
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @param string $sku
     */
    public function setSku(string $sku): void
    {
        $this->sku = $sku;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @param string $price
     */
    public function setPrice(string $price): void
    {
        $this->price = bcadd($price, 0, 2);
    }

}
