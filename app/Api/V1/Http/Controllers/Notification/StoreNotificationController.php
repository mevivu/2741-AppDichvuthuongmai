<?php

namespace App\Api\V1\Http\Controllers\Notification;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Repositories\Driver\DriverRepositoryInterface;
use App\Api\V1\Http\Resources\Notification\NotificationResource;
use App\Api\V1\Repositories\Notification\NotificationRepositoryInterface;
use App\Api\V1\Repositories\User\UserRepositoryInterface;
use App\Api\V1\Services\Notification\NotificationServiceInterface;
use App\Api\V1\Support\AuthServiceApi;
use Illuminate\Http\JsonResponse;

/**
 * @group Thông báo
 */
class StoreNotificationController extends Controller
{
    use AuthServiceApi;

    protected NotificationRepositoryInterface $notiRepository;
    protected UserRepositoryInterface $userRepository;
    protected DriverRepositoryInterface $driverRepository;

    public function __construct(
        NotificationRepositoryInterface $repository,
        NotificationServiceInterface    $service,
        UserRepositoryInterface         $userRepository,
        DriverRepositoryInterface $driverRepository,

    )
    {
        $this->notiRepository = $repository;
        $this->service = $service;
        $this->userRepository = $userRepository;
        $this->driverRepository = $driverRepository;
        $this->middleware('auth:store-api');
    }

    /**
     * Lấy danh sách thông báo của cửa hàng.
     *
     * Trạng thái của thông báo (status):
     * - 1: Chưa đọc
     * - 2: Đã đọc
     *
     * @authenticated
     * Example: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvMjczNi1BcHBEdWFSdW9jL2FwaS92MS9hdXRoL2xvZ2luIiwiaWF0IjoxNzE5NDU0ODM5LCJleHAiOjE3MjQ2Mzg4MzksIm5iZiI6MTcxOTQ1NDgzOSwianRpIjoiZG5NWXE4d2dWTWFkOFNCdiIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.uGA0ylhxwMxq8zBOsDEmSGrE97LHQxSn811jl3BLrK4
     *
     * @response 200 {
     *      "status": 200,
     *      "message": "notifySuccess",
     *      "data": [
     *          {
     *              "id": 5,
     *              "title": "TEST",
     *              "message": "TEST",
     *              "status": 1,
     *              "created_at": "2024-06-27T03:49:29.000000Z"
     *          },
     *          {
     *              "id": 11,
     *              "title": "Xoá Phòng",
     *              "message": "Xoá Phòng",
     *              "status": 1,
     *              "created_at": "2024-06-27T03:52:07.000000Z"
     *          }
     *      ]
     * }
     *
     * @response 404 {
     *      "status": 404,
     *      "message": "No notifications found for this driver"
     * }
     *
     * @return JsonResponse
     */
    public function getStoreNotifications(): JsonResponse
    {
        $storeId = $this->getCurrentStoreId();
        $notifications = $this->notiRepository->getNotificationById('store_id', $storeId);

        if ($notifications->isEmpty()) {
            return response()->json(['message' => 'No notifications found for this driver'], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => __('notifySuccess'),
            'data' => new NotificationResource($notifications),
        ]);
    }
}
