<?php

namespace App\Api\V1\Http\Controllers\Product;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Repositories\Store\StoreRepositoryInterface;
use App\Admin\Services\Product\ProductService;
use App\Api\V1\Repositories\Product\ProductRepositoryInterface;
use App\Api\V1\Http\Resources\Product\{AllProductResource, ProductResource};
use App\Api\V1\Http\Requests\Product\ProductRequest;
use App\Api\V1\Support\AuthServiceApi;
use App\Api\V1\Support\Response;
use App\Traits\JwtService;
use App\Traits\UseLog;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * @group Sản phẩm
 */

class ProductController extends Controller
{
    private static string $GUARD_API_STORE = 'store-api';
    private $login;

    protected $auth;

    use AuthServiceApi, JwtService, UseLog, Response;

    protected $storeRepository;

    public function __construct(
        ProductRepositoryInterface $repository,
        StoreRepositoryInterface $storeRepository,
        ProductService $service
    ) {
        $this->repository = $repository;
        $this->service = $service;
        $this->storeRepository = $storeRepository;
        $this->middleware('auth:store-api', ['except' => ['login', 'register', 'show', 'index']]);
    }

    /**
     * Danh sách sản phẩm
     *
     * API này trả về danh sách sản phẩm
     *
     * Loại của sản phẩm(type) bao gồm:
     * - 1: Cơ bản
     * - 2: Có biến thể
     *
     * Trạng thái quản lý tồn kho của sản phẩm(manager_stock) bao gồm:
     * - 1: Có quản lý
     * - 2: Không quản lý
     *
     * Trạng thái còn hàng của sản phẩm(in_stock) bao gồm:
     * - 1: Còn hàng
     * - 2: Hết hàng
     *
     * Trạng thái hoạt động của sản phẩm(is_active) bao gồm:
     * - 1: Đang hoạt động
     * - 2: Ngưng hoạt động
     *
     * @queryParam keywords string
     * Từ khóa theo tên sản phẩm. Example: Trà sữa
     *
     * @queryParam page int
     * Trang muốn lọc. Example: 1
     *
     * @queryParam limit int
     * Số lượng sản phẩm muốn lấy trong 1 trang. Example: 8
     *
     * @queryParam store_id int
     * Id của cửa hàng muốn lọc sản phẩm. Example: 1
     *
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": {
     *          "products": [
     *              {
     *              "id": 33,
     *              "name": "Sample Product",
     *              "slug": "sample-product",
     *              "in_stock": 1,
     *              "manager_stock": 1,
     *              "is_active": 1,
     *              "type": 1,
     *              "avatar": "http://localhost:8080/2741-AppDichvuthuongmai/sample-avatar-url",
     *              "gallery": [
     *                  "https://images2.thanhnien.vn/528068263637045248/2024/1/25/428059e47aeafb68640f168d615371dc-65a11b038315c880-1706156293087602824781.jpg",
     *                  "https://images2.thanhnien.vn/528068263637045248/2024/1/25/428059e47aeafb68640f168d615371dc-65a11b038315c880-1706156293087602824781.jpg"
     *              ],
     *              "desc": "Sample Description",
     *              "min_promotion_price": 90,
     *              "min_price": 100,
     *              "max_price": 200,
     *              "attributes": [
     *                  {
     *                      "id": 1,
     *                      "type": 1,
     *                      "name": "Màu sắc",
     *                      "variations": [
     *                          {
     *                              "id": 1,
     *                              "name": "Variation 1",
     *                              "meta_value": null
     *                          },
     *                          {
     *                              "id": 2,
     *                              "name": "Variation 2",
     *                              "meta_value": null
     *                          }
     *                      ]
     *                  },
     *                  {
     *                      "id": 2,
     *                      "type": 1,
     *                      "name": "Kích thước",
     *                      "variations": [
     *                          {
     *                              "id": 4,
     *                              "name": "Variation 1",
     *                              "meta_value": null
     *                          },
     *                          {
     *                              "id": 3,
     *                              "name": "Variation 3",
     *                              "meta_value": null
     *                          }
     *                      ]
     *                  }
     *              ]
     *           }
     *          ],
     *          "links": {
     *              "first": "http://localhost:8080/2741-AppDichvuthuongmai/api/v1/products?page=1",
     *              "last": "http://localhost:8080/2741-AppDichvuthuongmai/api/v1/products?page=1",
     *              "prev": null,
     *              "next": null
     *          },
     *          "meta": {
     *              "current_page": 1,
     *              "from": 1,
     *              "to": 3,
     *              "limit": 10,
     *              "total": 3,
     *              "count": 3,
     *              "total_pages": 1
     *          }
     *      }
     * }
     *
     * @param ProductRequest $request
     *
     * @return JsonResponse
     */
    public function index(ProductRequest $request): JsonResponse
    {

        $data = $request->validated();

        $products = $this->repository->getSearchByKeysWithRelations($data);

        $products = new AllProductResource($products);

        return $this->jsonResponseSuccess($products, __('Thực hiện thành công.'));
    }

