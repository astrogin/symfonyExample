<?php

namespace App\MwsClients\Feed\Handlers;

use App\Exceptions\MethodNotSupported;
use App\MwsClients\Feed\Client\Client;
use App\MwsClients\Feed\Schemes\SubmissionFeedList\SubmissionFeedList;
use App\MwsClients\Feed\Schemes\SubmissionFeedResult\SubmissionFeedResult;
use App\MwsClients\Feed\Schemes\SubmitFeedBase;
use App\MwsClients\Feed\Types\IdList;
use App\MwsClients\Feed\Types\SubmissionList\Request as SubmissionListRequest;
use App\MwsClients\Feed\Types\SubmissionResult\Request as SubmissionResultRequest;
use App\MwsClients\Feed\Types\SubmitFeed\Request as SubmitFeedRequest;
use App\Persistence\RequestHandler;

/**
 * Class FeedHandler
 * @package App\MwsClients\Feed
 */
class FeedHandler implements RequestHandler
{
    /**
     * @param string $method
     * @param array $params
     * @return mixed
     * @throws MethodNotSupported
     */
    public function handle(string $method, $params = [])
    {
        if (method_exists($this, $method)) {
            return $this->{$method}($params);
        }

        throw new MethodNotSupported();
    }

    private function prepareSubmissionFeed(SubmitFeedBase $feed)
    {
        $feedHandle = @fopen('php://memory', 'rw+');
        fwrite($feedHandle, $feed->getFeedContent());
        rewind($feedHandle);
        $request = new SubmitFeedRequest($feed->toArray());
        $request->setFeedContent($feedHandle);
        rewind($feedHandle);
        $request->setContentMd5(base64_encode(md5(stream_get_contents($feedHandle), true)));
        $request->setMerchant($feed->getMerchant());
        $request->setMarketplaceIdList(['Id' => $feed->getMarketplaceIdList()]);
        $request->setFeedType($feed->getFeedType());
        return $request;
    }

    private function submitFeed($params)
    {
        /**
         * @var $client Client
         */
        $client = $params['client'];

        return $client->submitFeed($params['request']);
    }

    private function prepareFeedSubmissionList(SubmissionFeedList $feedList)
    {
        $request = new SubmissionListRequest();
        $request->setMerchant($feedList->getMerchant());

        if ($feedList->getIdList() instanceof IdList) {
            $request->setFeedSubmissionIdList($feedList->getIdList());
        }

        return $request;
    }

    private function getFeedSubmissionList($params)
    {
        /**
         * @var $client Client
         */
        $client = $params['client'];

        return $client->getFeedSubmissionList($params['request']);
    }

    private function prepareFeedSubmissionResult(SubmissionFeedResult $submissionFeedResult)
    {
        $request = new SubmissionResultRequest();
        $request->setMerchant($submissionFeedResult->getMerchant());
        $request->setFeedSubmissionId($submissionFeedResult->getSubmissionFeedId());
        $request->setFeedSubmissionResult($submissionFeedResult->getResource());

        return $request;
    }

    private function getFeedSubmissionResult($data)
    {
        /**
         * @var $client Client
         */
        $client = $data['client'];

        return $client->getFeedSubmissionResult($data['request']);
    }
}
