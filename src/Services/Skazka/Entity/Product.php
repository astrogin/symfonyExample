<?php

namespace App\Services\Skazka\Entity;

use App\Doctrine\Entity\Main\Products\ProductImage;
use App\Validation\Constraints\Ean\Ean;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\DateTime as DateTimeValidator;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Validation;

class Product extends BaseEntity
{
    const STATUS_NEW = 'new';
    const EAN_13_BARCODE_TYPE = 'ean_13';
    const GEN_TAX = 'A_GEN_TAX';
    const NO_TAX = 'A_GEN_NOTAX';

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $textId;

    /**
     * @var array
     */
    private $barcodes;

    /**
     * @var string
     */
    private $productTaxCode;

    /**
     * @var string
     */
    private $launchDate;

    /**
     * @var string
     */
    private $releaseDate;

    /**
     * @var string
     */
    private $brand;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $bulletPoint;

    /**
     * @var string
     */
    private $manufacturer;

    /**
     * @var string
     */
    private $itemType;

    /**
     * @var array
     */
    private $targetAudience;

    /**
     * @var string
     */
    private $productDataMainCategory;

    /**
     * @var string
     */
    private $productTypeMainCategory;

    /**
     * @var string|null
     */
    private $minimumManufacturerAgeRecommendedUnitOfMeasure;

    /**
     * @var string|null
     */
    private $minimumManufacturerAgeRecommendedValue;

    /**
     * @var array
     */
    private $images;

    /**
     * @var int
     */
    private $amount;

    /**
     * @var array
     */
    private $price;

    /**
     * Product constructor.
     * @param $product
     */
    public function __construct($product)
    {
        $this->castFromArray($product);
    }

    /**
     * @param $products
     */
    public function castFromArray($products)
    {
        !array_key_exists('id', $products) ?: $this->setId($products['id']);
        !array_key_exists('title', $products) ?: $this->setTitle($products['title']);
        !array_key_exists('text_id', $products) ?: $this->setTextId($products['text_id']);
        !array_key_exists('barcodes', $products) ?: $this->setBarcodes($products['barcodes']);
        !array_key_exists('product_tax_code', $products) ?: $this->setProductTaxCode($products['product_tax_code']);
        !array_key_exists('launch_date', $products) ?: $this->setLaunchDate($products['launch_date']);
        !array_key_exists('release_date', $products) ?: $this->setReleaseDate($products['release_date']);
        !array_key_exists('brand', $products) ?: $this->setBrand($products['brand']);
        !array_key_exists('description', $products) ?: $this->setDescription($products['description']);
        !array_key_exists('bullet_point', $products) ?: $this->setBulletPoint($products['bullet_point']);
        !array_key_exists('manufacturer', $products) ?: $this->setManufacturer($products['manufacturer']);
        !array_key_exists('item_type', $products) ?: $this->setItemType($products['item_type']);
        !array_key_exists('target_audience', $products) ?: $this->setTargetAudience($products['target_audience']);
        !array_key_exists('product_data_main_category', $products) ?:
            $this->setProductDataMainCategory($products['product_data_main_category']);
        !array_key_exists('product_type_main_category', $products) ?:
            $this->setProductTypeMainCategory($products['product_type_main_category']);
        !array_key_exists('minimum_manufacturer_age_recommended_unit_of_measure', $products) ?:
            $this->setMinimumManufacturerAgeRecommendedUnitOfMeasure(
                $products['minimum_manufacturer_age_recommended_unit_of_measure']
            );
        !array_key_exists('minimum_manufacturer_age_recommended_value', $products) ?:
            $this->setMinimumManufacturerAgeRecommendedValue($products['minimum_manufacturer_age_recommended_value']);
        !array_key_exists('images', $products) ?: $this->setImages($products['images']);
        !array_key_exists('amount', $products) ?: $this->setAmount($products['amount']);
        !array_key_exists('price', $products) ?: $this->setPrice($products['price']);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            "id" => $this->getId(),
            "title" => $this->getTitle(),
            "text_id" => $this->getTextId(),
            "barcodes" => $this->getBarcodes(),
            "product_tax_code" => $this->getProductTaxCode(),
            "launch_date" => $this->getLaunchDate(),
            "release_date" => $this->getReleaseDate(),
            "brand" => $this->getBrand(),
            "description" => $this->getDescription(),
            "bullet_point" => $this->getBulletPoint(),
            "manufacturer" => $this->getManufacturer(),
            "item_type" => $this->getItemType(),
            "target_audience" => $this->getTargetAudience(),
            "product_data_main_category" => $this->getProductDataMainCategory(),
            "product_type_main_category" => $this->getProductTypeMainCategory(),
            "minimum_manufacturer_age_recommended_unit_of_measure" =>
                $this->getMinimumManufacturerAgeRecommendedUnitOfMeasure(),
            "minimum_manufacturer_age_recommended_value" => $this->getMinimumManufacturerAgeRecommendedValue(),
            "images" => $this->getImages(),
            "amount" => $this->getAmount(),
            "price" => $this->getPrice(),
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTextId(): string
    {
        return $this->textId;
    }

    /**
     * @param string $textId
     */
    public function setTextId(string $textId): void
    {
        $this->textId = $textId;
    }

    /**
     * @return array
     */
    public function getBarcodes(): array
    {
        return $this->barcodes;
    }

    /**
     * @param array $barcodes
     */
    public function setBarcodes(array $barcodes): void
    {
        $validBarcodes = [];
        $validator = Validation::createValidator();

        foreach ($barcodes as $barcode) {
            if (is_array($barcode) && array_key_exists('code', $barcode)) {
                $violations = $validator->validate($barcode['code'], [
                    new Ean()
                ]);
                if (!count($violations) ||
                    (array_key_exists('type', $barcode) && $barcode['type'] === self::EAN_13_BARCODE_TYPE)
                ) {
                    $validBarcodes[] = $barcode;
                }
            }
        }
        //$validBarcodes[] = ['code' => '8880000128483'];
        $this->barcodes = $validBarcodes;
    }

    /**
     * @return string
     */
    public function getProductTaxCode(): string
    {
        return $this->productTaxCode;
    }

    /**
     * @param string $productTaxCode
     */
    public function setProductTaxCode(string $productTaxCode): void
    {
        $this->productTaxCode = $productTaxCode;
    }

    /**
     * @return string
     */
    public function getLaunchDate(): string
    {
        return $this->launchDate;
    }

    /**
     * @param string $launchDate
     * @throws \Exception
     */
    public function setLaunchDate(string $launchDate): void
    {
        $date = new \DateTime($launchDate);
        $this->launchDate = $date->format('c');
    }

    /**
     * @return string
     */
    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    /**
     * @param string $releaseDate
     * @throws \Exception
     */
    public function setReleaseDate(string $releaseDate): void
    {
        $date = new \DateTime($releaseDate);
        $this->releaseDate = $date->format('c');
    }

    /**
     * @return string
     */
    public function getBrand(): string
    {
        return $this->brand;
    }

    /**
     * @param string $brand
     */
    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return strip_tags($this->description);
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = strip_tags($description);
    }