    /**
     * Chi tiết sản phẩm
     *
     * Lấy tiết của sản phẩm.
     *
     * Loại của sản phẩm(type) bao gồm:
     * - 1: Cơ bản
     * - 2: Có biến thể
     *
     * Trạng thái quản lý tồn kho của sản phẩm(manager_stock) bao gồm:
     * - 1: Có quản lý
     * - 2: Không quản lý
     *
     * Trạng thái còn hàng của sản phẩm(in_stock) bao gồm:
     * - 1: Còn hàng
     * - 2: Hết hàng
     *
     * Trạng thái hoạt động của sản phẩm(is_active) bao gồm:
     * - 1: Đang hoạt động
     * - 2: Ngưng hoạt động
     *
     * API này trả về thông tin chi tiết của Cửa hàng đã xác thực hiện tại
     * @authenticated
     * Example: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvMjc0MS1BcHBEaWNodnV0aHVvbmdtYWkvYXBpL3YxL3N0b3Jlcy9sb2dpbiIsImlhdCI6MTcyMjMyODI3NSwiZXhwIjoxNzI3NTEyMjc1LCJuYmYiOjE3MjIzMjgyNzUsImp0aSI6IlhJSUd4TEs5Y2FKQ1YwZlciLCJzdWIiOiIxIiwicHJ2IjoiZTVjYjM4YmY4ZDIzZGQ2ZWE4ZWFiODIwZDk1NTVlNmI3NGU2NzU0ZSJ9.y1P1ZzH4Qnh0eHFEPCy9FVlZe3ooNv8riyHqzApWeyw
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
     *              "id": 33,
     *              "name": "Sample Product",
     *              "slug": "sample-product",
     *              "in_stock": 1,
     *              "manager_stock": 1,
     *              "is_active": 1,
     *              "type": 1,
     *              "avatar": "http://localhost:8080/2741-AppDichvuthuongmai/sample-avatar-url",
     *              "gallery": [
     *                  "https://images2.thanhnien.vn/528068263637045248/2024/1/25/428059e47aeafb68640f168d615371dc-65a11b038315c880-1706156293087602824781.jpg",
     *                  "https://images2.thanhnien.vn/528068263637045248/2024/1/25/428059e47aeafb68640f168d615371dc-65a11b038315c880-1706156293087602824781.jpg"
     *              ],
     *              "desc": "Sample Description",
     *              "min_promotion_price": 90,
     *              "min_price": 100,
     *              "max_price": 200,
     *              "attributes": [
     *                  {
     *                      "id": 1,
     *                      "type": 1,
     *                      "name": "Màu sắc",
     *                      "variations": [
     *                          {
     *                              "id": 1,
     *                              "name": "Variation 1",
     *                              "meta_value": null
     *                          },
     *                          {
     *                              "id": 2,
     *                              "name": "Variation 2",
     *                              "meta_value": null
     *                          }
     *                      ]
     *                  },
     *                  {
     *                      "id": 2,
     *                      "type": 1,
     *                      "name": "Kích thước",
     *                      "variations": [
     *                          {
     *                              "id": 4,
     *                              "name": "Variation 1",
     *                              "meta_value": null
     *                          },
     *                          {
     *                              "id": 3,
     *                              "name": "Variation 3",
     *                              "meta_value": null
     *                          }
     *                      ]
     *                  }
     *              ]
     *           }
     *      ]
     * }
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            $product = $this->repository->findOrFailWithRelations($id);
            $product = new ProductResource($product);
            return $this->jsonResponseSuccess($product, __('Thực hiện thành công.'));
        } catch (Exception $e) {
            $this->logError('Show Product Failed', $e);
            return $this->jsonResponseError($e->getMessage(), 500);
        }
    }

    /**
     * Tạo mới sản phẩm cho cửa hàng
     *
     * Loại của sản phẩm(type) bao gồm:
     * - 1: Cơ bản
     * - 2: Có biến thể
     *
     * Trạng thái còn hàng của sản phẩm(in_stock) bao gồm:
     * - 1: Còn hàng
     * - 2: Hết hàng
     *
     * Trạng thái hoạt động của sản phẩm(is_active) bao gồm:
     * - 1: Đang hoạt động
     * - 2: Ngưng hoạt động
     *
     * API này dùng để tạo mới sản phẩm cho cửa hàng
     * @authenticated
     * Example: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvMjc0MS1BcHBEaWNodnV0aHVvbmdtYWkvYXBpL3YxL3N0b3Jlcy9sb2dpbiIsImlhdCI6MTcyMjMyODI3NSwiZXhwIjoxNzI3NTEyMjc1LCJuYmYiOjE3MjIzMjgyNzUsImp0aSI6IlhJSUd4TEs5Y2FKQ1YwZlciLCJzdWIiOiIxIiwicHJ2IjoiZTVjYjM4YmY4ZDIzZGQ2ZWE4ZWFiODIwZDk1NTVlNmI3NGU2NzU0ZSJ9.y1P1ZzH4Qnh0eHFEPCy9FVlZe3ooNv8riyHqzApWeyw
     *
     * @bodyParam product.name string required Tên sản phẩm. Example: "Sample Product"
     * @bodyParam product.desc string Mô tả sản phẩm. Example: "Sample Description"
     * @bodyParam categories_id array ID của các danh mục. Example: [1, 2, 3]
     * @bodyParam product.avatar string required URL của ảnh đại diện sản phẩm. Example: "sample-avatar-url"
     * @bodyParam product.price int Giá sản phẩm. Example: 100.0
     * @bodyParam product.promotion_price int Giá khuyến mãi của sản phẩm. Example: 90.0
     * @bodyParam product.type int required Loại sản phẩm. Example: 1
     * @bodyParam product.in_stock int Trạng thái còn hàng. Example: 1
     * @bodyParam product.is_active int Trạng thái hoạt động. Example: 1
     * @bodyParam product.gallery array Bộ sưu tập ảnh của sản phẩm. Example: ["image1-url", "image2-url"]
     * @bodyParam toppings_id array ID của các topping. Example: [1, 2]
     * @bodyParam discount_ids array ID của các khuyến mãi. Example: [1, 2]
     * @bodyParam product_attribute.attribute_id array ID của các thuộc tính sản phẩm. Example: [1, 2]
     * @bodyParam product_attribute.attribute_variation_id array ID của các biến thể thuộc tính. Example: [[1, 2], [3, 4]]
     * @bodyParam products_variations.id array ID của các biến thể sản phẩm. Example: [1, 2]
     * @bodyParam products_variations.attribute_variation_id array ID của các biến thể thuộc tính sản phẩm. Example: [[1, 2], [3, 4]]
     * @bodyParam products_variations.image array URL của các ảnh biến thể sản phẩm. Example: ["image1-url", "image2-url"]
     * @bodyParam products_variations.price array Giá của các biến thể sản phẩm. Example: [100.0, 200.0]
     * @bodyParam products_variations.promotion_price array Giá khuyến mãi của các biến thể sản phẩm. Example: [90.0, 180.0]
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Thực hiện thành công."
     * }
     *
     * @response 400 {
     *     "status": 400,
     *     "message": "Vui lòng kiểm tra lại các trường."
     * }
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "ERROR!!!"
     * }
     *
     * @return JsonResponse
     */
    public function store(ProductRequest $request): JsonResponse
    {
        try {
            $instance = $this->service->storeApi($request);
            if ($instance) {
                return $this->jsonResponseSuccess($instance, __('Thực hiện thành công.'));
            }
            return $this->jsonResponseError();
        } catch (Exception $e) {
            $this->logError('Create Product Failed', $e);
            return $this->jsonResponseError($e->getMessage(), 500);
        }
    }

