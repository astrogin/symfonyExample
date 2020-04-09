<?php

namespace App\Persistence;

interface RequestHandler
{
    /**
     * @param string $method
     * @param array $params
     * @return mixed
     */
    public function handle(string $method, $params = []);
}
