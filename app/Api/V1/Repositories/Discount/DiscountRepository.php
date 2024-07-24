<?php

namespace App\Api\V1\Repositories\Discount;
use App\Admin\Repositories\Discount\DiscountRepository as AdminCategoryRepository;
use App\Models\Product;

class DiscountRepository extends AdminCategoryRepository implements DiscountRepositoryInterface
{

    public function getByProduct(Product $product, $page = 1, $limit = 10)
    {

    }
}
