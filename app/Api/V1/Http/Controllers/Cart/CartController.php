<?php

namespace App\Api\V1\Http\Controllers\Cart;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\Cart\CartItemRequest;
use App\Api\V1\Http\Requests\Cart\CartRequest;
use App\Api\V1\Http\Resources\Cart\CartResourceCollection;
use App\Api\V1\Repositories\Cart\CartRepositoryInterface;
use App\Api\V1\Services\Cart\CartServiceInterface;
use App\Api\V1\Services\CartItem\CartItemServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Giỏ hàng
 */
class CartController extends Controller
{
    private CartItemServiceInterface $cartItemService;

    public function __construct(
        CartRepositoryInterface  $repository,
        CartServiceInterface     $service,
        CartItemServiceInterface $cartItemService,
    )
    {
        $this->repository = $repository;
        $this->service = $service;
        $this->cartItemService = $cartItemService;
    }

    /**
     *
     * Tính toán tổng chi phí từ giỏ hàng.
     *
     * @authenticated
     * Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     * @bodyParam store_id float required id của cửa hàng. Example: 1
     * @bodyParam lat float  Vĩ độ điểm giao hàng. Example: 10.8275553
     * @bodyParam lng float  Kinh độ điểm giao hàng. Example: 106.7214274
     * @bodyParam discount_code string optional Mã giảm giá. Example: UUUUUU
     * @bodyParam points float  Điểm. Example: 2000
     *
     * @response 200 {
     *      "sub_total": 120000,
     *      "transport_fee": {
     *          "fee": 80400,
     *          "distance": 6.7
     *      },
     *      "total": 200400,
     *      "discount_value": 0,
     *      "discount_id": null,
     *      "toppingIds": [
     *          3,
     *          13
     *      ]
     * }
     *
     * @response 400 {
     *      "status": 400,
     *      "message": "Calculation failed.",
     *      "errors": {
     *          "cart_id": [
     *              "The selected cart_id is invalid."
     *          ],
     *          "cart_item_ids": [
     *              "The selected cart_item_ids are invalid."
     *          ]
     *      }
     * }
     *
     * @param CartItemRequest $request
     * @return JsonResponse
     */
    public function calculateTotal(CartItemRequest $request): JsonResponse
    {
        return $this->service->calculateTotal($request);
    }

    /**
     * Tạo một item mới trong giỏ hàng của người dùng.
     *
     * @authenticated
     * Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     * @bodyParam product_id integer required ID của sản phẩm. Phải tồn tại trong bảng `products`. Example: 1
     * @bodyParam qty integer required Số lượng sản phẩm. Phải là số nguyên và lớn hơn hoặc bằng 1. Example: 1
     * @bodyParam topping_id[].qty integer required Số lượng của topping. Example: 1
     * @bodyParam topping_id[].id integer required ID của topping. Example: 13
     * @bodyParam topping_id[].qty integer required Số lượng của topping. Example: 1     *
     * @response 200 {
     *      "status": 200,
     *      "message": "Cart created successfully.",
     *      "data": {
     *          "product_id": 1,
     *          "cart_id": 1,
     *          "qty": 1,
     *          "topping_ids": [
     *              {
     *                  "id": 3,
     *                  "quantity": 1
     *              },
     *              {
     *                  "id": 13,
     *                  "quantity": 2
     *              }
     *          ]
     *      }
     * }
     *
     * @response 400 {
     *      "status": 400,
     *      "message": "Cart creation failed.",
     *      "errors": {
     *          "product_id": [
     *              "The selected product_id is invalid."
     *          ],
     *          "cart_id": [
     *              "The selected cart_id is invalid."
     *          ]
     *      }
     * }
     *
     * @param CartRequest $request
     * @return JsonResponse
     */
    public function store(CartRequest $request): JsonResponse
    {
        $cart = $this->cartItemService->store($request);

        return response()->json([
            'status' => 200,
            'message' => __('Cart created successfully.'),
            'data' => $cart
        ]);
    }

    /**
     * Cập nhật thông tin item trong giỏ hàng của người dùng.
     *
     * @authenticated
     * Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     * @bodyParam id integer required ID của item trong giỏ hàng. Example: 1
     * @bodyParam qty integer required Số lượng sản phẩm. Phải là số nguyên và lớn hơn hoặc bằng 1. Example: 4
     *
     * @response 200 {
     *      "status": 200,
     *      "message": "Cart updated successfully.",
     *      "data": {
     *          "id": 1,
     *          "qty": 4
     *      }
     * }
     *
     * @response 400 {
     *      "status": 400,
     *      "message": "Cart update failed.",
     *      "errors": {
     *          "id": [
     *              "The selected id is invalid."
     *          ]
     *      }
     * }
     *
     * @param CartRequest $request
     * @return JsonResponse
     */
    public function update(CartRequest $request): JsonResponse
    {
        $cart = $this->cartItemService->update($request);

        return response()->json([
            'status' => 200,
            'message' => __('Cart updated successfully.'),
            'data' => $cart
        ]);
    }

    /**
     * Lấy thông tin các item trong giỏ hàng của người dùng.
     *
     * @authenticated
     * Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     * @queryParam page integer required Trang hiện tại của kết quả phân trang. Example: 1
     * @queryParam limit integer optional Số lượng kết quả trên mỗi trang. Mặc định là 10. Example: 10
     *
     * @response 200 {
     *      "status": 200,
     *      "message": "notifySuccess",
     *      "data": [
     *          {
     *              "id": 1,
     *              "product_id": 101,
     *              "quantity": 2,
     *              "price": 100.0,
     *              "created_at": "2024-06-03T12:34:56.000000Z",
     *              "updated_at": "2024-06-03T12:34:56.000000Z"
     *          },
     *          ...
     *      ]
     * }
     *
     * @response 400 {
     *      "status": 400,
     *      "message": "notifyError",
     *      "errors": {
     *          "user_id": [
     *              "The selected user_id is invalid."
     *          ]
     *      }
     * }
     *
     * @param CartRequest $request
     * @return JsonResponse
     */
    public function show(Request $request): JsonResponse
    {
        $cartItems = $this->service->getCartItemsByUserId($request);

        return response()->json([
            'status' => 200,
            'message' => __('notifySuccess'),
            'data' => new CartResourceCollection($cartItems)
        ]);
    }

    /**
     * Xóa một item trong giỏ hàng của người dùng.
     *
     * @authenticated
     * Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     * @queryParam id integer required ID của item trong giỏ hàng. Example: 1
     *
     * @response 200 {
     *      "status": 200,
     *      "message": "notifySuccess",
     *      "data": []
     * }
     *
     * @response 400 {
     *      "status": 400,
     *      "message": "notifyError",
     *      "errors": {
     *          "id": [
     *              "The selected id is invalid."
     *          ]
     *      }
     * }
     *
     * @param CartRequest $request
     * @return JsonResponse
     */
    public function delete(CartRequest $request): JsonResponse
    {
        $this->cartItemService->delete($request['id']);
        return response()->json([
            'status' => 200,
            'message' => __('notifySuccess'),
            'data' => []
        ]);
    }

}
