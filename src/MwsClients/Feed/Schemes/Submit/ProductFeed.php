<?php

namespace App\MwsClients\Feed\Schemes\Submit;

use App\Doctrine\Entity\Main\Products\Product;
use App\Exceptions\ProductTypeNotSupported;

class ProductFeed
{
    const ITEM_TYPE_NESTING_DOLLS = 'nesting-dolls';

    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * @return array
     * @throws ProductTypeNotSupported
     */
    public function toArray()
    {
        return [
            'SKU' => $this->product->getTextId(),
            'StandardProductID' => $this->getStandardProductId(),
            'ProductTaxCode' => $this->product->getProductTaxCode(),
            'LaunchDate' => $this->product->getLaunchDate()->format('c'),
            'ReleaseDate' => $this->product->getReleaseDate()->format('c'),
            'DescriptionData' => $this->getDescriptionData(),
            'ProductData' => $this->getProductData()
        ];
    }

    protected function getDescriptionData(): array
    {
        switch ($this->product->getItemType()) {
            case self::ITEM_TYPE_NESTING_DOLLS:
                return $this->getDescriptionDataForNestingDolls();
            default:
                throw new ProductTypeNotSupported(
                    'Product type ' . $this->product->getItemType() . 'Not supported'
                );
        }
    }

    public function getProductData(): array
    {
        switch ($this->product->getItemType()) {
            case self::ITEM_TYPE_NESTING_DOLLS:
                return $this->getProductDataForNestingDolls();
            default:
                throw new ProductTypeNotSupported(
                    'Product type ' . $this->product->getItemType() . 'Not supported'
                );
        }
    }

    /**
     * @return array
     */
    private function getStandardProductId(): array
    {
        return [
            'Type' => strtoupper($this->product->getBarcodeType()),
            'Value' => $this->product->getBarcode()
        ];
    }

    private function getDescriptionDataForNestingDolls(): array
    {
        $filteredBulletPoints = [];
        $bulletPoints = explode(';', $this->product->getBulletPoint());

        if (is_array($bulletPoints) && count($bulletPoints)) {
            foreach ($bulletPoints as $bulletPoint) {
                if (strlen($bulletPoint) > 1) {
                    $filteredBulletPoints[] = (string)trim($bulletPoint);
                }
            }
        } else {
            $filteredBulletPoints = [$this->product->getBulletPoint()];
        }

        return [
            'Title' => $this->product->getTitle(),
            //'Brand' => $this->product->getBrand(),
            'Description' => strip_tags($this->product->getDescription()),
            'BulletPoint' => $filteredBulletPoints,
            'Manufacturer' => $this->product->getManufacturer(),
            'ItemType' => $this->product->getItemType(),
            'TargetAudience' => $this->product->getTargetAudience()
        ];
    }

    private function getProductDataForNestingDolls(): array
    {
        return [
            $this->product->getProductDataMainCategory() => [
                'ProductType' => [
                    $this->product->getProductTypeMainCategory() => []
                ],
                'AgeRecommendation' => [
                    'MinimumManufacturerAgeRecommended' => [
                        '@unitOfMeasure' => $this->product->getMinimumManufacturerAgeRecommendedUnitOfMeasure(),
                        '#' => $this->product->getMinimumManufacturerAgeRecommendedValue()
                    ],
                ]
            ]
        ];
    }

}