<?php

namespace App\Services\Image;

use App\Services\Image\Types\Filter as FilterType;
use App\Services\Image\Handlers\Filter as FilterHandler;

class ImageService
{

    private $filter;

    /**
     * ImageService constructor.
     * @param FilterHandler $filter
     */
    public function __construct(FilterHandler $filter)
    {
        $this->filter = $filter;
    }

    public function filter(FilterType $filterType)
    {
        return $this->filter->handle($filterType);
    }
}