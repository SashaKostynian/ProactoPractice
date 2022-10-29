<?php

declare(strict_types=1);

namespace Practice\PracticePatterns\Model;

use Practice\PracticePatterns\Api\ProductNameInterface;
use Practice\PracticePatterns\Api\ProductPriceInterface;

class ProductProperties implements ProductPriceInterface, ProductNameInterface
{


//    public function __construct(
//
//    ) {
//
//    }

    /**
     * @api
     * @param int $productId
     * @return string
     */
    public function getProductName(int $productId): string
    {

//        return $productName;
        return 'Josera product name';
    }

//    /**
//     * @api
//     * @return string
//     */
//    public function getProductName(): string
//    {
//
////        return $productName;
//        return 'Josera product name';
//    }

    /**
     * @api
     * @param int $productId
     * @return string
     */
    public function getProductPrice(int $productId): string
    {

//        return $productPrice;
        return 'Josera product price 444';
    }
}
