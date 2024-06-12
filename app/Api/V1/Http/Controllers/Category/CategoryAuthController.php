<?php

namespace App\Api\V1\Http\Controllers\Category;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Repositories\Category\CategoryRepositoryInterface;
use \Illuminate\Http\Request;
use App\Api\V1\Http\Resources\Category\{AllCategoryTreeResource, RootCategoryWithProductResource};
use App\Api\V1\Repositories\Product\ProductRepositoryInterface;

/**
 * @group Danh mục của user
 */

class CategoryAuthController extends Controller
{
    protected $controllerCategory;
    protected $repositoryProduct;
    public function __construct(
        CategoryRepositoryInterface $repository,
        ProductRepositoryInterface $repositoryProduct
    )
    {
        $this->repository = $repository;
        $this->repositoryProduct = $repositoryProduct;
        $this->controllerCategory = new CategoryController($repository, $repositoryProduct);
    }
    /**
     * Chi tiết danh mục của user
     *
     * Lấy chi tiết danh mục của user.
     *
     * @headersParam X-TOKEN-ACCESS string required
     * token để lấy dữ liệu. Example: 132323
     * 
     * @pathParam id integer required
     * id danh mục. Example: 1
     * 
     * @authenticated
     * 
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": {
     *          "id": 6,
     *           "name": "children",
     *           "slug": "children",
     *           "parents": [
     *               {
     *                   "id": 7,
     *                   "name": "parent",
     *                   "slug": "parent"
     *               },
     *               {
     *                   "id": 9,
     *                   "name": "chuas",
     *                   "slug": "chuas"
     *               }
     *           ],
     *           "products": [
     *               {
     *                   "id": 5,
     *                   "name": "Iphone 16",
     *                   "slug": "iphone-16",
     *                   "in_stock": true,
     *                   "avatar": "http://localhost/topzone/public/assets/images/default-image.png",
     *                   "price": 200000,
     *                   "promotion_price": null
     *               }
     *           ]
     *       }
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        return $this->controllerCategory->show($id);
    }
    /**
     * Danh sách danh mục kèm sản phẩm của user
     *
     * Lấy danh sách danh mục root và tất cả sản phẩm thuộc danh mục này và danh mục của nó cho user.
     *
     * @headersParam X-TOKEN-ACCESS string required
     * token để lấy dữ liệu. Example: 132323
     * 
     * @authenticated
     * 
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": [
     *          {
     *              "id": 5,
     *             "name": "Ipad",
     *             "slug": "ipad",
     *              "products": [
     *                   {
     *                       "id": 4,
     *                       "name": "iPab pro",
     *                       "slug": "iPab-pro",
     *                       "in_stock": true,
     *                       "avatar": "http://localhost/topzone/public/assets/images/default-image.png",
     *                       "price": 2000000,
     *                       "promotion_price": null
     *                   }
     *               ]
     *           }
     *      ]
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function product(Request $request){
        return $this->controllerCategory->product($request);
    }
    

}
