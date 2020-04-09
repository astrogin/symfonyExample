<?php

namespace App\Doctrine\Entity\Main\Products;

use App\Doctrine\Entity\Main\Feed;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Doctrine\Repository\Main\Products\ProductRepository")
 */
class Product
{
    const EAN_13_BARCODE_TYPE = 'ean_13';
    const EAN_BARCODE_TYPE = 'EAN';
    const NEW_STATUS = 'new';
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $text_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sku;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity="App\Doctrine\Entity\Main\Products\ProductImage", mappedBy="product", orphanRemoval=true)
     */
    private $productImages;

    /**
     * @ORM\OneToMany(targetEntity="App\Doctrine\Entity\Main\Products\ProductInventory", mappedBy="product")
     */
    private $productInventories;

    /**
     * @ORM\OneToOne(targetEntity="App\Doctrine\Entity\Main\Products\ProductPrice", mappedBy="product", cascade={"persist", "remove"})
     */
    private $productPrice;

    /**
     * @ORM\ManyToMany(targetEntity="App\Doctrine\Entity\Main\Feed", inversedBy="productImages")
     */
    private $feed;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $external_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $product_tax_code;

    /**
     * @ORM\Column(type="datetime")
     */
    private $launch_date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $release_date;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $bullet_point;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $item_type;

    /**
     * @ORM\Column(type="text")
     */
    private $target_audience;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $product_data_main_category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $product_type_main_category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $minimum_manufacturer_age_recommended_unit_of_measure;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $minimum_manufacturer_age_recommended_value;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $barcode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $barcode_type;

    /**
     * @ORM\Column(type="text")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $brand;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $manufacturer;

    /**
     * Product constructor.
     */
    public function __construct()
    {
        $this->productImages = new ArrayCollection();
        $this->productInventories = new ArrayCollection();
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
     * @return string|null
     */
    public function getTextId(): ?string
    {
        return $this->text_id;
    }

    /**
     * @param string $text_id
     * @return $this
     */
    public function setTextId(string $text_id): self
    {
        $this->text_id = $text_id;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSku(): ?string
    {
        return $this->sku;
    }

    /**
     * @param string $sku
     * @return $this
     */
    public function setSku(string $sku): self
    {
        $this->sku = $sku;

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
            $productImage->setProduct($this);
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
            // set the owning side to null (unless already changed)
            if ($productImage->getProduct() === $this) {
                $productImage->setProduct(null);
            }
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
            $productInventory->setProduct($this);
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
            // set the owning side to null (unless already changed)
            if ($productInventory->getProduct() === $this) {
                $productInventory->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return ProductPrice|null
     */
    public function getProductPrice(): ?ProductPrice
    {
        return $this->productPrice;
    }

    /**
     * @param ProductPrice $productPrice
     * @return $this
     */
    public function setProductPrice(ProductPrice $productPrice): self
    {
        $this->productPrice = $productPrice;

        // set the owning side of the relation if necessary
        if ($productPrice->getProduct() !== $this) {
            $productPrice->setProduct($this);
        }

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

    public function getExternalId(): ?string
    {
        return $this->external_id;
    }

    public function setExternalId(string $external_id): self
    {
        $this->external_id = $external_id;

        return $this;
    }

    public function getProductTaxCode(): ?string
    {
        return $this->product_tax_code;
    }

    public function setProductTaxCode(string $product_tax_code): self
    {
        $this->product_tax_code = $product_tax_code;

        return $this;
    }

    public function getLaunchDate(): ?\DateTimeInterface
    {
        return $this->launch_date;
    }

    public function setLaunchDate(\DateTimeInterface $launch_date): self
    {
        $this->launch_date = $launch_date;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->release_date;
    }

    public function setReleaseDate(\DateTimeInterface $release_date): self
    {
        $this->release_date = $release_date;

        return $this;
    }

    public function getBulletPoint(): ?string
    {
        return $this->bullet_point;
    }

    public function setBulletPoint(?string $bullet_point): self
    {
        $this->bullet_point = $bullet_point;

        return $this;
    }

    public function getItemType(): ?string
    {
        return $this->item_type;
    }

    public function setItemType(string $item_type): self
    {
        $this->item_type = $item_type;

        return $this;
    }

    public function getTargetAudience(): ?array
    {
        return $this->target_audience ? json_decode($this->target_audience) : $this->target_audience;
    }

    public function setTargetAudience(array $target_audience): self
    {
        $this->target_audience = json_encode($target_audience);

        return $this;
    }

    public function getProductDataMainCategory(): ?string
    {
        return $this->product_data_main_category;
    }

    public function setProductDataMainCategory(string $product_data_main_category): self
    {
        $this->product_data_main_category = $product_data_main_category;

        return $this;
    }

    public function getProductTypeMainCategory(): ?string
    {
        return $this->product_type_main_category;
    }

    public function setProductTypeMainCategory(?string $product_type_main_category): self
    {
        $this->product_type_main_category = $product_type_main_category;

        return $this;
    }

    public function getMinimumManufacturerAgeRecommendedUnitOfMeasure(): ?string
    {
        return $this->minimum_manufacturer_age_recommended_unit_of_measure;
    }

    public function setMinimumManufacturerAgeRecommendedUnitOfMeasure(?string $minimum_manufacturer_age_recommended_unit_of_measure): self
    {
        $this->minimum_manufacturer_age_recommended_unit_of_measure = $minimum_manufacturer_age_recommended_unit_of_measure;

        return $this;
    }

    public function getMinimumManufacturerAgeRecommendedValue(): ?string
    {
        return $this->minimum_manufacturer_age_recommended_value;
    }

    public function setMinimumManufacturerAgeRecommendedValue(?string $minimum_manufacturer_age_recommended_value): self
    {
        $this->minimum_manufacturer_age_recommended_value = $minimum_manufacturer_age_recommended_value;

        return $this;
    }

    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    public function setBarcode(string $barcode): self
    {
        $this->barcode = $barcode;

        return $this;
    }

    public function getBarcodeType(): ?string
    {
        return $this->barcode_type;
    }

    public function setBarcodeType(string $barcode_type): self
    {
        $this->barcode_type = $barcode_type;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(?string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getManufacturer(): ?string
    {
        return $this->manufacturer;
    }

    public function setManufacturer(?string $manufacturer): self
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }
}
