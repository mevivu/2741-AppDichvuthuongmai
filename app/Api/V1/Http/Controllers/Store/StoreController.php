<?php

namespace App\Api\V1\Http\Controllers\Store;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Repositories\Store\StoreRepositoryInterface;
use App\Api\V1\Http\Requests\Auth\LoginRequest as AuthLoginRequest;
use App\Api\V1\Http\Requests\Store\RegisterRequest;
use App\Api\V1\Http\Requests\Store\UpdateRequest;
use App\Api\V1\Http\Resources\Store\StoreResource;
use Exception;
use Illuminate\Http\JsonResponse;
use App\Api\V1\Services\Store\StoreServiceInterface;
use App\Api\V1\Support\AuthServiceApi;
use App\Api\V1\Support\Response;
use App\Traits\JwtService;
use App\Traits\UseLog;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;

/**
 * @group Cửa hàng
 */
class StoreController extends Controller
{
    private static string $GUARD_API_STORE = 'store-api';
    private $login;

    protected $auth;

    use AuthServiceApi, Response, JwtService, UseLog;


    public function __construct(
        StoreServiceInterface    $service,
        StoreRepositoryInterface $repository
    ) {
        $this->service = $service;
        $this->repository = $repository;
        $this->middleware('auth:store-api', ['except' => ['login', 'register', 'sendOTP']]);
    }

    protected function resolve(): bool
    {
        $store = $this->repository->findByField('store_phone', $this->login['phone']);
        if ($store) {
            Auth::guard(self::$GUARD_API_STORE)->login($store);
            return true;
        }
        return false;
    }
    /**
     * Đăng nhập Cửa hàng
     *
     * API này dùng để đăng nhập cho cửa hàng
     *
     * @bodyParam phone string required
     * Username của người dùng. Example: 0961592551
     *
     * @response 200 {
     *     "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvMjc0MS1BcHBEaWNodnV0aHVvbmdtYWkvYXBpL3YxL2RyaXZlcnMvbG9naW4iLCJpYXQiOjE3MjEzODM2ODQsImV4cCI6MTcyNjU2NzY4NCwibmJmIjoxNzIxMzgzNjg0LCJqdGkiOiJwWnNJclVrSms2UHFzT0xrIiwic3ViIjoiOSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.En3WpOwOpKMTMHk4PmG799dZZ0DwfrH9HraimUqSU24",
     *     "refresh_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjo5LCJyYW5kb20iOiIxMzcwNzU5NTQxMTcyMTM4MzY4NCIsImlzX3JlZnJlc2hfdG9rZW4iOnRydWUsImV4cCI6MTcyMTkwOTI4NH0.abTovSfJmNOB_8ZqGpbNBFxwhGpue7OSEQgnbdPiVak",
     *     "role": "store",
     *     "expires_in": 5184000
     * }
     *
     * @response 401 {
     *     "status": 401,
     *     "message": "Thông tin đăng nhập chưa chính xác."
     * }
     *
     * @return JsonResponse
     */
    public function login(AuthLoginRequest $request): JsonResponse
    {
        try {
            return $this->loginStore($request);
        } catch (Exception $e) {
            $this->logError("Login failed", $e);
            return $this->jsonResponseError($e->getMessage(), 500);
        }
    }


