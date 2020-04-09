<?php

namespace App\MwsClients\Config\Defaults;

use App\Exceptions\ShopNotFound;

/**
 * Class Config
 */
class Config
{
    const HTTPS = 'https://';
    const MWS_SERVICE_DOMAIN = 'mws.amazonservices';
    const DOT_SEPARATOR = '.';

    const US_DOMAIN_ZONE = 'com';
    const UK_DOMAIN_ZONE = 'co.uk';
    const DE_DOMAIN_ZONE = 'de';
    const FR_DOMAIN_ZONE = 'fr';
    const IT_DOMAIN_ZONE = 'it';
    const JP_DOMAIN_ZONE = 'jp';
    const CN_DOMAIN_ZONE = 'cn';
    const CA_DOMAIN_ZONE = 'ca';
    const IN_DOMAIN_ZONE = 'in';

    const US_ULR_SHOP = self::HTTPS . self::MWS_SERVICE_DOMAIN . self::DOT_SEPARATOR . self::US_DOMAIN_ZONE;
    const UK_URL_SHOP = self::HTTPS . self::MWS_SERVICE_DOMAIN . self::DOT_SEPARATOR . self::UK_DOMAIN_ZONE;
    const DE_URL_SHOP = self::HTTPS . self::MWS_SERVICE_DOMAIN . self::DOT_SEPARATOR . self::DE_DOMAIN_ZONE;
    const FR_URL_SHOP = self::HTTPS . self::MWS_SERVICE_DOMAIN . self::DOT_SEPARATOR . self::FR_DOMAIN_ZONE;
    const IT_URL_SHOP = self::HTTPS . self::MWS_SERVICE_DOMAIN . self::DOT_SEPARATOR . self::IT_DOMAIN_ZONE;
    const JP_URL_SHOP = self::HTTPS . self::MWS_SERVICE_DOMAIN . self::DOT_SEPARATOR . self::JP_DOMAIN_ZONE;
    const CN_URL_SHOP = self::HTTPS . self::MWS_SERVICE_DOMAIN . self::DOT_SEPARATOR . self::CN_DOMAIN_ZONE;
    const CA_URL_SHOP = self::HTTPS . self::MWS_SERVICE_DOMAIN . self::DOT_SEPARATOR . self::CA_DOMAIN_ZONE;
    const IN_URL_SHOP = self::HTTPS . self::MWS_SERVICE_DOMAIN . self::DOT_SEPARATOR . self::IN_DOMAIN_ZONE;

    /**
     * @const array
     */
    const SHOPS = [
        'us' => self::US_ULR_SHOP,
        'uk' => self::UK_URL_SHOP,
        'de' => self::DE_URL_SHOP,
        'fr' => self::FR_URL_SHOP,
        'it' => self::IT_URL_SHOP,
        'jp' => self::JP_URL_SHOP,
        'cn' => self::CN_URL_SHOP,
        'ca' => self::CA_URL_SHOP,
        'in' => self::IN_URL_SHOP
    ];

    /**
     * @var string
     */
    private $url = self::US_ULR_SHOP;
    /**
     * @var string|null
     */
    private $proxyHost = null;
    /**
     * @var int
     */
    private $proxyPort = -1;
    /**
     * @var int
     */
    private $maxErrorRetry = 3;

    /**
     * @return null|string
     */
    public function getProxyHost()
    {
        return $this->proxyHost;
    }

    /**
     * @param null|string $proxyHost
     */
    public function setProxyHost($proxyHost)
    {
        $this->proxyHost = $proxyHost;
    }

    /**
     * @return int
     */
    public function getProxyPort(): int
    {
        return $this->proxyPort;
    }

    /**
     * @param int $proxyPort
     */
    public function setProxyPort(int $proxyPort)
    {
        $this->proxyPort = $proxyPort;
    }

    /**
     * @return int
     */
    public function getMaxErrorRetry(): int
    {
        return $this->maxErrorRetry;
    }

    /**
     * @param int $maxErrorRetry
     */
    public function setMaxErrorRetry(int $maxErrorRetry)
    {
        $this->maxErrorRetry = $maxErrorRetry;
    }

    /**
     * @param string $shop
     * @throws ShopNotFound
     */
    public function setShop(string $shop)
    {
        if (array_key_exists($shop, self::SHOPS)) {
            $this->url = self::SHOPS[$shop];
        }

        throw new ShopNotFound();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'ServiceURL' => $this->url,
            'ProxyHost' => $this->getProxyHost(),
            'ProxyPort' => $this->getProxyPort(),
            'MaxErrorRetry' => 3,
        ];
    }
}