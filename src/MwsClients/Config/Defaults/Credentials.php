<?php

namespace App\MwsClients\Config\Defaults;

/**
 * Class Credentials
 */
class Credentials
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $secret;

    /**
     * @var string
     */
    private $merchant;

    /**
     * Credentials constructor.
     * @param string $key
     * @param string $secret
     * @param string $merchant
     */
    public function __construct(string $key, string $secret, string $merchant)
    {
        $this->key = $key;
        $this->secret = $secret;
        $this->merchant = $merchant;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getSecret(): string
    {
        return $this->secret;
    }

    /**
     * @return string
     */
    public function getMerchant(): string
    {
        return $this->merchant;
    }

}
