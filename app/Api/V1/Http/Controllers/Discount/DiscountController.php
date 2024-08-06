<?php

namespace App\Api\V1\Http\Controllers\Discount;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Resources\Discount\{AllDiscountResource, ShowDiscountResource};
use App\Api\V1\Repositories\Discount\DiscountRepositoryInterface;
use Illuminate\Http\Request;
use App\Api\V1\Http\Requests\Discount\DiscountRequest;
// use App\Api\V1\Http\Controllers\Discount\Driver;
use App\Models\Driver;
use Illuminate\Support\Facades\Log;

/**
 * @group Voucher
 */
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
    * @authenticated Authorization string required 
    * access_token được cấp sau khi đăng nhập. Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
    *
    * @pathParam storeId int required ID của sản phẩm. Example: 1
    * @pathParam discountId int required ID của sản phẩm. Example: 1
    *
    * @response 200 {
    *     "status": 200,
    *     "message": "Thực hiện thành công.",
    *     "data": [
    *         {
    *             "id": 3,
    *             "code": "sssssss",
    *             "date_start": "2024-07-07T23:06:23.000000Z",
    *             "date_end": "2024-07-07T23:06:23.000000Z",
    *             "max_usage": null,
    *             "min_order_amount": null,
    *             "type": 0,
    *             "discount_value": 40,
    *             "status": 1
    *         }
    *     ]
    * }
    * @headersParam X-TOKEN-ACCESS string
    * token để lấy dữ liệu. Ví dụ: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
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
     * 
     * @authenticated Authorization string required 
     * access_token được cấp sau khi đăng nhập. Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Ví dụ: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     * 
     * @response 200 {
     *     "status": 200,
     *     "message": "Thực hiện thành công.",
     *     "data": [
     *         {
     *             "id": 3,
     *             "code": "sssssss",
     *             "date_start": "2024-07-07T23:06:23.000000Z",
     *             "date_end": "2024-07-07T23:06:23.000000Z",
     *             "max_usage": null,
     *             "min_order_amount": null,
     *             "type": 0,
     *             "discount_value": 40,
     *             "status": 1
     *         }
     *     ]
     * }
     * 
     * @param  \App\Api\V1\Http\Requests\Discount\DiscountRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function getByUser(DiscountRequest $request)
    {
        try {
            $data = $request->validated();

            $userId = $request->user()->id;

            
           
            $discounts = $this->repository->getDiscountsByUserId($userId, ...$data);

            // Chuyển đổi các discount thành tài nguyên JSON
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

    /**
     * Danh sách Discount theo driver_id
     *
     * Lấy danh sách tất cả Discount theo driver_id
     * 
     * 
     * @authenticated Authorization string required 
     * access_token được cấp sau khi đăng nhập. Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Ví dụ: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     * 
     * @response 200 {
     *    "status": 200,
     *    "message": "Thực hiện thành công.",
     *    "data": [
     *        {
     *            "id": 2,
     *            "code": "ss2123",
     *            "date_start": "2024-07-07T23:01:02.000000Z",
     *            "date_end": "2024-07-07T23:01:02.000000Z",
     *            "max_usage": null,
     *            "min_order_amount": null,
     *            "type": 0,
     *            "discount_value": 35,
     *            "status": 1
     *        }
     *    ]
     * }
     * 
     * @param  \App\Api\V1\Http\Requests\Discount\DiscountRequest  $request
     * @return \Illuminate\Http\Response
     */

    public function getByDriver(DiscountRequest $request)
    {
        try {
            $userId = $request->user()->id;
    
            Log::info('User ID in Controller:', ['userId' => $userId]);
    
            $driver = Driver::where('user_id', $userId)->first();
    
            if (!$driver) {
                return response()->json([
                    'status' => 404,
                    'message' => __('Không tìm thấy tài xế cho người dùng này.')
                ]);
            }
    
            $driverId = $driver->id;
    
            $data = $request->validated();
            $discounts = $this->repository->getDiscountsByDriverId($driverId, ...$data);
    
            $discounts = AllDiscountResource::collection($discounts);
    
            if ($discounts->isEmpty()) {
                return response()->json([
                    'status' => 404,
                    'message' => __('Không có voucher nào cho tài xế này.')
                ]);
            }
    
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
    
    


    
   /**
    * Danh sách Discount theo product_id
    *
    * Lấy danh sách tất cả Discount theo product_id
    * 
    * @authenticated Authorization string required 
    * access_token được cấp sau khi đăng nhập. Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
    *
    * @headersParam X-TOKEN-ACCESS string
    * token để lấy dữ liệu. Ví dụ: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
    * 
    * @pathParam productId int required ID của sản phẩm. Example: 1
    * 
    * @response 200 {
    *   "status": 200,
    *   "message": "Thực hiện thành công.",
    *   "data": [
    *     {
    *       "id": 2,
    *       "code": "ss2123",
    *       "date_start": "2024-07-07T23:01:02.000000Z",
    *       "date_end": "2024-07-07T23:01:02.000000Z",
    *       "max_usage": null,
    *       "min_order_amount": null,
    *       "type": 0,
    *       "discount_value": 35,
    *       "status": 1
    *     }
    *   ]
    * }
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    public function getByProduct(DiscountRequest $request, $productId)
    {
        try {
            $data = $request->validated();
            $discounts = $this->repository->getDiscountsByProductId($productId, ...$data); 
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
