<?php

namespace Practice\PracticePatterns\Api;


interface ProductNameInterface
{
    /**
     * @api
     * @param int $productId
     * @return string
     */
    public function getProductName(int $productId): string;

//    /**
//     * @api
//     * @return string
//     */
//    public function getProductName(): string;
}
