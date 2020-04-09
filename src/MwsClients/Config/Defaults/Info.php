<?php

namespace App\MwsClients\Config\Defaults;

/**
 * Class Info
 */
class Info
{
    /**
     * @var string
     */
    private $appName;
    /**
     * @var string;
     */
    private $appVersion;

    /**
     * Info constructor.
     * @param string $appName
     * @param string $appVersion
     */
    public function __construct(string $appName, string $appVersion)
    {
        $this->appName = $appName;
        $this->appVersion = $appVersion;
    }

    /**
     * @return string
     */
    public function getAppName(): string
    {
        return $this->appName;
    }

    /**
     * @return string
     */
    public function getAppVersion(): string
    {
        return $this->appVersion;
    }
}
