<?php

namespace App\MwsClients\Feed\Schemes\SubmissionFeedList;

use App\MwsClients\Feed\Types\IdList;

class SubmissionFeedList
{
    /**
     * @var string
     */
    private $merchant;
    /**
     * @var array
     */
    private $idList = [];

    /**
     * SubmissionFeedList constructor.
     * @param string $merchant
     * @param array $idList
     * @throws \Exception
     */
    public function __construct(string $merchant, array $idList = [])
    {
        $this->setMerchant($merchant);
        $this->setIdList($idList);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function toArray()
    {
        $response = [
            'Merchant' => $this->getMerchant()
        ];

        if ($this->getIdList() instanceof IdList) {
            $response['FeedSubmissionIdList'] = $this->getIdList();
        }

        return $response;
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
     * @return mixed
     */
    public function getIdList()
    {
        return $this->idList;
    }

    /**
     * @param array $idList
     * @throws \Exception
     */
    public function setIdList(array $idList): void
    {
        $list = new IdList();
        $list->setId($idList);
        $this->idList = $list;
    }
}
