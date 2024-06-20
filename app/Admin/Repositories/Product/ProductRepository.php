<?php

namespace App\Admin\Repositories\Product;
use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\Product\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductRepository extends EloquentRepository implements ProductRepositoryInterface
{

    protected $select = [];

    public function getModel(){
        return Product::class;
    }
    public function getByIdsAndOrderByIds(array $ids){
        $this->instance = $this->model
        ->whereIn('id', $ids)
        ->orderByRaw(DB::raw("FIELD(id, " . implode(',', $ids) . ")"))
        ->get();

        return $this->instance;
    }
    public function updateQty($orders){

        foreach($orders as $item){
            $product = $this->model->where('id',$item->product_id)->get();
            foreach($product as $data){
                $data->qty = $data->qty - $item->qty;
                $data->save();
            }
        }
    }

    public function getAllByColumns(array $data){
        $this->getQueryBuilder();
        foreach($data as $key => $value){
            if($key == 'name'){
                $this->instance = $this->instance->where($key, 'like', "%{$value}%");
            }else{
                $this->instance = $this->instance->where($key, $value);
            }
        }
        $this->instance = $this->instance->get();
        return $this->instance;
    }
    public function getByColumnsWithRelationsLimit(array $data, array $relations = ['productVariations.attributeVariations.attribute'], $limit = 10){
        $this->getQueryBuilderWithRelations($relations);

        foreach($data as $key => $value){
            if($key == 'name'){
                $this->instance = $this->instance->where($key, 'like', "%{$value}%");
            }else{
                $this->instance = $this->instance->where($key, $value);
            }
        }

        $this->instance = $this->instance->limit($limit)->get();
        return $this->instance;
    }

    public function attachCategories(Product $product, array $categoriesId){
        return $product->categories()->attach($categoriesId);
    }

    public function syncCategories(Product $product, array $categoriesId){
        return $product->categories()->sync($categoriesId);
    }
    public function deleteProductAttributes(Product $product){
        $product->productAttributes()->delete();
    }
    public function deleteProductVariations(Product $product){
        $product->productVariations()->delete();
    }
    public function loadRelations(Product $product, array $relations = []){
        return $product->load($relations);
    }
    public function getQueryBuilderWithRelations($relations = ['categories', 'productVariations']){
        $this->getQueryBuilderOrderBy();
        $this->instance = $this->instance->with($relations);
        return $this->instance;
    }
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC'){
        $this->getQueryBuilder();
        $this->instance = $this->instance->orderBy($column, $sort);
        return $this->instance;
    }
    public function searchAllLimit($keySearch = '', $meta = [], $select = ['id', 'name', 'price'], $limit = 10){
        $this->instance = $this->model->select($select);
        $this->getQueryBuilderFindByKey($keySearch);

        foreach($meta as $key => $value){
            $this->instance = $this->instance->where($key, $value);
        }

        return $this->instance->limit($limit)->get();
    }

    protected function getQueryBuilderFindByKey($key){
        $this->instance = $this->instance->where(function($query) use ($key){
            return $query->where('name', 'LIKE', '%'.$key.'%')
                ->orWhere('price', 'LIKE', '%'.$key.'%');
        });
    }
}
