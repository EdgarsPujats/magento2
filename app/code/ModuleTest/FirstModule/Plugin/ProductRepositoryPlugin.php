<?php

declare(strict_types=1);

namespace ModuleTest\FirstModule\Plugin;

use Magento\Catalog\Api\ProductRepositoryInterface;

class ProductRepositoryPlugin
{

    // can change arguments
    public function beforeGet(ProductRepositoryInterface $subject, $sku): string
    {
        return 'WJ01-S-Red';
    }

//    public function afterGet(){} here can change the result

//    public function aroundGet(){} here can add logic and call existing methods and make any changes
}
