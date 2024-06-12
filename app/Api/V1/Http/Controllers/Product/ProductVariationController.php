<?php

namespace App\Api\V1\Http\Controllers\Product;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Repositories\Product\ProductVariationRepositoryInterface;
use App\Api\V1\Http\Requests\Product\ProductVariationRequest;
use App\Api\V1\Http\Resources\Product\ShowProductVariationResource;

/**
 * @group Sản phẩm
 */

class ProductVariationController extends Controller
{
    
    public function __construct(
        ProductVariationRepositoryInterface $repository
    )
    {
        $this->repository = $repository;
    }
    /**
     * chi tiết biến thể sản phẩm
     *
     * Lấy tiết biến thể của sản phẩm.
     *
     * @headersParam X-TOKEN-ACCESS string required
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     * 
     * @queryParam product_id integer required
     * id sản phẩm. Example: 1
     * 
     * @queryParam variation_id[] integer required
     * số id biến thể sản phẩm phải tương ứng với thuộc tính sp. Example: 1
     * 
     * 
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": [
     *          {
     *              "id": 10,
     *               "price": 20900,
     *               "promotion_price": 10000,
     *               "image": "http://localhost/topzone/public/assets/images/default-image.png"
     *           }
     *      ]
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(ProductVariationRequest $request){
        $data = $request->validated();
        try{
            $productVariation = $this->repository->findByProductAndAttributeVariation(...$data);
            $productVariation = new ShowProductVariationResource($productVariation);
            return response()->json([
                'status' => 200,
                'message' => __('Thực hiện thành công.'),
                'data' => $productVariation
            ]);
        }catch (\Throwable $th) {
            // throw $th;
            return response()->json([
                'status' => 404,
                'message' => __('Sản phẩm không có sẵn.')
            ], 404);
        }
    }

}
