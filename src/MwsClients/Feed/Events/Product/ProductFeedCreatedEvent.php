<?php

namespace App\MwsClients\Feed\Events\Product;

use App\Doctrine\Entity\Main\Feed;
use Symfony\Contracts\EventDispatcher\Event;

class ProductFeedCreatedEvent extends Event
{
    public const NAME = 'feed.products.created.event';

    protected $feed;

    /**
     * ProductFeedCreatedEvent constructor.
     * @param Feed $feed
     */
    public function __construct(Feed $feed)
    {
        $this->feed = $feed;
    }

    /**
     * @return Feed
     */
    public function getFeed(): Feed
    {
        return $this->feed;
    }
}