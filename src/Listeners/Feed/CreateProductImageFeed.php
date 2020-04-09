<?php

namespace App\Listeners\Feed;

use App\Doctrine\Entity\Main\Feed;
use App\Doctrine\Entity\Main\Products\ProductImage;
use App\MwsClients\Feed\Schemes\Submit\Base;
use App\MwsClients\Feed\Schemes\Submit\ProductImageFeed;
use App\Services\FileSystem\FileSystem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\EventDispatcher\Event;

class CreateProductImageFeed
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
        $feedImages = [];
        $dateTime = new \DateTime();
        $em = $this->em;
        if (count($products)) {
            $feed = new Feed();
            $feed->setStatus(Feed::NEW_STATUS);
            $feed->setCreatedAt($dateTime);
            $feed->setUpdatedAt($dateTime);
            $feed->setType(Feed::POST_PRODUCT_IMAGE_TYPE);
            $em->persist($feed);

            foreach ($products as $product) {
                $images = $product->getProductImages();
                /**
                 * @var $image ProductImage
                 */
                foreach ($images as $image) {
                    $image->addFeed($feed);
                    $em->persist($image);
                    $feedImages[] = new ProductImageFeed($image->getPath(), $image->getPlace(), $product->getSku());
                }
            }

            $feedType = new Base();
            $feedType->castFromArray([
                'messageType' => Base::PRODUCT_IMAGE_MESSAGE_TYPE,
                'merchant' => $this->container->getParameter('env.merchant'),
                'messages' => $feedImages
            ]);

            $feed->setPath($this->fileSystem->saveXml($feedType->toXml()));

            $em->flush();
        }
    }
}
