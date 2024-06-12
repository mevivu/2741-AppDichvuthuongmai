<?php

namespace App\Api\V1\Repositories\Product;

use App\Admin\Repositories\Product\ProductRepository as AdminProductRepository;
use App\Api\V1\Repositories\Product\ProductRepositoryInterface;

class ProductRepository extends AdminProductRepository implements ProductRepositoryInterface
{
    public function findOrFailWithRelations($id, array $relations = ['productAttributes', 'productVariations'])
    {
        $this->findOrFail($id);
        if(in_array('productAttributes', $relations)){
            $relations['productAttributes'] = function($query){
                return $query->with(['attribute', 'attributeVariations']);
            };
        }
        $this->instance = $this->instance->load($relations);
        return $this->instance;
    }
    
    public function getByCategoriesWithRelations(array $categories_id = [], array $relations = ['productVariations']){
        $this->instance = $this->model->active()
        ->whereHas('categories', function($query) use ($categories_id){
            $query->whereIn('id', $categories_id);
        })
        ->with($relations)
        ->orderBy('id', 'desc')
        ->get();
        return $this->instance;
    }
    public function getSearchByKeysWithRelations(array $data, array $relations = ['productVariations']){
        $this->instance = $this->model->active();
        if(isset($data['keywords'])){
            $this->instance = $this->instance->where('name', 'like', "%{$data['keywords']}%");    
        }
        $this->instance = $this->instance->with($relations)
        ->orderBy('id', 'desc')
        ->get();
        return $this->instance;
    }
    public function getAllWithRelations(array $relations = ['productVariations']){
        $this->instance = $this->model->active()
        ->with($relations)
        ->orderBy('id', 'desc')
        ->get();
        return $this->instance;
    }
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC'){
        $this->getQueryBuilder();
        $this->instance = $this->instance->orderBy($column, $sort);
        return $this->instance;
    }

    // public function getAllWithRelations(array $relations = ['productVariations']){
    //     $discount = $this->getDiscountProduct();
        
    //     if(in_array('productVariations', $relations)){
    //         $relations['productVariations'] = function($query) use ($discount){
    //             return $query->select('*')
    //             ->selectRaw('CASE WHEN is_user_discount = ? THEN price * (1 - ? / 100) ELSE price END AS price', [$discount, true])
    //             ->selectRaw('promotion_price * (1 - ? / 100) AS promotion_price', [$discount]);
    //         };
    //     }

    //     $this->instance = $this->model->select('*')
    //     ->selectRaw('CASE WHEN type = ? AND is_user_discount = ? THEN price * (1 - ? / 100) ELSE price END AS price', [ProductType::Simple, true,$discount])
    //     ->selectRaw('CASE WHEN type = ? AND is_user_discount = ? THEN promotion_price * (1 - ? / 100) ELSE promotion_price END AS promotion_price', [ProductType::Simple, true, $discount])
    //     ->active()
    //     ->with($relations)
    //     ->orderBy('id', 'desc')
    //     ->get();
    //     return $this->instance;
    // }
}