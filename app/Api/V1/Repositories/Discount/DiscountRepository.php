<?php

namespace App\Api\V1\Repositories\Discount;
use App\Admin\Repositories\Discount\DiscountRepository as AdminCategoryRepository;
use App\Models\Product;
use App\Models\Discount;
class DiscountRepository extends AdminCategoryRepository implements DiscountRepositoryInterface
{
    public function getByProduct(Product $product, $page = 1, $limit = 10)
    {

    }
    public function getModel(): string
    {
        return Discount::class;
    }
    
    public function findByID($id)
    {
        $this->instance = $this->model->where('id', $id)
        ->firstOrFail();
        
        if ($this->instance && $this->instance->exists()) {
            return $this->instance;
        }

        return null;
    }

    public function getDiscountsByStoreId($storeId)
    {
        $discounts = $this->model
            ->join('discount_applications', 'discounts.id', '=', 'discount_applications.discount_code_id')
            ->where('discount_applications.store_id', $storeId)
            ->select('discounts.*')
            ->get();
        
        return $discounts;
    }

    public function getDiscountsByUserId($userId)
    {
        $discounts = $this->model
            ->join('discount_applications', 'discounts.id', '=', 'discount_applications.discount_code_id')
            ->where('discount_applications.user_id', $userId)
            ->select('discounts.*')
            ->get();
        
        return $discounts;
    }
    public function getDiscountsByDriverId($driverId)
    {
        $discounts = $this->model
            ->join('discount_applications', 'discounts.id', '=', 'discount_applications.discount_code_id')
            ->where('discount_applications.driver_id', $driverId)
            ->select('discounts.*')
            ->get();
        
        return $discounts;
    }

    public function getDiscountsByProductId($productId, $page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;
        $discounts = $this->model
            ->join('discount_applications', 'discounts.id', '=', 'discount_applications.discount_code_id')
            ->where('discount_applications.product_id', $productId)
            ->select('discounts.*')
            ->offset($offset)
            ->limit($limit)
            ->get();
        
        return $discounts;
    }
    

    public function getDiscountByStoreAndId($storeId, $discountId)
{
    return $this->model
        ->join('discount_applications', 'discounts.id', '=', 'discount_applications.discount_code_id')
        ->where('discount_applications.store_id', $storeId)
        ->where('discounts.id', $discountId)
        ->select('discounts.*')
        ->first();
}

    public function paginate($page = 1, $limit = 10)
    {
        $page = $page ? $page - 1 : 0;
        $this->instance = $this->model
        ->offset($page * $limit)
        ->limit($limit)
        ->orderBy('id', 'desc')
        ->get();
        return $this->instance;
    }
}
