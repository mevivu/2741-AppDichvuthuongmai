<?php

namespace App\Api\V1\Http\Controllers\Product;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Repositories\Product\ProductRepositoryInterface;
use App\Api\V1\Http\Resources\Product\{AllProductResource, ShowProductResource};
use App\Api\V1\Http\Requests\Product\ProductRequest;

/**
 * @group Sản phẩm
 */

class ProductController extends Controller
{
    
    public function __construct(
        ProductRepositoryInterface $repository
    )
    {
        $this->repository = $repository;
    }

    /**
     * Danh sách sản phẩm
     *
     * Lấy danh sách sản phẩm.
     *
     * @headersParam X-TOKEN-ACCESS string required
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     * 
     * @queryParam keywords string
     * Từ khóa sản phẩm. Example: ipad
     * 
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": [
     *          {
     *              "id": 10,
     *               "name": "Iphone 14",
     *               "slug": "iphone-14",
     *               "in_stock": true,
     *               "avatar": "http://localhost/topzone/public/assets/images/default-image.png",
     *               "price": 20900,
     *               "promotion_price": 10000
     *           }
     *      ]
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(ProductRequest $request){
        
        $data = $request->validated();
        
        $products = $this->repository->getSearchByKeysWithRelations($data);

        $products = new AllProductResource($products);

        return response()->json([
            'status' => 200,
            'message' => __('Thực hiện thành công.'),
            'data' => $products
        ]);
    }
    /**
     * chi tiết sản phẩm
     *
     * Lấy tiết của sản phẩm.
     *
     * @headersParam X-TOKEN-ACCESS string required
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     * 
     * @pathParam id integer required
     * id sản phẩm. Example: 1
     * 
     * 
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": [
     *          {
     *              "id": 10,
     *               "name": "Iphone 14",
     *               "slug": "iphone-14",
     *               "in_stock": true,
     *               "avatar": "http://localhost/topzone/public/assets/images/default-image.png",
     *               "price": 20900,
     *               "promotion_price": 10000
     *           }
     *      ]
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        try{
            $product = $this->repository->findOrFailWithRelations($id);
            $product = new ShowProductResource($product);
            return response()->json([
                'status' => 200,
                'message' => __('Thực hiện thành công.'),
                'data' => $product
            ]);
        }catch (\Throwable $th) {
            return response()->json([
                'status' => 404,
                'message' => __('Không tìm thấy sản phẩm')
            ], 404);
        }
    }

}
