<?php

namespace App\Api\V1\Http\Controllers\Discount;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Resources\Discount\{AllDiscountResource, ShowDiscountResource};
use App\Api\V1\Repositories\Discount\DiscountRepositoryInterface;
use Illuminate\Http\Request; 
use App\Api\V1\Http\Requests\Discount\DiscountRequest;
use Illuminate\Support\Facades\Log;

class DiscountAuthController extends Controller
{

    public function __construct(
        DiscountRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }


   /**
     * Danh sách Discount theo user_id
     *
     * Lấy danh sách tất cả Discount theo user_id
     *
     * @param  \App\Api\V1\Http\Requests\Discount\DiscountRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function index(DiscountRequest $request)
    {
        try {
            $data = $request->validated();
           
            // Từ access token lấy ra được người dùng đã xác thực (đăng nhập) và lấy ra id của người dùng
            $userId = auth()->user()->id;

            // Lấy danh sách discount dựa theo id của người dùng và phân trang getDiscountsByUserId
            $discounts = $this->repository->getDiscountsByUserId($userId, ...$data);

            // Chuyển đổi các discount thành resource đã phân trang
            $discounts = AllDiscountResource::collection($discounts);

            // Trả về phản hồi JSON thành công
            return response()->json([
                'status' => 200,
                'message' => __('Thực hiện thành công.'),
                'data' => $discounts
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => __('Thực hiện thất bại.')
            ]);
        }
    }
}