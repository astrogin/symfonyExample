<?php

namespace App\Services\Image\Handlers;

use App\Services\Image\Types\Filter as FilterType;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Liip\ImagineBundle\Imagine\Data\DataManager;
use Liip\ImagineBundle\Imagine\Filter\FilterManager;

class Filter
{
    private $cacheManager;
    private $dataManager;
    private $filterManager;

    public function __construct(CacheManager $cacheManager, DataManager $dataManager, FilterManager $filterManager)
    {

        $this->cacheManager = $cacheManager;
        $this->dataManager = $dataManager;
        $this->filterManager = $filterManager;
    }

    public function handle(FilterType $filter)
    {
        switch ($filter->getName()) {
            case 'mws':
                return $this->filterImgForMWS($filter);

        }
    }

    /**
     * @param FilterType $filter
     * @return \Liip\ImagineBundle\Binary\BinaryInterface
     */
    private function filterImgForMWS(FilterType $filter)
    {
        $binary = $this->dataManager->find($filter->getName(), $filter->getPath());

        $filteredBinary = $this->filterManager->applyFilter($binary, $filter->getName());

        $this->cacheManager->store($filteredBinary, 'image12.jpg', $filter->getName());

        return $filteredBinary;
    }
}
