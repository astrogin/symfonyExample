<?php

namespace App\Command;

use App\Doctrine\Entity\Main\Feed;
use App\Doctrine\Entity\Main\Products\Product;
use App\MwsClients\Feed\Events\Product\ProductFeedCreatedEvent;
use App\MwsClients\Feed\Schemes\Submit\Base;
use App\MwsClients\Feed\Schemes\Submit\ProductFeed;
use App\Services\FileSystem\FileSystem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class MWSUploadProductsFeed extends Command
{
    protected static $defaultName = 'app:mws-upload-products-feed';

    private $entityManager;
    private $container;
    private $fileSystem;
    private $dispatcher;

    /**
     * MWSUploadProducts constructor.
     * @param EntityManagerInterface $entityManager
     * @param ContainerInterface $container
     * @param FileSystem $fileSystem
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ContainerInterface $container,
        FileSystem $fileSystem,
        EventDispatcherInterface $dispatcher
    )
    {
        $this->entityManager = $entityManager;
        $this->container = $container;
        $this->fileSystem = $fileSystem;
        $this->dispatcher = $dispatcher;
        parent::__construct();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->entityManager;
        $dateTime = new \DateTime();
        $products = $em->getRepository(Product::class)
            ->findBy(['status' => Product::NEW_STATUS], ['id' => 'ASC'], 100);
        $productFeeds = [];

        if (count($products)) {
            $feed = new Feed();
            $feed->setStatus(Feed::NEW_STATUS);
            $feed->setCreatedAt($dateTime);
            $feed->setUpdatedAt($dateTime);
            $feed->setType(Feed::POST_PRODUCT_TYPE);
            $em->persist($feed);

            foreach ($products as $product) {
                $product->addFeed($feed);
                $productFeeds[] = new ProductFeed($product);
            }

            $feedType = new Base();
            $feedType->castFromArray([
                'messageType' => Base::PRODUCT_MESSAGE_TYPE,
                'merchant' => $this->container->getParameter('env.merchant'),
                'messages' => $productFeeds
            ]);

            $feed->setPath($this->fileSystem->saveXml($feedType->toXml()));

            $em->flush();

            $this->dispatcher->dispatch(new ProductFeedCreatedEvent($feed), ProductFeedCreatedEvent::NAME);

        }

        return 1;
    }
}