    /**
     * @return string
     */
    public function getBulletPoint(): string
    {
        return $this->bulletPoint;
    }

    /**
     * @param string $bulletPoint
     */
    public function setBulletPoint(string $bulletPoint): void
    {
        $this->bulletPoint = $bulletPoint;
    }

    /**
     * @return string
     */
    public function getManufacturer(): string
    {
        return $this->manufacturer;
    }

    /**
     * @param string $manufacturer
     */
    public function setManufacturer(string $manufacturer): void
    {
        $this->manufacturer = $manufacturer;
    }

    /**
     * @return string
     */
    public function getItemType(): string
    {
        return $this->itemType;
    }

    /**
     * @param string $itemType
     */
    public function setItemType(string $itemType): void
    {
        $this->itemType = $itemType;
    }

    /**
     * @return array
     */
    public function getTargetAudience(): array
    {
        return $this->targetAudience;
    }

    /**
     * @param array $targetAudience
     */
    public function setTargetAudience(array $targetAudience): void
    {
        $this->targetAudience = $targetAudience;
    }

    /**
     * @return string
     */
    public function getProductDataMainCategory(): string
    {
        return $this->productDataMainCategory;
    }

    /**
     * @param string $productDataMainCategory
     */
    public function setProductDataMainCategory(string $productDataMainCategory): void
    {
        $this->productDataMainCategory = $productDataMainCategory;
    }

    /**
     * @return string
     */
    public function getProductTypeMainCategory(): string
    {
        return $this->productTypeMainCategory;
    }

    /**
     * @param string $productTypeMainCategory
     */
    public function setProductTypeMainCategory(string $productTypeMainCategory): void
    {
        $this->productTypeMainCategory = $productTypeMainCategory;
    }

    /**
     * @return string|null
     */
    public function getMinimumManufacturerAgeRecommendedUnitOfMeasure(): ?string
    {
        return $this->minimumManufacturerAgeRecommendedUnitOfMeasure;
    }

    /**
     * @param string|null $minimumManufacturerAgeRecommendedUnitOfMeasure
     */
    public function setMinimumManufacturerAgeRecommendedUnitOfMeasure(?string $minimumManufacturerAgeRecommendedUnitOfMeasure): void
    {
        $this->minimumManufacturerAgeRecommendedUnitOfMeasure = $minimumManufacturerAgeRecommendedUnitOfMeasure;
    }

    /**
     * @return string|null
     */
    public function getMinimumManufacturerAgeRecommendedValue(): ?string
    {
        return $this->minimumManufacturerAgeRecommendedValue;
    }

