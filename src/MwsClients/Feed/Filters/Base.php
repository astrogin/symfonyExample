<?php

namespace App\MwsClients\Feed\Filters;

use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class Base
{
    protected $container;
    protected $valid = [];
    protected $invalid = [];

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return array
     */
    public function getValid(): array
    {
        return $this->valid;
    }

    /**
     * @return array
     */
    public function getInvalid(): array
    {
        return $this->invalid;
    }
}