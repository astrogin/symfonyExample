<?php

namespace App\MwsClients\Feed\Events\Product;

use App\Doctrine\Entity\Main\Feed;
use App\MwsClients\Feed\Filters\Base;
use Symfony\Contracts\EventDispatcher\Event;

class ProductFeedSentEvent extends Event
{
    public const NAME = 'feed.products.sent.event';

    private $response;
    private $feed;

    /**
     * ProductFeedSentEvent constructor.
     * @param $response
     * @param Feed $feed
     */
    public function __construct($response, Feed $feed)
    {
        $this->response = $response;
        $this->feed = $feed;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }
    /**
     * @return Feed
     */
    public function getFeed(): Feed
    {
        return $this->feed;
    }
}
