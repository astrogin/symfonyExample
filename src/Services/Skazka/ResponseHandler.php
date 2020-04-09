<?php

namespace App\Services\Skazka;

use App\Services\Skazka\Entity\Product;

class ResponseHandler
{
    /**
     * @param $products
     * @return array
     */
    public function handleProductResponse($products)
    {
        $response = [];

        if (is_array($products)) {

            foreach ($products as $product) {
                $response[] = new Product($product);
            }

            return $response;
        }

        return $response;
    }
}
