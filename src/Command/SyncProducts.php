<?php

namespace App\Command;

use App\Doctrine\Entity\Main\Currency;
use App\Doctrine\Entity\Main\Products\ProductImage;
use App\Doctrine\Entity\Main\Products\ProductInventory;
use App\Doctrine\Entity\Main\Products\ProductPrice;
use App\MwsClients\Feed\Filters\Product\CreateProductFilter;
use App\Services\Products\ProductService;
use App\Services\Skazka\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Doctrine\Entity\Main\Products\Product as EntityProduct;

class SyncProducts extends Command
{
    protected static $defaultName = 'app:sync-products';

    private $productService;
    private $createProductFilter;
    private $entityManager;

    public function __construct(
        ProductService $productService,
        CreateProductFilter $createProductFilter,
        EntityManagerInterface $entityManager
    )
    {

        $this->productService = $productService;
        $this->createProductFilter = $createProductFilter;
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $products = $this->createProductFilter->filter($this->productService->getProducts())->getValid();
        $dateTime = new \DateTime();
        $entityManager = $this->entityManager;
        $currency = $existedProducts = $entityManager->getRepository(Currency::class)
            ->findOneBy(['code' => Currency::USD_CODE]);

        foreach ($products as $validProduct) {

            /**
             * @var $validProduct Product
             */
            $textId = $validProduct->getTextId();
            $barcode = $this->getBarcode($validProduct);
            $newProduct = new EntityProduct();
            $newProduct->setUpdatedAt($dateTime);
            $newProduct->setCreatedAt($dateTime);
            $newProduct->setExternalId($validProduct->getId());
            $newProduct->setStatus(EntityProduct::NEW_STATUS);
            $newProduct->setTextId($textId);
            $newProduct->setSku($textId);
            $newProduct->setBulletPoint($validProduct->getBulletPoint());
            $newProduct->setTargetAudience($validProduct->getTargetAudience());
            $newProduct->setReleaseDate(new \DateTime($validProduct->getReleaseDate()));
            $newProduct->setLaunchDate(new \DateTime($validProduct->getLaunchDate()));
            $newProduct->setProductTaxCode($validProduct->getProductTaxCode());
            $newProduct->setItemType($validProduct->getItemType());
            $newProduct->setProductTypeMainCategory($validProduct->getProductTypeMainCategory());
            $newProduct->setProductDataMainCategory($validProduct->getProductDataMainCategory());
            $newProduct->setMinimumManufacturerAgeRecommendedUnitOfMeasure(
                $validProduct->getMinimumManufacturerAgeRecommendedUnitOfMeasure()
            );
            $newProduct->setMinimumManufacturerAgeRecommendedValue(
                $validProduct->getMinimumManufacturerAgeRecommendedValue()
            );
            $newProduct->setTitle($validProduct->getTitle());
            $newProduct->setDescription($validProduct->getDescription());
            $newProduct->setBrand($validProduct->getBrand());
            $newProduct->setBarcodeType($barcode['type'] ?? EntityProduct::EAN_BARCODE_TYPE);
            $newProduct->setBarcode($barcode['code']);
            $newProduct->setManufacturer($validProduct->getManufacturer());


            $price = new ProductPrice();
            $price->setUpdatedAt($dateTime);
            $price->setCreatedAt($dateTime);
            $price->setCurrency($currency);
            $price->setAmount($validProduct->getPrice()['price']);
            $price->setProduct($newProduct);

            foreach ($validProduct->getImages() as $image) {

                $newImage = new ProductImage();
                $newImage->setUpdatedAt($dateTime);
                $newImage->setCreatedAt($dateTime);
                $newImage->setPath($image['cdn']);
                $newImage->setPlace($image['place']);
                $newImage->setProduct($newProduct);

                $entityManager->persist($newImage);
            }

            $inventory = new ProductInventory();
            $inventory->setUpdatedAt($dateTime);
            $inventory->setCreatedAt($dateTime);
            $inventory->setQuantity($validProduct->getAmount());
            $inventory->setProduct($newProduct);

            $entityManager->persist($newProduct);
            $entityManager->persist($price);
            $entityManager->persist($inventory);
        }

        $entityManager->flush();

        $output->write([
            'First command symfony'
        ]);

        return 0;
    }

    /**
     * @param $product
     * @return mixed
     * @todo will delete in future realization
     */
    private function getBarcode($product)
    {
        $barcodes = $product->getBarcodes();

        foreach ($barcodes as $barcode) {
            if ($barcode['type'] === EntityProduct::EAN_13_BARCODE_TYPE) {
                $barcode['type'] = EntityProduct::EAN_BARCODE_TYPE;
                return $barcode;
            }
        }

        foreach ($barcodes as $barcode) {
            if (strpos($barcode['code'], '46') !== false) {

                return $barcode;
            }
        }

        $barcode = reset($barcodes);

        return $barcode;
    }
}
