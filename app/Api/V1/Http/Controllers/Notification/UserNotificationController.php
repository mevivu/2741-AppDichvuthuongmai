<?php

namespace App\Api\V1\Http\Controllers\Notification;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Repositories\Driver\DriverRepositoryInterface;
use App\Admin\Repositories\Nany\NanyRepositoryInterface;
use App\Api\V1\Http\Resources\Notification\NotificationResource;
use App\Api\V1\Http\Resources\Notification\NotificationDetailResource;
use App\Api\V1\Repositories\Notification\NotificationRepositoryInterface;
use App\Api\V1\Repositories\User\UserRepositoryInterface;
use App\Api\V1\Services\Notification\NotificationServiceInterface;
use App\Api\V1\Support\AuthServiceApi;
use App\Api\V1\Validate\Validator;
use App\Enums\Notification\NotificationStatus;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @group Thông báo
 */
class UserNotificationController extends Controller
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
        $this->middleware('auth:api', ['except' => ['show', 'updateStatusRead']]);
    }


    /**
     * Lấy chi tiết thông báo.
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
     *      "data": {
     *              "id": 5,
     *              "title": "TEST",
     *              "message": "TEST",
     *              "status": 1,
     *              "created_at": "2024-06-27T03:49:29.000000Z"
     *       }
     * }
     *
     * @response 404 {
     *      "status": 404,
     *      "message": "Not found"
     * }
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $note = $this->notiRepository->find($id);
        if ($note) {
            $note->markAsRead($id);
        }

        if (!$note) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => __('notifySuccess'),
            'data' => new NotificationDetailResource($note),
        ]);
    }

    /**
     * Lấy danh sách thông báo của tài xế.
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
    public function getDriverNotifications(): JsonResponse
    {
        $driverId = $this->getCurrentDriverId();

        $notifications = $this->notiRepository->getNotificationById('driver_id', $driverId);
        if (!$notifications) {
            return response()->json(['message' => __('Bạn không có quyền truy cập')], 403);
        }

        return response()->json([
            'status' => 200,
            'message' => __('notifySuccess'),
            'data' => new NotificationResource($notifications),
        ]);
    }

    /**
     * Lấy danh sách thông báo của khách hàng.
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
     *              "id": 24,
     *              "title": "Xoá Phòng",
     *              "message": "Xoá Phòng",
     *              "status": 1,
     *              "created_at": "2024-06-27T03:52:53.000000Z"
     *          },
     *          {
     *              "id": 30,
     *              "title": "Thêm Phòng",
     *              "message": "Thêm Phòng",
     *              "status": 1,
     *              "created_at": "2024-06-27T04:14:29.000000Z"
     *          }
     *      ]
     * }
     *
     * @response 403 {
     *      "status": 403,
     *      "message": "Bạn không có quyền truy cập"
     * }
     *
     * @return JsonResponse
     */
    public function getUserNotifications(): JsonResponse
    {
        $userId = $this->getCurrentUserId();
        $notifications = $this->notiRepository->getNotificationById('user_id', $userId);
        if (!$notifications) {
            return response()->json(['message' => __('Bạn không có quyền truy cập')], 403);
        }

        return response()->json([
            'status' => 200,
            'message' => __('notifySuccess'),
            'data' => new NotificationResource($notifications),
        ]);
    }

    /**
     * Cập nhật trạng thái đã đọc của thông báo.
     *
     * Trạng thái của thông báo (status):
     * - 1: Chưa đọc
     * - 2: Đã đọc
     *
     * @authenticated
     * Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     * @pathParam id integer required ID của thông báo. Phải tồn tại trong bảng `notifications`. Example: 1
     *
     * @response 200 {
     *      "status": 200,
     *      "message": "notifySuccess",
     * }
     *
     * @response 403 {
     *      "status": 403,
     *      "message": "Bạn không có quyền truy cập"
     * }
     *
     * @param int $id
     * @return JsonResponse
     */
    public function updateStatusRead(int $id): JsonResponse
    {
        if (Validator::validateExists($this->notiRepository, $id)) {
            $this->notiRepository->update($id, ['status' => NotificationStatus::NOT_READ]);
            return response()->json([
                'status' => 200,
                'message' => __('notifySuccess'),
            ]);
        }
        return response()->json([
            'status' => 404,
            'message' => 'No notifications found for this user.'
        ], 404);
    }

}
