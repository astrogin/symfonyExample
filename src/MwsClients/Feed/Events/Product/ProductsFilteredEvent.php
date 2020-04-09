<?php

namespace App\MwsClients\Feed\Events\Product;

use App\MwsClients\Feed\Filters\Base;
use Symfony\Contracts\EventDispatcher\Event;

class ProductsFilteredEvent extends Event
{
    public const NAME = 'feed.products.filtered.event';

    /**
     * @var Base
     */
    protected $filter;

    /**
     * ProductsFilteredEvent constructor.
     * @param Base $filter
     */
    public function __construct(Base $filter)
    {
        $this->filter = $filter;
    }

    /**
     * @return Base
     */
    public function getFilter()
    {
        return $this->filter;
    }
}