<?php

namespace App\Api\V1\Services\ShoppingCart;

use App\Api\V1\Services\ShoppingCart\ShoppingCartServiceInterface;
use App\Api\V1\Repositories\ShoppingCart\ShoppingCartRepositoryInterface;
use App\Api\V1\Repositories\Product\{ProductRepositoryInterface, ProductVariationRepositoryInterface};
use App\Enums\Product\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShoppingCartService implements ShoppingCartServiceInterface
{
    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;
    
    protected $repository;
    protected $repositoryProduct;
    protected $repositoryProductVariation;

    public function __construct(
        ShoppingCartRepositoryInterface $repository,
        ProductRepositoryInterface $repositoryProduct,
        ProductVariationRepositoryInterface $repositoryProductVariation,
    ){
        $this->repository = $repository;
        $this->repositoryProduct = $repositoryProduct;
        $this->repositoryProductVariation = $repositoryProductVariation;
    }
    
    public function store(Request $request){
        $this->data = $request->validated();
        
        try {
            $product = $this->repositoryProduct->findOrFail($this->data['product_id']);

            $compare = [
                'user_id' => auth()->user()->id,
                'product_id' => $this->data['product_id']
            ];

            if($product->type == ProductType::Variable()){
                $productVariation = $this->repositoryProductVariation->findByProductAndAttributeVariation($this->data['product_id'], $this->data['variation_id']);
                $compare['product_variation_id'] = $productVariation->id;
            }

            $instance = $this->repository->updateOrCreate($compare, [
                'qty' => DB::raw("qty + {$this->data['qty']}")
            ]);

            return $instance;
        } catch (\Throwable $th) {
            // throw $th;
            return false;
        }
    }

    public function update(Request $request){
        
        $this->data = $request->validated();
        $instance = $this->repository->updateMultiple($this->data['id'], $this->data['qty']);
        // return $result = collect($this->data['qty'])
        // ->filter(fn($value) => $value != 0)
        // ->map(fn($value, $key) => $this->data['id'][$key] ?? null)
        // ->filter()
        // ->values()
        // ->all();

        return $instance;

    }

    public function deleteMultiple(Request $request){
        return $this->repository->deleteMultiple($request->input('id'));
    }

    public function delete($id){
        return $this->repository->delete($id);
    }

}