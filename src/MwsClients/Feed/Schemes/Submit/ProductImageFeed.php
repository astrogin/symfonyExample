<?php

namespace App\MwsClients\Feed\Schemes\Submit;

class ProductImageFeed
{
    /***
     * @var string
     */
    private $cdn;
    /***
     * @var string
     */
    private $place;
    /**
     * @var string
     */
    private $sku;

    /**
     * ProductImageFeed constructor.
     * @param string $cdn
     * @param string $place
     * @param string $sku
     */
    public function __construct(string $cdn, string $place, string $sku)
    {
        $this->setSku($sku);
        $this->setCdn($cdn);
        $this->setPlace($place);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'SKU' => $this->getSku(),
            'ImageType' => $this->getPlace(),
            'ImageLocation' => $this->getCdn(),
        ];
    }

    /**
     * @return string
     */
    public function getCdn(): string
    {
        return $this->cdn;
    }

    /**
     * @param string $cdn
     */
    public function setCdn(string $cdn): void
    {
        $this->cdn = $cdn;
    }

    /**
     * @return string
     */
    public function getPlace(): string
    {
        return $this->place;
    }

    /**
     * @param string $place
     */
    public function setPlace(string $place): void
    {
        $this->place = $place;
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
}
