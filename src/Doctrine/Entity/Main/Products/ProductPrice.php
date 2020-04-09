<?php

namespace App\Doctrine\Entity\Main\Products;

use App\Doctrine\Entity\Main\Currency;
use App\Doctrine\Entity\Main\Feed;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Doctrine\Repository\Main\Products\ProductPriceRepository")
 */
class ProductPrice
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Doctrine\Entity\Main\Products\Product", inversedBy="productPrice", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\ManyToMany(targetEntity="App\Doctrine\Entity\Main\Feed", inversedBy="productPrices")
     */
    private $feed;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $amount;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity="App\Doctrine\Entity\Main\Currency", inversedBy="product_price")
     * @ORM\JoinColumn(nullable=false)
     */
    private $currency;

    /**
     * ProductPrice constructor.
     */
    public function __construct()
    {
        $this->feed = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Product|null
     */
    public function getProduct(): ?Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     * @return $this
     */
    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return Collection|Feed[]
     */
    public function getFeed(): Collection
    {
        return $this->feed;
    }

    /**
     * @param Feed $feed
     * @return $this
     */
    public function addFeed(Feed $feed): self
    {
        if (!$this->feed->contains($feed)) {
            $this->feed[] = $feed;
        }

        return $this;
    }

    /**
     * @param Feed $feed
     * @return $this
     */
    public function removeFeed(Feed $feed): self
    {
        if ($this->feed->contains($feed)) {
            $this->feed->removeElement($feed);
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAmount(): ?string
    {
        return $this->amount;
    }

    /**
     * @param string $amount
     * @return $this
     */
    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return Currency|null
     */
    public function getCurrency(): ?Currency
    {
        return $this->currency;
    }

    /**
     * @param Currency|null $currency
     * @return $this
     */
    public function setCurrency(?Currency $currency): self
    {
        $this->currency = $currency;

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
