<?php

namespace App\Api\V1\Http\Controllers\CategorySystem;

use App\Admin\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Api\V1\Http\Requests\CategorySystem\CategorySystemRequest;
use App\Api\V1\Http\Resources\CategorySystem\{AllCategorySystemResource, ShowCategorySystemResource};
use App\Api\V1\Repositories\CategorySystem\CategorySystemRepositoryInterface;
use App\Api\V1\Services\CategorySystem\CategorySystemServiceInterface;
use App\Api\V1\Services\CategorySystem\CategorySystemService;

/**
 * @group Quản lý Phòng
 */

class CategorySystemController extends Controller
{
    public function __construct(
        CategorySystemRepositoryInterface $repository,
        CategorySystemServiceInterface $service
    ) {
        $this->repository = $repository;
        $this->service = $service;
    }
    /**
     * DS Quản lý Phòng
     *
     * Lấy danh sách các Phòng.
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Ví dụ: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     * 
     * @queryParam page integer
     * Trang hiện tại, page > 0. Ví dụ: 1
     * 
     * @queryParam limit integer
     * Số lượng Phòng trong 1 trang, limit > 0. Ví dụ: 1
     * 
     * 
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": [
     *         {
     *               "id": 4,
     *               "name": "Thông tin của Tên Phòng",
     *               
     *         }
     *      ]
     * }
     * @response 400 {
     *      "status": 400,
     *      "message": "Vui lòng kiểm tra lại các trường field"
     * }
     * @response 500 {
     *      "status": 500,
     *      "message": "Thực hiện thất bại."
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(CategorySystemRequest $request)
    {
        try {
            $data = $request->validated();
            $category_system = $this->repository->paginate(...$data);
            $category_system = new AllCategorySystemResource($category_system);
            return response()->json([
                'status' => 200,
                'message' => __('Thực hiện thành công.'),
                'data' => $category_system
            ]);
        } catch (\Exception $e) {
            // Xử lý ngoại lệ nếu cần thiết
            return response()->json([
                'status' => 500,
                'message' => __('Thực hiện thất bại.')
            ]);
        }
    }
}
;