<?php

namespace App\Doctrine\Entity\Main;

use App\Doctrine\Entity\Main\Products\Product;
use App\Doctrine\Entity\Main\Products\ProductImage;
use App\Doctrine\Entity\Main\Products\ProductInventory;
use App\Doctrine\Entity\Main\Products\ProductPrice;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Doctrine\Repository\Main\FeedRepository")
 */
class Feed
{
    const NEW_STATUS = '_NEW_';
    const UNCONFIRMED_STATUS = '_UNCONFIRMED_';
    const SUBMITTED_STATUS = '_SUBMITTED_';
    const IN_SAFETY_NET_STATUS = '_IN_SAFETY_NET_';
    const IN_PROGRESS_STATUS = '_IN_PROGRESS_';
    const DONE_STATUS = '_DONE_';
    const CANCELLED_STATUS = '_CANCELLED_';
    const AWAITING_ASYNCHRONOUS_REPLY_STATUS = '_AWAITING_ASYNCHRONOUS_REPLY_';
    const ERROR_STATUS = '_ERROR';

    const POST_PRODUCT_TYPE = '_POST_PRODUCT_DATA_';
    const POST_PRODUCT_IMAGE_TYPE = '_POST_PRODUCT_IMAGE_DATA_';
    const POST_PRODUCT_PRICING_TYPE = '_POST_PRODUCT_PRICING_DATA_';
    const POST_INVENTORY_AVAILABILITY_TYPE = '_POST_INVENTORY_AVAILABILITY_DATA_';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $submission_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $path;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\ManyToMany(targetEntity="App\Doctrine\Entity\Main\Products\ProductImage", mappedBy="feed")
     */
    private $productImages;

    /**
     * @ORM\ManyToMany(targetEntity="App\Doctrine\Entity\Main\Products\ProductInventory", mappedBy="feed")
     */
    private $productInventories;

    /**
     * @ORM\ManyToMany(targetEntity="App\Doctrine\Entity\Main\Products\ProductPrice", mappedBy="feed")
     */
    private $productPrices;
    /**
     * @ORM\ManyToMany(targetEntity="App\Doctrine\Entity\Main\Products\Product", mappedBy="feed")
     */
    private $product;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * Feed constructor.
     */
    public function __construct()
    {
        $this->productImages = new ArrayCollection();
        $this->productInventories = new ArrayCollection();
        $this->productPrices = new ArrayCollection();
        $this->product = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getSubmissionId(): ?string
    {
        return $this->submission_id;
    }

    /**
     * @param string $submission_id
     * @return $this
     */
    public function setSubmissionId(string $submission_id): self
    {
        $this->submission_id = $submission_id;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @param string|null $path
     * @return $this
     */
    public function setPath(?string $path): self
    {
        $this->path = $path;

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

    /**
     * @return Collection|ProductImage[]
     */
    public function getProductImages(): Collection
    {
        return $this->productImages;
    }

    /**
     * @param ProductImage $productImage
     * @return $this
     */
    public function addProductImage(ProductImage $productImage): self
    {
        if (!$this->productImages->contains($productImage)) {
            $this->productImages[] = $productImage;
            $productImage->addFeed($this);
        }

        return $this;
    }

    /**
     * @param ProductImage $productImage
     * @return $this
     */
    public function removeProductImage(ProductImage $productImage): self
    {
        if ($this->productImages->contains($productImage)) {
            $this->productImages->removeElement($productImage);
            $productImage->removeFeed($this);
        }

        return $this;
    }

    /**
     * @return Collection|ProductInventory[]
     */
    public function getProductInventories(): Collection
    {
        return $this->productInventories;
    }

    /**
     * @param ProductInventory $productInventory
     * @return $this
     */
    public function addProductInventory(ProductInventory $productInventory): self
    {
        if (!$this->productInventories->contains($productInventory)) {
            $this->productInventories[] = $productInventory;
            $productInventory->addFeed($this);
        }

        return $this;
    }

    /**
     * @param ProductInventory $productInventory
     * @return $this
     */
    public function removeProductInventory(ProductInventory $productInventory): self
    {
        if ($this->productInventories->contains($productInventory)) {
            $this->productInventories->removeElement($productInventory);
            $productInventory->removeFeed($this);
        }

        return $this;
    }

    /**
     * @return Collection|ProductPrice[]
     */
    public function getProductPrices(): Collection
    {
        return $this->productPrices;
    }

    /**
     * @param ProductPrice $productPrice
     * @return $this
     */
    public function addProductPrice(ProductPrice $productPrice): self
    {
        if (!$this->productPrices->contains($productPrice)) {
            $this->productPrices[] = $productPrice;
            $productPrice->addFeed($this);
        }

        return $this;
    }

    /**
     * @param ProductPrice $productPrice
     * @return $this
     */
    public function removeProductPrice(ProductPrice $productPrice): self
    {
        if ($this->productPrices->contains($productPrice)) {
            $this->productPrices->removeElement($productPrice);
            $productPrice->removeFeed($this);
        }

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProduct(): Collection
    {
        return $this->product;
    }

    /**
     * @param Product $product
     * @return $this
     */
    public function addProduct(Product $product): self
    {
        if (!$this->product->contains($product)) {
            $this->product[] = $product;
            $product->addFeed($this);
        }

        return $this;
    }

    /**
     * @param Product $product
     * @return $this
     */
    public function removeProduct(Product $product): self
    {
        if ($this->product->contains($product)) {
            $this->product->removeElement($product);
            $product->removeFeed($this);
        }

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