    /**
     * Cập nhật sản phẩm cho cửa hàng
     *
     * Loại của sản phẩm(type) bao gồm:
     * - 1: Cơ bản
     * - 2: Có biến thể
     *
     * Trạng thái còn hàng của sản phẩm(in_stock) bao gồm:
     * - 1: Còn hàng
     * - 2: Hết hàng
     *
     * Trạng thái hoạt động của sản phẩm(is_active) bao gồm:
     * - 1: Đang hoạt động
     * - 2: Ngưng hoạt động
     *
     * API này dùng để Cập nhật sản phẩm cho cửa hàng
     * @authenticated
     * Example: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvMjc0MS1BcHBEaWNodnV0aHVvbmdtYWkvYXBpL3YxL3N0b3Jlcy9sb2dpbiIsImlhdCI6MTcyMjMyODI3NSwiZXhwIjoxNzI3NTEyMjc1LCJuYmYiOjE3MjIzMjgyNzUsImp0aSI6IlhJSUd4TEs5Y2FKQ1YwZlciLCJzdWIiOiIxIiwicHJ2IjoiZTVjYjM4YmY4ZDIzZGQ2ZWE4ZWFiODIwZDk1NTVlNmI3NGU2NzU0ZSJ9.y1P1ZzH4Qnh0eHFEPCy9FVlZe3ooNv8riyHqzApWeyw
     *
     * @bodyParam product.name string optional Tên sản phẩm. Example: "Sample Product"
     * @bodyParam product.desc string Mô tả sản phẩm. Example: "Sample Description"
     * @bodyParam categories_id array ID của các danh mục. Example: [1, 2, 3]
     * @bodyParam product.avatar string optional URL của ảnh đại diện sản phẩm. Example: "sample-avatar-url"
     * @bodyParam product.price numeric Giá sản phẩm. Example: 100.0
     * @bodyParam product.promotion_price numeric Giá khuyến mãi của sản phẩm. Example: 90.0
     * @bodyParam product.type numeric Loại sản phẩm. Example: 1
     * @bodyParam product.in_stock int Trạng thái còn hàng. Example: 1
     * @bodyParam product.is_active int Trạng thái hoạt động. Example: 1
     * @bodyParam product.gallery array Bộ sưu tập ảnh của sản phẩm. Example: ["image1-url", "image2-url"]
     * @bodyParam toppings_id array ID của các topping. Example: [1, 2]
     * @bodyParam discount_ids array ID của các khuyến mãi. Example: [1, 2]
     * @bodyParam product_attribute.attribute_id array ID của các thuộc tính sản phẩm. Example: [1, 2]
     * @bodyParam product_attribute.attribute_variation_id array ID của các biến thể thuộc tính. Example: [[1, 2], [3, 4]]
     * @bodyParam products_variations.id array ID của các biến thể sản phẩm. Example: [1, 2]
     * @bodyParam products_variations.attribute_variation_id array ID của các biến thể thuộc tính sản phẩm. Example: [[1, 2], [3, 4]]
     * @bodyParam products_variations.image array URL của các ảnh biến thể sản phẩm. Example: ["image1-url", "image2-url"]
     * @bodyParam products_variations.price array Giá của các biến thể sản phẩm. Example: [100.0, 200.0]
     * @bodyParam products_variations.promotion_price array Giá khuyến mãi của các biến thể sản phẩm. Example: [90.0, 180.0]
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Thực hiện thành công."
     * }
     *
     * @response 400 {
     *     "status": 400,
     *     "message": "Vui lòng kiểm tra lại các trường."
     * }
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "ERROR!!!"
     * }
     *
     * @return JsonResponse
     */
    public function update(ProductRequest $request): JsonResponse
    {
        try {
            $instance = $this->service->updateApi($request);
            if ($instance) {
                return $this->jsonResponseSuccess($instance, __('Thực hiện thành công.'));
            }
            return $this->jsonResponseError();
        } catch (Exception $e) {
            $this->logError('Update Product Failed', $e);
            return $this->jsonResponseError($e->getMessage(), 500);
        }
    }
    /**
     * Xoá sản phẩm cho cửa hàng
     *
     * API này dùng để Xoá sản phẩm cho cửa hàng
     * @authenticated
     * Example: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvMjc0MS1BcHBEaWNodnV0aHVvbmdtYWkvYXBpL3YxL3N0b3Jlcy9sb2dpbiIsImlhdCI6MTcyMjMyODI3NSwiZXhwIjoxNzI3NTEyMjc1LCJuYmYiOjE3MjIzMjgyNzUsImp0aSI6IlhJSUd4TEs5Y2FKQ1YwZlciLCJzdWIiOiIxIiwicHJ2IjoiZTVjYjM4YmY4ZDIzZGQ2ZWE4ZWFiODIwZDk1NTVlNmI3NGU2NzU0ZSJ9.y1P1ZzH4Qnh0eHFEPCy9FVlZe3ooNv8riyHqzApWeyw
     *
     * @pathParam id int required Id sản phẩm. Example: 1
     *
     * @response 200 {
     *     "status": 200,
     *     "message": "Thực hiện thành công."
     * }
     *
     * @response 400 {
     *     "status": 400,
     *     "message": "Thực hiện thất bại."
     * }
     *
     * @response 500 {
     *     "status": 500,
     *     "message": "ERROR!!!"
     * }
     *
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        try {
            $instance = $this->service->delete($id);
            if ($instance) {
                return $this->jsonResponseSuccessNoData(__('Thực hiện thành công.'));
            }
            return $this->jsonResponseError();
        } catch (Exception $e) {
            $this->logError('Delete Product Failed', $e);
            return $this->jsonResponseError($e->getMessage(), 500);
        }
    }
}
