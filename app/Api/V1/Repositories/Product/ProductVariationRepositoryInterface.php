<?php

namespace App\Api\V1\Repositories\Product;

interface ProductVariationRepositoryInterface
{
    public function findByProductAndAttributeVariation($product_id, array $variation_id = []);
	
}