<?php

namespace App\Api\V1\Http\Controllers\Product;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Repositories\Product\ProductRepositoryInterface;
use App\Api\V1\Http\Requests\Product\ProductRequest;

/**
 * @group Sản phẩm cho user
 */

class ProductAuthController extends Controller
{
    protected $controllerProduct;

    public function __construct(
        ProductRepositoryInterface $repository
    )
    {
        $this->repository = $repository;
        $this->controllerProduct = new ProductController($repository);
    }

    /**
     * Danh sách sản phẩm của user
     *
     * Lấy danh sách sản phẩm.
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     * 
     * @queryParam keywords string
     * Từ khóa sản phẩm. Example: ipad
     * 
     * @authenticated
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
        return $this->controllerProduct->index($request);
    }
    /**
     * chi tiết sản phẩm của user
     *
     * Lấy tiết của sản phẩm.
     *
     * @headersParam X-TOKEN-ACCESS string required
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     * 
     * @pathParam id integer required
     * id sản phẩm. Example: 1
     * @authenticated
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
        return $this->controllerProduct->show($id);
    }

}
