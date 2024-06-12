<?php

namespace App\Api\V1\Http\Controllers\Category;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Repositories\Category\CategoryRepositoryInterface;
use \Illuminate\Http\Request;
use App\Api\V1\Http\Resources\Category\{AllCategoryTreeResource, RootCategoryWithProductResource, ShowCategoryWithAllResource};
use App\Api\V1\Repositories\Product\ProductRepositoryInterface;
use App\Api\V1\Http\Requests\Category\CategoryRequest;

/**
 * @group Danh mục
 */

class CategoryController extends Controller
{
    protected $repositoryProduct;
    public function __construct(
        CategoryRepositoryInterface $repository,
        ProductRepositoryInterface $repositoryProduct
    )
    {
        $this->repository = $repository;
        $this->repositoryProduct = $repositoryProduct;
    }

    /**
     * Danh sách danh mục
     *
     * Lấy danh sách danh mục.
     *
     * @headersParam X-TOKEN-ACCESS string required
     * token để lấy dữ liệu. Example: 132323
     * 
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": [
     *          {
     *               "id": 7,
     *               "name": "parent 3",
     *               "slug": "parent-3",
     *               "avatar": null,
     *               "children": [
     *                   {
     *                       "id": 8,
     *                       "name": "child 3",
     *                       "slug": "child-3",
     *                       "avatar": null
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
    public function index(Request $request){

        $categories = $this->repository->getTree();
        $categories = new AllCategoryTreeResource($categories);

        return response()->json([
            'status' => 200,
            'message' => __('Thực hiện thành công.'),
            'data' => $categories
        ]);
    }
    /**
     * Chi tiết danh mục
     *
     * Lấy chi tiết danh mục.
     *
     * @headersParam X-TOKEN-ACCESS string required
     * token để lấy dữ liệu. Example: 132323
     * 
     * @pathParam id integer required
     * id hoặc slug danh mục. Example: 1 | cat-1
     * 
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
        try{
            $category = $this->repository->findByIdOrSlugWithAncestorsAndDescendants($id);
            $category = new ShowCategoryWithAllResource($category, $this->repositoryProduct);
            return response()->json([
                'status' => 200,
                'message' => __('Thực hiện thành công.'),
                'data' => $category
            ]);
        }catch (\Throwable $th) {
            // throw $th;
            return response()->json([
                'status' => 404,
                'message' => __('Không tìm thấy dữ liệu')
            ], 404);
        }
    }

    /**
     * Danh sách danh mục kèm sản phẩm
     *
     * Lấy danh sách danh mục root và tất cả sản phẩm thuộc danh mục này và danh mục của nó.
     *
     * @headersParam X-TOKEN-ACCESS string required
     * token để lấy dữ liệu. Example: 132323
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
        $categories = $this->repository->getRootWithAllChildren();
        $categories = new RootCategoryWithProductResource($categories, $this->repositoryProduct);
        return $categories;
    }

}
