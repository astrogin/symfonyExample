<?php

namespace App\Listeners\Feed;

use App\Doctrine\Entity\Main\Feed;
use App\Doctrine\Entity\Main\Products\ProductInventory;
use App\MwsClients\Feed\Schemes\Submit\ProductInventory as ProductInventoryScheme;
use App\MwsClients\Feed\Schemes\Submit\Base;
use App\MwsClients\Feed\Schemes\Submit\ProductPriceFeed;
use App\Services\FileSystem\FileSystem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\EventDispatcher\Event;

class CreateProductPriceFeed
{
    private $fileSystem;
    private $container;
    private $em;

    public function __construct(
        FileSystem $fileSystem,
        ContainerInterface $container,
        EntityManagerInterface $entityManager
    )
    {
        $this->fileSystem = $fileSystem;
        $this->container = $container;
        $this->em = $entityManager;
    }

    /**
     * @param Event $event
     * @throws \Exception
     */
    public function __invoke(Event $event)
    {
        /**
         * @var $products \App\Doctrine\Entity\Main\Products\Product[]|\Doctrine\Common\Collections\Collection
         */
        $products = $event->getProducts();
        $feedPrices = [];
        $dateTime = new \DateTime();
        $em = $this->em;
        if (count($products)) {
            $feed = new Feed();
            $feed->setStatus(Feed::NEW_STATUS);
            $feed->setCreatedAt($dateTime);
            $feed->setUpdatedAt($dateTime);
            $feed->setType(Feed::POST_PRODUCT_PRICING_TYPE);
            $em->persist($feed);

            foreach ($products as $product) {
                /**
                 * @var $inventory ProductInventory
                 */
                $price = $product->getProductPrice();
                $code = strtoupper($price->getCurrency()->getCode());
                $feedPrices[] = new ProductPriceFeed($code, $price->getAmount(), $product->getSku());
                $price->addFeed($feed);
                $em->persist($price);
            }

            $feedType = new Base();
            $feedType->castFromArray([
                'messageType' => Base::PRODUCT_PRICE_MESSAGE_TYPE,
                'merchant' => $this->container->getParameter('env.merchant'),
                'messages' => $feedPrices
            ]);

            $feed->setPath($this->fileSystem->saveXml($feedType->toXml()));

            $em->flush();
        }
    }
}
