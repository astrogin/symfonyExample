<?php

namespace App\MwsClients\Feed\Filters\Product;

use App\Doctrine\Entity\Main\Products\Product as EntityProduct;
use App\MwsClients\Feed\Events\Product\ProductsFilteredEvent;
use App\MwsClients\Feed\Filters\Base;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Services\Skazka\Entity\Product as SkazkaProduct;

class CreateProductFilter extends Base
{
    /**
     * @param array $products
     * @return $this
     */
    public function filter(array $products)
    {
        /**
         * @var $product SkazkaProduct
         * @var $dispatcher EventDispatcherInterface
         */
        $dispatcher = $this->container->get('event_dispatcher');
        $validator = $this->container->get('validator');
        $entityManager = $this->container->get('doctrine.orm.default_entity_manager');
        $newProductsIds = [];

        foreach ($products as $product) {
            $newProductsIds[] = $product->getTextId();
        }

        $existedProductsIds = $entityManager->getRepository(EntityProduct::class)
            ->findDuplicatesByTextId($newProductsIds);

        foreach ($products as $product) {
            if (in_array($product->getTextId(), $existedProductsIds)) {
                $this->invalid['exists'][] = $product;
                continue;
            }
            $errors = $validator->validate($product);
            if (count($errors)) {
                $this->invalid['validation'][] = [
                    'product' => $product,
                    'error' => (string)$errors
                ];
                continue;
            }

            $this->valid[] = $product;
        }

        $dispatcher->dispatch(new ProductsFilteredEvent($this), ProductsFilteredEvent::NAME);

        return $this;
    }
}