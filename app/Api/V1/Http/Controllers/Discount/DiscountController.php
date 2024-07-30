<?php

namespace App\Api\V1\Http\Controllers\Discount;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Resources\Discount\{AllDiscountResource, ShowDiscountResource};
use App\Api\V1\Repositories\Discount\DiscountRepositoryInterface;
use Illuminate\Http\Request;
use App\Api\V1\Http\Requests\Discount\DiscountRequest;
use Illuminate\Support\Facades\Log;

class DiscountController extends Controller
{
    public function __construct(
        DiscountRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }


    // * @param  \Illuminate\Http\Request  $request
    // * 
    // * @return \Illuminate\Http\Response
    // */
    
   public function index(DiscountRequest $request){
       try {
           $data = $request->validated();
           $discounts = $this->repository->paginate(...$data);
           $discounts = new AllDiscountResource($discounts);
           return response()->json([
               'status' => 200,
               'message' => __('Thực hiện thành công.'),
               'data' => $discounts
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
     * Chi tiết Discount
     *
     * Lấy chi tiết của Discount
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $discount = $this->repository->findByID($id);
            $discount = new ShowDiscountResource($discount);
            return response()->json([
                'status' => 200,
                'message' => __('Thực hiện thành công.'),
                'data' => $discount
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
     * Danh sách Discount theo store_id
     *
     * Lấy danh sách tất cả Discount theo store_id
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getByStore(Request $request, $storeId)
    {
        try {
            $discounts = $this->repository->getDiscountsByStoreId($storeId);
            $discounts = AllDiscountResource::collection($discounts);
            return response()->json([
                'status' => 200,
                'message' => __('Thực hiện thành công.'),
                'data' => $discounts
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
 * Chi tiết Discount theo store_id và discount_id
 *
 * Lấy chi tiết Discount theo store_id và discount_id
 *
 * @param  int  $storeId
 * @param  int  $discountId
 * @return \Illuminate\Http\Response
 */
public function getDiscountByStoreAndId($storeId, $discountId)
{
    try {
        $discount = $this->repository->getDiscountByStoreAndId($storeId, $discountId);
        if (!$discount) {
            return response()->json([
                'status' => 404,
                'message' => __('Không tìm thấy Discount.'),
            ]);
        }
        $discount = new ShowDiscountResource($discount);
        return response()->json([
            'status' => 200,
            'message' => __('Thực hiện thành công.'),
            'data' => $discount
        ]);
    } catch (\Exception $e) {
        Log::error('Error in DiscountController@getDiscountByStoreAndId: ' . $e->getMessage());
        return response()->json([
            'status' => 500,
            'message' => __('Thực hiện thất bại.')
        ]);
    }
}

     /**
     * Danh sách Discount theo user_id
     *
     * Lấy danh sách tất cả Discount theo user_id
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getByUser(Request $request, $userId)
    {
        try {
            $discounts = $this->repository->getDiscountsByUserId($userId);
            $discounts = AllDiscountResource::collection($discounts);
            return response()->json([
                'status' => 200,
                'message' => __('Thực hiện thành công.'),
                'data' => $discounts
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
     * Danh sách Discount theo driver_id
     *
     * Lấy danh sách tất cả Discount theo driver_id
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getByDriver(Request $request, $driverId)
    {
        try {
            $discounts = $this->repository->getDiscountsByDriverId($driverId);
            $discounts = AllDiscountResource::collection($discounts);
            return response()->json([
                'status' => 200,
                'message' => __('Thực hiện thành công.'),
                'data' => $discounts
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
     * Danh sách Discount theo product_id
     *
     * Lấy danh sách tất cả Discount theo product_id
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getByProduct(Request $request, $productId)
    {
        try {
            $page = $request->input('page', 1);
            $limit = $request->input('limit', 10);
            $discounts = $this->repository->getDiscountsByProductId($productId, $page, $limit);
            $discounts = AllDiscountResource::collection($discounts);
            return response()->json([
                'status' => 200,
                'message' => __('Thực hiện thành công.'),
                'data' => $discounts
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
