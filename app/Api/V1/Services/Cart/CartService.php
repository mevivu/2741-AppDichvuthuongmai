<?php

namespace App\Api\V1\Services\Cart;

use App\Api\V1\Repositories\Cart\CartRepositoryInterface;
use App\Api\V1\Repositories\CartItem\CartItemRepositoryInterface;
use App\Api\V1\Repositories\Discount\DiscountRepositoryInterface;
use App\Api\V1\Repositories\Setting\SettingRepositoryInterface;
use App\Api\V1\Repositories\Store\StoreRepositoryInterface;
use App\Models\Area;
use App\Models\CartItem;
use App\Models\Store;
use App\Traits\CalculationsTrait;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CartService implements CartServiceInterface
{
    use CalculationsTrait;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;

    protected $repository;

    protected $instance;
    private CartItemRepositoryInterface $cartItemRepository;
    private StoreRepositoryInterface $storeRepository;
    private SettingRepositoryInterface $settingRepository;

    private DiscountRepositoryInterface $discountRepository;


    public function __construct(CartRepositoryInterface     $repository,
                                StoreRepositoryInterface    $storeRepository,
                                SettingRepositoryInterface  $settingRepository,
                                DiscountRepositoryInterface $discountRepository,
                                CartItemRepositoryInterface $cartItemRepository)
    {
        $this->repository = $repository;
        $this->cartItemRepository = $cartItemRepository;
        $this->storeRepository = $storeRepository;
        $this->settingRepository = $settingRepository;
        $this->discountRepository = $discountRepository;
    }

    public function store(Request $request)
    {
        $data = $request->validated();
        return $this->repository->create($data);
    }


    public function update(Request $request)
    {

        $this->data = $request->validated();

        return $this->repository->update($this->data['id'], $this->data);

    }

    public function delete($id): object|bool
    {
        return $this->repository->delete($id);

    }

    public function getInstance()
    {
        return $this->instance;
    }


    /**
     * Retrieves cart items associated with a specific user, based on user input from a request.
     *
     * This function starts by validating the incoming request data to ensure it includes necessary parameters.
     * It allows for pagination by accepting 'page' and 'limit' parameters from the request. If these parameters
     * are not provided, it defaults to page 1 with a limit of 10 items per page.
     *
     * After extracting the user ID from the validated data, it queries the repository for carts associated with
     * this user. It then collects the IDs of these carts and uses them to fetch all related cart items.
     *
     * Finally, it paginates the results of cart items based on the specified 'limit' and 'page', and returns them.
     *
     * @param Request $request The incoming request containing the user ID and optionally the pagination parameters.
     * @return LengthAwarePaginator Returns a paginator instance containing the cart items.
     */
    public function getCartItemsByUserId(Request $request): LengthAwarePaginator
    {
        $data = $request->all();
        $user = $request->user();
        $page = $data['page'] ?? 1;
        $limit = $data['limit'] ?? 10;

        $carts = $this->repository->getBy(['user_id' => $user->id]);

        $cartIds = $carts->pluck('id');

        $allItemsQuery = CartItem::with('product.store')
            ->whereIn('cart_id', $cartIds);

        return $allItemsQuery->paginate($limit, ['*'], 'page', $page);
    }


    /**
     * @throws Exception
     */
    public function calculateTotal(Request $request): JsonResponse
    {
        $data = $request->validated();
        $points = $data['points'] ?? 0;
        $storeId = $data['store_id'];
        $cartItems = $this->cartItemRepository->getCartItemsByStoreId($storeId);

        $toppingIds = $cartItems->flatMap(function ($item) {
            return $item->toppings->pluck('id');
        })->unique()->values()->all();

        // Check for coordinates
        $lat = $data['coordinates']['lat'] ?? null;
        $lng = $data['coordinates']['lng'] ?? null;

        // Discount handling
        $discountCode = $data['discount_code'] ?? null;
        $discountValue = 0;
        $discountId = null;
        if (!empty($discountCode)) {
            $discount = $this->discountRepository->findByField("code", $discountCode)->first();
            if ($discount) {
                $discountValue = $discount->discount_value;
                $discountId = $discount->id;
            }
        }

        // Determine area only if coordinates are provided
        $area = null;
        if ($lat !== null && $lng !== null) {
            $area = $this->getArea($lat, $lng);
        }

        $store = $this->getStore($cartItems);

        $subTotal = $this->calculateSubTotal($cartItems);

        // Calculate transport fee only if coordinates are provided
        $transportFee = ['fee' => 0, 'distance' => 0];
        if ($lat !== null && $lng !== null) {
            $transportFee = $this->calculateTransportFee($store, $lat, $lng, $area);
        }

        $total = $this->calculateTotalAmount($subTotal, $transportFee) - $discountValue - $points;

        return response()->json([
            'sub_total' => $subTotal,
            'transport_fee' => $transportFee,
            'total' => $total,
            "discount_value" => $discountValue,
            'discount_id' => $discountId,
            'toppingIds' => $toppingIds,
            'points' => $points
        ]);
    }


    /**
     * Tính toán phí vận chuyển dựa trên tọa độ và khu vực.
     *
     * @param Store $store
     * @param float $lat Vĩ độ của địa điểm giao hàng.
     * @param float $lng Kinh độ của địa điểm giao hàng.
     * @param Area $area Đối tượng khu vực đã được lấy từ cơ sở dữ liệu.
     * @return array Trả về một mảng chứa phí vận chuyển ('fee') và khoảng cách ('distance'). Nếu không thể tính toán được, trả về phí là 0.
     * @throws Exception Ngoại lệ được ném ra nếu không tìm thấy cửa hàng hoặc có lỗi trong tính toán khoảng cách.
     */
    private function calculateTransportFee(Store $store, float $lat, float $lng, Area $area): array
    {
        if ($lat && $lng) {
            $distance = calculateDistanceGoogleAPi($store->lat, $store->lng, $lat, $lng);
            $pricePerKm = $area->shipping_fee;
            $transportFee = round($distance * $pricePerKm, 1);
            return ['fee' => $transportFee, 'distance' => $distance];
        }
        return ['fee' => 0, 'distance' => 0];
    }


    /**
     * Tính toán tổng số tiền cần thanh toán dựa trên tổng tiền hàng và phí vận chuyển.
     *
     * @param float $subTotal Tổng tiền hàng, đã được tính toán trước đó.
     * @param array $transportFee Mảng chứa thông tin phí vận chuyển, bao gồm cả phí đã được tính toán.
     *
     * @return float Trả về tổng số tiền cuối cùng cần thanh toán.
     */
    private function calculateTotalAmount(float $subTotal, array $transportFee): float
    {
        return $subTotal + $transportFee['fee'];
    }


    /**
     * Lấy thông tin cửa hàng dựa trên thông tin sản phẩm trong các mặt hàng giỏ hàng.
     *
     * @param Collection $cartItems Collection của các mặt hàng trong giỏ hàng.
     * @return Store Trả về đối tượng cửa hàng tương ứng với ID đã truy xuất.
     * @throws Exception Ngoại lệ được ném ra nếu không tìm thấy cửa hàng với ID đã cho.
     *
     */
    private function getStore(Collection $cartItems): Store
    {
        $storeId = $cartItems->first()->product->store->id;
        return $this->storeRepository->findOrFail($storeId);
    }


}
