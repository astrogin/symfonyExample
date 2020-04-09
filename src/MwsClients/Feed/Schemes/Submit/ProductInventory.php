<?php

namespace App\MwsClients\Feed\Schemes\Submit;

class ProductInventory
{
    /**
     * @var string
     */
    private $sku;
    /**
     * @var int
     */
    private $quantity;

    /**
     * ProductInventory constructor.
     * @param string $sku
     * @param int $quantity
     */
    public function __construct(string $sku, int $quantity)
    {
        $this->setSku($sku);
        $this->setQuantity($quantity);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'SKU' => $this->getSku(),
            'Quantity' => $this->getQuantity()
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
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }
}
