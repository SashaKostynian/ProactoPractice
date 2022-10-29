<?php

namespace Practice\PracticePatterns\Api;

interface ProductPriceInterface
{
    /**
     * @api
     * @param int $productId
     * @return string
     */
    public function getProductPrice(int $productId): string;
}
