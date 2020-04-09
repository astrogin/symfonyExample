<?php

namespace App\Doctrine\Entity\Main;

use App\Doctrine\Entity\Main\Products\ProductPrice;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Doctrine\Repository\Main\CurrencyRepository")
 */
class Currency
{
    const USD_CODE = 'usd';
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Doctrine\Entity\Main\Products\ProductPrice", mappedBy="currency")
     */
    private $product_price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $symbol;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * Currency constructor.
     */
    public function __construct()
    {
        $this->product_price = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|ProductPrice[]
     */
    public function getProductPrice(): Collection
    {
        return $this->product_price;
    }

    /**
     * @param ProductPrice $productPrice
     * @return $this
     */
    public function addProductPrice(ProductPrice $productPrice): self
    {
        if (!$this->product_price->contains($productPrice)) {
            $this->product_price[] = $productPrice;
            $productPrice->setCurrency($this);
        }

        return $this;
    }

    /**
     * @param ProductPrice $productPrice
     * @return $this
     */
    public function removeProductPrice(ProductPrice $productPrice): self
    {
        if ($this->product_price->contains($productPrice)) {
            $this->product_price->removeElement($productPrice);
            // set the owning side to null (unless already changed)
            if ($productPrice->getCurrency() === $this) {
                $productPrice->setCurrency(null);
            }
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return $this
     */
    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    /**
     * @param string $symbol
     * @return $this
     */
    public function setSymbol(string $symbol): self
    {
        $this->symbol = $symbol;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    /**
     * @param \DateTimeInterface $created_at
     * @return $this
     * @throws \Exception
     */
    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at ?? new \DateTime();

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    /**
     * @param \DateTimeInterface $updated_at
     * @return $this
     * @throws \Exception
     */
    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at ?? new \DateTime();

        return $this;
    }
}
