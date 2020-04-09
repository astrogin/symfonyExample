<?php

namespace App\Persistence;

interface Container
{
    /**
     * @param string $method
     * @return mixed
     */
    public function send(string $method);
}