    /**
     * Lấy thông tin Cửa hàng
     *
     * API này trả về thông tin chi tiết của Cửa hàng đã xác thực hiện tại
     * @authenticated
     *
     * Các trạng thái (status) của đơn hàng bao gồm:
     * - 1: Mở cửa
     * - 2: Đóng cửa
     *
     * Độ ưu tiên (priority) của đơn hàng bao gồm:
     * - 0: Không
     * - 1: Có
     *
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": {
     *          "id": 29,
     *          "category_id": 1,
     *          "area_id": 1,
     *          "code": "S9FDC71721960833",
     *          "slug": "my-store",
     *          "username": "0901234567",
     *          "store_name": "My Store",
     *          "store_phone": "0901234567",
     *          "contact_name": "My Store",
     *          "contact_email": "contact@example.com",
     *          "contact_phone": "0901234567",
     *          "logo": "public/uploads/images/stores//qDZjNjZ7gOQ7ZBpJAW7DTancFq61Wy4kQmHnFNp2.jpg",
     *          "address": "123 Main St",
     *          "address_detail": "123 Main St",
     *          "tax_code": "123456789",
     *          "open_hours_1": "08:00",
     *          "close_hours_1": "17:00",
     *          "open_hours_2": "18:00",
     *          "close_hours_2": "22:00",
     *          "status": 1,
     *          "priority": 0,
     *          "lng": 106.660172,
     *          "lat": 10.762622,
     *          "created_at": "2024-07-26T02:27:13.000000Z",
     *          "updated_at": "2024-07-26T02:27:13.000000Z",
     *          "roles": [
     *              "store"
     *          ]
     *      }
     * }
     *
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        $user = $this->getCurrentStoreUser();
        $data = new StoreResource($user);
        return $this->jsonResponseSuccess($data);
    }

    /**
     * Đăng ký Cửa hàng
     *
     * API này dùng để đăng ký cho cửa hàng
     *
     * @bodyParam category_id int required ID của danh mục cửa hàng (nếu có). Example: 1
     * @bodyParam area_id int required ID của khu vực (nếu có). Example: 2
     * @bodyParam store_name string required Tên cửa hàng. Example: Vios
     * @bodyParam store_phone string required Số điện thoại cửa hàng (theo định dạng Việt Nam). Example: 0987654321
     * @bodyParam contact_email string nullable Địa chỉ email liên hệ của cửa hàng. Example: store@example.com
     * @bodyParam logo file nullable Logo của cửa hàng. Example: file.png
     * @bodyParam address string nullable Địa chỉ cửa hàng. Example: 123 Đường ABC, Quận XYZ, Thành phố HCM
     * @bodyParam tax_code string nullable Mã số thuế của cửa hàng. Example: 1234567890
     * @bodyParam open_hours_1 string nullable Giờ mở cửa (lần 1) theo định dạng H:i. Example: 08:00
     * @bodyParam close_hours_1 string nullable Giờ đóng cửa (lần 1) theo định dạng H:i. Example: 18:00
     * @bodyParam open_hours_2 string nullable Giờ mở cửa (lần 2) theo định dạng H:i. Example: 20:00
     * @bodyParam close_hours_2 string nullable Giờ đóng cửa (lần 2) theo định dạng H:i. Example: 22:00
     * @bodyParam status string nullable Trạng thái của cửa hàng (1: Mở, 2: Đóng). Example: 1
     * @bodyParam priority int nullable Độ ưu tiên của cửa hàng (0: Không, 1: Có). Example: 1
     * @bodyParam lng float required Kinh độ của cửa hàng. Example: 106.7009
     * @bodyParam lat float required Vĩ độ của cửa hàng. Example: 10.762622
     *
     * @response 200 {
     *     "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvMjc0MS1BcHBEaWNodnV0aHVvbmdtYWkvYXBpL3YxL2RyaXZlcnMvbG9naW4iLCJpYXQiOjE3MjEzODM2ODQsImV4cCI6MTcyNjU2NzY4NCwibmJmIjoxNzIxMzgzNjg0LCJqdGkiOiJwWnNJclVrSms2UHFzT0xrIiwic3ViIjoiOSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.En3WpOwOpKMTMHk4PmG799dZZ0DwfrH9HraimUqSU24",
     *     "refresh_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjo5LCJyYW5kb20iOiIxMzcwNzU5NTQxMTcyMTM4MzY4NCIsImlzX3JlZnJlc2hfdG9rZW4iOnRydWUsImV4cCI6MTcyMTkwOTI4NH0.abTovSfJmNOB_8ZqGpbNBFxwhGpue7OSEQgnbdPiVak",
     *     "role": "store",
     *     "expires_in": 5184000
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
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $user = $this->service->store($request);

            $accessToken = JWTAuth::fromUser($user);
            $refreshToken = $this->createRefreshTokenById($user);

            return $this->respondWithToken($accessToken, $refreshToken, $user);
        } catch (Exception $e) {
            $this->logError('Registration Store Failed: ', $e);
            return $this->jsonResponseError($e->getMessage(), 500);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth(self::$GUARD_API_STORE)->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Cập nhật Cửa hàng
     *
     * API này dùng để cập nhật cho cửa hàng
     *
     * @bodyParam category_id int nullable ID của danh mục cửa hàng (nếu có). Example: 1
     * @bodyParam area_id int nullable ID của khu vực (nếu có). Example: 2
     * @bodyParam store_name string nullable Tên cửa hàng. Example: Vios
     * @bodyParam store_phone string nullable Số điện thoại cửa hàng (theo định dạng Việt Nam). Example: 0987654321
     * @bodyParam contact_email string nullable Địa chỉ email liên hệ của cửa hàng. Example: store@example.com
     * @bodyParam logo file nullable Logo của cửa hàng. Example: file.png
     * @bodyParam address string nullable Địa chỉ cửa hàng. Example: 123 Đường ABC, Quận XYZ, Thành phố HCM
     * @bodyParam tax_code string nullable Mã số thuế của cửa hàng. Example: 1234567890
     * @bodyParam open_hours_1 string nullable Giờ mở cửa (lần 1) theo định dạng H:i. Example: 08:00
     * @bodyParam close_hours_1 string nullable Giờ đóng cửa (lần 1) theo định dạng H:i. Example: 18:00
     * @bodyParam open_hours_2 string nullable Giờ mở cửa (lần 2) theo định dạng H:i. Example: 20:00
     * @bodyParam close_hours_2 string nullable Giờ đóng cửa (lần 2) theo định dạng H:i. Example: 22:00
     * @bodyParam status string nullable Trạng thái của cửa hàng (1: Mở, 2: Đóng). Example: 1
     * @bodyParam priority int nullable Độ ưu tiên của cửa hàng (0: Không, 1: Có). Example: 1
     * @bodyParam lng float nullable Kinh độ của cửa hàng. Example: 106.7009
     * @bodyParam lat float nullable Vĩ độ của cửa hàng. Example: 10.762622
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
     *     "message": "ERROR!!!",
     * }
     *
     * @return JsonResponse
     */
    public function update(UpdateRequest $request): JsonResponse
    {
        try {
            $this->service->update($request);
            return $this->jsonResponseSuccessNoData();
        } catch (Exception $e) {
            $this->logError('Update Store Failed: ', $e);
            return $this->jsonResponseError($e->getMessage(), 500);
        }
    }
}
