<?php

namespace App\Doctrine\Entity\Main\Products;

use App\Doctrine\Entity\Main\Feed;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Doctrine\Repository\Main\Products\ProductImageRepository")
 */
class ProductImage
{
    const MAIN_PLACE = 'Main';
    const PT1_PLACE = 'PT1';
    const PT2_PLACE = 'PT2';
    const PT3_PLACE = 'PT3';
    const PT4_PLACE = 'PT4';
    const PT5_PLACE = 'PT5';

    const PLACES = [
        self::MAIN_PLACE,
        self::PT1_PLACE,
        self::PT2_PLACE,
        self::PT3_PLACE,
        self::PT4_PLACE,
        self::PT5_PLACE
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Doctrine\Entity\Main\Products\Product", inversedBy="productImages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\ManyToMany(targetEntity="App\Doctrine\Entity\Main\Feed", inversedBy="productImages")
     */
    private $feed;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $place;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * ProductImage constructor.
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
     * @param Product|null $product
     * @return $this
     */
    public function setProduct(?Product $product): self
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
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return $this
     */
    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlace(): ?string
    {
        return $this->place;
    }

    /**
     * @param string $place
     * @return $this
     */
    public function setPlace(string $place): self
    {
        $this->place = $place;

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
