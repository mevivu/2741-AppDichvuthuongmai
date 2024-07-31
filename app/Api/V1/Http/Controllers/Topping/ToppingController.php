<?php

namespace App\Api\V1\Http\Controllers\Topping;

use App\Admin\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Api\V1\Http\Requests\Topping\ToppingRequest;
use App\Api\V1\Http\Resources\Topping\{AllToppingResource, ShowToppingResource};
use App\Api\V1\Repositories\Topping\ToppingRepositoryInterface;
use App\Api\V1\Services\Topping\ToppingServiceInterface;


/**
 * @group Quản lý Topping
 */

class ToppingController extends Controller
{
    public function __construct(
        ToppingRepositoryInterface $repository,
        ToppingServiceInterface $service
    ) {
        $this->repository = $repository;
        $this->service = $service;
    }
    /**
     * DS Quản lý Topping
     *
     * Lấy danh sách các Topping.
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Ví dụ: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     * 
     * @authenticated Authorization string required
     * access_token được cấp sau khi đăng nhập. Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
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
     *               "name": "Thạch dừa",
     *               "price": "Thông tin của Loại Giá phòng",
     *               "status": "Thông tin của trạng thái topping",
     *               "avatar": "Thông tin của avatar",
     *          }     
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
    public function index(ToppingRequest $request)
    {
        try {
            $data = $request->validated();
            $toppings = $this->repository->paginate(...$data);
            $toppings = new AllToppingResource($toppings);
            return response()->json([
                'status' => 200,
                'message' => __('Thực hiện thành công.'),
                'data' => $toppings
            ]);
        } catch (\Exception $e) {
            // Xử lý ngoại lệ nếu cần thiết
            return response()->json([
                'status' => 500,
                'message' => __('Thực hiện thất bại.')
            ]);
        }
    }
    /**
     * Xóa Topping
     *
     * Xóa Topping theo ID
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Ví dụ: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     * 
     * @authenticated Authorization string required 
     * access_token được cấp sau khi đăng nhập. Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     * 
     * @pathParam id integer required
     * id Topping. Ví dụ: 1
     * 
     * 
     * @response 200 {
     *      "status": 200,
     *      "message": "Xóa thành công."
     * }
     * @response 400 {
     *      "status": 400,
     *      "message": "Xóa thất bại."
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function delete(ToppingRequest $request)
    {
        $response = $this->service->delete($request);
        if ($response) {
            return response()->json([
                'status' => 200,
                'message' => __('Xóa thành công.')
            ]);
        }
        return response()->json([
            'status' => 400,
            'message' => __('Xóa thất bại.')
        ]);
    }

    /**
     * Thêm Topping
     *
     * Thêm một Topping mới
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Ví dụ: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     * 
     * @authenticated Authorization string required
     * access_token được cấp sau khi đăng nhập. Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K 
     * 
     * @pathParam name string(200) required
     * Tên Topping
     * 
     * @pathParam price Integer required
     * Giá
     * 
     * @pathParam status TinyInteger 
     * Trạng thái topping (1: còn món, 2: hết món)
     * 
     * @pathParam avatar String nullable
     * Avatar
     * 
     * @response 200 {
     *      "status": 200,
     *      "message": "Thêm thành công."
     * }
     * @response 400 {
     *      "status": 400,
     *      "message": "Thêm thất bại. Hãy kiểm tra lại."
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function add(ToppingRequest $request)
    {
        $response = $this->service->add($request);
        if ($response) {
            return response()->json([
                'status' => 200,
                'message' => __('Thêm thành công.')
            ]);
        }
        return response()->json([
            'status' => 400,
            'message' => __('Thêm thất bại. Hãy kiểm tra lại.')
        ], 400);
    }

    /**
     * Sửa Topping
     *
     * Sửa một Topping
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Ví dụ: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     * 
     * @authenticated Authorization string required
     * access_token được cấp sau khi đăng nhập. Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K 
     * 
     * @pathParam id integer 
     * ID topping
     * 
     * @pathParam name string(200) required
     * Tên Topping
     * 
     * @pathParam price Integer required
     * Giá
     * 
     * @pathParam status TinyInteger 
     * Trạng thái topping (1: còn món, 2: hết món)
     * 
     * @pathParam avatar String nullable
     * Avatar
     * @response 200 {
     *      "status": 200,
     *      "message": "Sửa thành công."
     * }
     * @response 400 {
     *      "status": 400,
     *      "message": "Sửa thất bại. Hãy kiểm tra lại."
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(ToppingRequest $request)
    {
        $response = $this->service->edit($request);
        if ($response) {
            return response()->json([
                'status' => 200,
                'message' => __('Sửa thành công.')
            ]);
        }
        return response()->json([
            'status' => 400,
            'message' => __('Sửa thất bại. Hãy kiểm tra lại.')
        ], 400);
    }

}

