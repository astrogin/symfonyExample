<?php

namespace App\MwsClients\Feed;

use App\MwsClients\Feed\Client\Client;
use App\Persistence\RequestHandler;
use App\MwsClients\Config\Defaults\Config;
use App\MwsClients\Config\Defaults\Credentials;
use App\MwsClients\Config\Defaults\Info;
use App\Persistence\Container as ContainerInterface;

class Container implements ContainerInterface
{
    const PREPARE_SUBMISSION_FEED_METHOD = 'prepareSubmissionFeed';
    const SUBMIT_FEED_METHOD = 'submitFeed';

    const PREPARE_FEED_SUBMISSION_LIST_METHOD = 'prepareFeedSubmissionList';
    const GET_FEED_SUBMISSION_LIST_METHOD = 'getFeedSubmissionList';

    const PREPARE_FEED_SUBMISSION_RESULT_METHOD = 'prepareFeedSubmissionResult';
    const GET_FEED_SUBMISSION_RESULT_METHOD = 'getFeedSubmissionResult';
    /**
     * @var Client
     */
    private $client;
    /**
     * @var Info
     */
    private $info;
    /**
     * @var Credentials
     */
    private $credentials;
    /**
     * @var Config
     */
    private $config;
    /**
     * @var RequestHandler
     */
    private $handler;

    /**
     * Container constructor.
     * @param Credentials $credentials
     * @param Info $info
     * @param Config $config
     * @param RequestHandler $feedHandler
     */
    public function __construct(Credentials $credentials, Info $info, Config $config, RequestHandler $feedHandler)
    {
        $this->credentials = $credentials;
        $this->info = $info;
        $this->config = $config;
        $this->handler = $feedHandler;
    }

    /**
     *
     */
    public function initClient()
    {
        $this->client = new Client(
            $this->credentials->getKey(),
            $this->credentials->getSecret(),
            $this->config->toArray(),
            $this->info->getAppName(),
            $this->info->getAppVersion()
        );

        return $this;
    }

    /**
     * @param Config $config
     */
    public function setConfig(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param Info $info
     */
    public function setInfo(Info $info)
    {
        $this->info = $info;
    }

    /**
     * @param Credentials $credentials
     */
    public function setCredentials(Credentials $credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * @param string $shop
     * @return $this
     * @throws \App\Exceptions\ShopNotFound
     */
    public function setShop(string $shop)
    {
        $this->config->setShop($shop);

        return $this;
    }

    /**
     * @return RequestHandler
     */
    public function getHandler(): RequestHandler
    {
        return $this->handler;
    }

    /**
     * @param RequestHandler $handler
     */
    public function setHandler(RequestHandler $handler)
    {
        $this->handler = $handler;
    }

    public function prepare(string $method, $data = [])
    {
        return $this->handler->handle($method, $data);
    }

    public function send(string $method, $data = [])
    {
        if (!$this->client) {
            $this->initClient();
        }

        return $this->handler->handle($method, [
            'merchant' => $this->credentials->getMerchant(),
            'client' => $this->client,
            'request' => $data
        ]);
    }
}
