<?php

namespace App\MwsClients\Feed\Schemes;

class SubmitFeedBase
{
    /**
     * @var string
     */
    private $feedContent;
    /**
     * @var string
     */
    private $merchant;
    /**
     * @var array
     */
    private $marketplaceIdList;
    /**
     * @var string
     */
    private $feedType;

    /**
     * SubmitFeedBase constructor.
     * @param string $feedContent
     * @param string $merchant
     * @param array $marketplaceIdList
     * @param string $feedType
     */
    public function __construct(string $feedContent, string $merchant, array $marketplaceIdList, string $feedType)
    {
        $this->setFeedContent($feedContent);
        $this->setMerchant($merchant);
        $this->setMarketplaceIdList($marketplaceIdList);
        $this->setFeedType($feedType);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'merchant' => $this->getMerchant(),
            'marketplaceIdList' => $this->getMarketplaceIdList(),
            'feedType' => $this->getFeedType(),
            'feedContent' => $this->getFeedContent()
        ];
    }

    /**
     * @return string
     */
    public function getFeedContent(): string
    {
        return $this->feedContent;
    }

    /**
     * @param string $feedContent
     */
    public function setFeedContent(string $feedContent): void
    {
        $this->feedContent = $feedContent;
    }

    /**
     * @return string
     */
    public function getMerchant(): string
    {
        return $this->merchant;
    }

    /**
     * @param string $merchant
     */
    public function setMerchant(string $merchant): void
    {
        $this->merchant = $merchant;
    }

    /**
     * @return array
     */
    public function getMarketplaceIdList(): array
    {
        return $this->marketplaceIdList;
    }

    /**
     * @param array $marketplaceIdList
     */
    public function setMarketplaceIdList(array $marketplaceIdList): void
    {
        $this->marketplaceIdList = $marketplaceIdList;
    }

    /**
     * @return string
     */
    public function getFeedType(): string
    {
        return $this->feedType;
    }

    /**
     * @param string $feedType
     */
    public function setFeedType(string $feedType): void
    {
        $this->feedType = $feedType;
    }
}