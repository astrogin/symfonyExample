<?php

namespace App\MwsClients\Feed\Events\Product;

use App\Doctrine\Entity\Main\Feed;
use App\MwsClients\Feed\Filters\Base;
use Symfony\Contracts\EventDispatcher\Event;

class ProductFeedSuccessEvent extends Event
{
    public const NAME = 'feed.product.success.event';

    /**
     * @var Base
     */
    protected $feed;

    /**
     * ProductsFilteredEvent constructor.
     * @param Feed $feed
     */
    public function __construct(Feed $feed)
    {
        $this->feed = $feed;
    }

    /**
     * @return Feed
     */
    public function getFeed()
    {
        return $this->feed;
    }

    /**
     * @return \App\Doctrine\Entity\Main\Products\Product[]|\Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->feed->getProduct();
    }
}