    /**
     * @param string|null $minimumManufacturerAgeRecommendedValue
     */
    public function setMinimumManufacturerAgeRecommendedValue(?string $minimumManufacturerAgeRecommendedValue): void
    {
        $this->minimumManufacturerAgeRecommendedValue = $minimumManufacturerAgeRecommendedValue;
    }

    /**
     * @return array
     */
    public function getImages(): array
    {
        return [
            [
                'cdn' => 'http://skazkamartsvnbackup.s3-us-west-2.amazonaws.com/0.jpg',
                'place' => ProductImage::MAIN_PLACE
            ],
            [
                'cdn' => 'http://skazkamartsvnbackup.s3-us-west-2.amazonaws.com/1.jpg',
                'place' => ProductImage::PT1_PLACE
            ],
            [
                'cdn' => 'http://skazkamartsvnbackup.s3-us-west-2.amazonaws.com/2.jpg',
                'place' => ProductImage::PT2_PLACE
            ],
            [
                'cdn' => 'http://skazkamartsvnbackup.s3-us-west-2.amazonaws.com/3.jpg',
                'place' => ProductImage::PT3_PLACE
            ]
        ];

        return $this->images;
    }

    /**
     * @param array $images
     */
    public function setImages(array $images): void
    {
        /*usort($images, function ($a, $b) {
            return $a['place'] <=> $b['place'];
        });

        $filteredImages = [];

        for ($i = 0; $i <= count(ProductImage::PLACES); $i++) {
            if (array_key_exists($i, $images)) {
                $images[$i]['place'] = ProductImage::PLACES[$i];
                $filteredImages[] = $images[$i];
            }
        }

        $this->images = $filteredImages;*/
        $this->images = [
            [
                'cdn' => 'http://skazkamartsvnbackup.s3-us-west-2.amazonaws.com/0.jpg',
                'place' => ProductImage::MAIN_PLACE
            ],
            [
                'cdn' => 'http://skazkamartsvnbackup.s3-us-west-2.amazonaws.com/1.jpg',
                'place' => ProductImage::PT1_PLACE
            ],
            [
                'cdn' => 'http://skazkamartsvnbackup.s3-us-west-2.amazonaws.com/2.jpg',
                'place' => ProductImage::PT2_PLACE
            ],
            [
                'cdn' => 'http://skazkamartsvnbackup.s3-us-west-2.amazonaws.com/3.jpg',
                'place' => ProductImage::PT3_PLACE
            ]
        ];
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return array
     */
    public function getPrice(): array
    {
        return $this->price;
    }

    /**
     * @param array $price
     */
    public function setPrice(array $price): void
    {
        $this->price = $price;
    }


    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('id', [
            new NotNull(),
            new Type([
                'type' => 'integer',
                'message' => 'The value {{ value }} is not a valid {{ type }}. "Product entity error"',
            ])
        ]);
        $metadata->addPropertyConstraints('title', [
            new NotNull(),
            new Type([
                'type' => 'string',
                'message' => 'The value {{ value }} is not a valid {{ type }}. "Product entity error"',
            ])
        ]);
        $metadata->addPropertyConstraints('textId', [
            new NotNull(),
            new Type([
                'type' => 'string',
                'message' => 'The value {{ value }} is not a valid {{ type }}. "Product entity error"',
            ])
        ]);
        $metadata->addPropertyConstraints('barcodes', [
            new NotNull(),
            new Type([
                'type' => 'array',
                'message' => 'The value {{ value }} is not a valid {{ type }}. "Product entity error"',
            ]),
            new All([
                new Collection([
                    'type' => [
                        new Choice(['choices' => [self::EAN_13_BARCODE_TYPE, null]]),
                    ],
                    'code' => [
                        new Type([
                            'type' => 'string',
                            'message' => 'The value {{ value }} is not a valid {{ type }}. "Product entity error"',
                        ]),
                        new Ean(),
                    ]
                ])
            ]),
        ]);
        $metadata->addPropertyConstraints('productTaxCode', [
            new NotNull(),
            new Type([
                'type' => 'string',
                'message' => 'The value {{ value }} is not a valid {{ type }}. "Product entity error"',
            ]),
            new Choice(['choices' => [self::GEN_TAX, self::NO_TAX]])
        ]);
        $metadata->addPropertyConstraints('launchDate', [
            new NotNull(),
            new Type([
                'type' => 'string',
                'message' => 'The value {{ value }} is not a valid {{ type }}. "Product entity error"',
            ]),
            new DateTimeValidator(['format' => 'Y-m-d\TH:i:sO'])
        ]);
        $metadata->addPropertyConstraints('releaseDate', [
            new NotNull(),
            new Type([
                'type' => 'string',
                'message' => 'The value {{ value }} is not a valid {{ type }}. "Product entity error"',
            ]),
            new DateTimeValidator(['format' => 'Y-m-d\TH:i:sO'])
        ]);
    }
}
