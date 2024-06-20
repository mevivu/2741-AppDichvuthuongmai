<?php

namespace App\Admin\Services\Order;

use App\Admin\Repositories\Admin\AdminRepositoryInterface;
use App\Admin\Repositories\Area\AreaRepositoryInterface;
use App\Admin\Repositories\Notification\NotificationRepositoryInterface;
use App\Admin\Repositories\Order\OrderRepositoryInterface;
use App\Admin\Repositories\Setting\SettingRepositoryInterface;
use App\Admin\Repositories\Store\StoreRepositoryInterface;
use App\Admin\Repositories\User\UserRepositoryInterface;
use App\Admin\Repositories\Driver\DriverRepositoryInterface;
use App\Admin\Repositories\Order\OrderItemRepositoryInterface;
use App\Admin\Repositories\Product\ProductRepositoryInterface;
use App\Enums\Driver\AutoAccept;
use App\Enums\Driver\DriverAssignmentType;
use App\Enums\Driver\DriverStatus;
use App\Enums\Driver\DriverTransactionStatus;
use App\Enums\Order\OrderStatus;
use App\Traits\CalculationsTrait;
use App\Traits\HandlesNotifications;
use App\Traits\NotifiesViaFirebase;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderService implements OrderServiceInterface
{
    use NotifiesViaFirebase, HandlesNotifications, CalculationsTrait;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;

    protected $repository;

    protected StoreRepositoryInterface $storeRepository;

    protected DriverRepositoryInterface $userDriverRepository;
    protected ProductRepositoryInterface $productRepository;

    protected OrderItemRepositoryInterface $orderItemRepository;
    private NotificationRepositoryInterface $notificationRepository;
    private UserRepositoryInterface $userRepository;
    private AdminRepositoryInterface $adminRepository;
    private SettingRepositoryInterface $settingRepository;
    private AreaRepositoryInterface $areaRepository;


    public function __construct(OrderRepositoryInterface        $repository,
                                DriverRepositoryInterface   $userDriverRepository,
                                StoreRepositoryInterface        $storeRepository,
                                OrderItemRepositoryInterface    $orderItemRepository,
                                NotificationRepositoryInterface $notificationRepository,
                                UserRepositoryInterface         $userRepository,
                                AdminRepositoryInterface        $adminRepository,
                                SettingRepositoryInterface      $settingRepository,
                                AreaRepositoryInterface         $areaRepository,
                                ProductRepositoryInterface      $productRepository)
    {
        $this->repository = $repository;
        $this->storeRepository = $storeRepository;
        $this->userDriverRepository = $userDriverRepository;
        $this->orderItemRepository = $orderItemRepository;
        $this->productRepository = $productRepository;
        $this->notificationRepository = $notificationRepository;
        $this->userRepository = $userRepository;
        $this->adminRepository = $adminRepository;
        $this->settingRepository = $settingRepository;
        $this->areaRepository = $areaRepository;


    }


    /**
     * @throws Exception
     */
    public function getInformationOrder(Request $request): JsonResponse
    {
        $data = $request->validated();
        $systemCommissionRate = $this->settingRepository
            ->getBy(['setting_key' => 'system_commission_rate']);
        $lat = $data['coordinates']['lat'] ?? null;
        $lng = $data['coordinates']['lng'] ?? null;
        // Lấy khu vực trong toạ độ giao hàng
        $area = $this->getArea($lat, $lng);
        $pricePerKm = $area->shipping_fee;


        $distanceKm = (float)str_replace(',',
            '.', str_replace(' km', '', $data['distance']));
        $price = $data['sub_total'];

        $shippingPrice = $distanceKm * $pricePerKm;

        $totalPrice = $price + $shippingPrice;
        // Hoa hồng hệ thống
        $systemRevenue = $totalPrice * $systemCommissionRate[0]->plain_value;

        return response()->json([
            'sub_total' => $price,
            'distance' => $data['distance'],
            'transport_fee' => $shippingPrice,
            'totalPrice' => $totalPrice,
            'systemRevenue' => $systemRevenue,

        ]);
    }


    /**
     * @throws Exception
     */
    public function store(Request $request)
    {
        $data = $request->validated();
        $uniqueCode = uniqid_real();
        $data['code'] = $uniqueCode;
        $data['shipping_address'] = $data['pickup_address'];

        // Auto-assign
            if (isset($data['driver_assignment']) && $data['driver_assignment'] == DriverAssignmentType::Auto->value) {
                $store = $this->storeRepository->findOrFail($data['store_id']);

            // tài xế chưa nhận đơn và tài xế bật chế độ tự nhận đơn
            $drivers = $this->userDriverRepository->getBy([
                'auto_accept' => AutoAccept::Auto,
                'order_accepted' => DriverStatus::NotReceived
            ]);

//            $closestDriver = $this->findClosestDriver($store->lat, $store->lng, $drivers);

//            if ($closestDriver) {
//                $data['driver_id'] = $closestDriver->id;
//            }
        }

        return $this->repository->create($data);
    }


    /**
     * @throws Exception
     */
    public function update(Request $request): object|bool
    {
        $data = $request->validated();
        $data['lat'] = $data['coordinates']['lat'];
        $data['lng'] = $data['coordinates']['lng'];
        unset($data['coordinates']);
        $oder = $this->repository->findOrFail($data['id']);
        if (isset($data['driver_id'])) {
            $this->notifyDriver($data['driver_id'], $oder);
            $data['status'] = OrderStatus::PendingDriverConfirmation;
        }

        return $this->repository->update($data['id'], $data);
    }

    /**
     * @throws Exception
     */
    public function updateStore(Request $request): object
    {

        $this->data = $request->validated();
        return $this->repository->update($request['id'], $this->data);
    }

    /**
     * @throws Exception
     */
    public function delete($id): object|bool
    {
        return $this->repository->delete($id);
    }

    /**
     * @throws Exception
     */
    public function updateOrder($id): object
    {
        DB::beginTransaction();

        try {
            $order = $this->repository->findOrFail($id);
            $data = [
                'id' => $id,
                'status' => OrderStatus::PendingDriverConfirmation
            ];

            $result = $this->orderItemRepository->getitem($id);
            $this->productRepository->updateQty($result);

            $driverId = $order->driver_id;
            // In case there is a driver
            if (!$driverId) {
                $store = $this->storeRepository->findOrFail($order->store_id);
                $driverId = $this->assignDriver($store, $order);
                if ($driverId) {
                    $data['driver_id'] = $driverId;
                } else {
                    $this->sendNotificationsToAdmins(config('notifications.driver_unavailable.title'),
                        config('notifications.driver_unavailable.message'));
                    $admins = $this->adminRepository->getAll();
                    foreach ($admins as $admin) {
                        $this->createNotification($admin, $order, 'admin_id', 'driver_unavailable');
                    }
                    $data['status'] = OrderStatus::DriverUnavailable;

                }
            } else {
                $this->notifyDriver($driverId, $order);
            }

            $this->repository->update($data['id'], $data);
            DB::commit();
            return $this->repository->find($id);
        } catch (Exception $e) {
            DB::rollback();
            Log::error("Failed to update the order {$id}. Error: " . $e->getMessage());
            throw new Exception("Failed to update the order: " . $e->getMessage());
        }
    }


    protected function assignDriver($store, $order)
    {
        $customerId = $order->user_id;
        //The driver turned on the automatic trip recognition mode and the status was not received
        $drivers = $this->userDriverRepository->getBy([
            'auto_accept' => AutoAccept::Auto,
            'order_accepted' => DriverStatus::NotReceived,
            ['user_id', '!=', $customerId],
            ['current_lat', '!=', null],
            ['current_lng', '!=', null],
            ['current_address', '!=', null]
        ]);
        $closestDriver = find_closest_driver($store->lat, $store->lng, $drivers);

        if ($closestDriver) {
            $this->userDriverRepository->updateAttribute($closestDriver->id, 'order_accepted', DriverStatus::PendingConfirmation);
            $this->sendFirebaseNotification(
                [$closestDriver->user->device_token],
                null,
                config('notifications.new_order.title'),
                config('notifications.new_order.message')
            );
            $this->createNotification($closestDriver, $order, 'driver_id', 'new_order');
            return $closestDriver->id;
        }
        return null;
    }

    /**
     * @throws Exception
     */
    protected function notifyDriver($driverId, $order): void
    {
        $driver = $this->userDriverRepository->findOrFail($driverId);
        if ($driver && $driver->user && $driver->user->device_token) {
            $this->sendFirebaseNotification(
                [$driver->user->device_token],
                null,
                config('notifications.new_order.title'),
                config('notifications.new_order.message')
            );
            $this->createNotification($driver, $order, 'driver_id', 'new_order');
        }
    }


    /**
     * @throws Exception
     */
    public function updateOrderRefuse($id): object
    {
        DB::beginTransaction();

        try {
            $order = $this->repository->findOrFail($id);
            $data = ['id' => $id, 'status' => OrderStatus::Cancelled];
            $this->repository->update($data['id'], $data);
            $customer = $this->userRepository->findOrFail($order->customer_id);
            $customerDeviceToken = $customer->device_token;
            if ($customer) {
                $this->sendFirebaseNotification(
                    [$customerDeviceToken],
                    null,
                    config('notifications.order_cancelled.title'),
                    config('notifications.order_cancelled.message')
                );
            }
            $this->createNotification($customer, $order, 'user_id', 'order_cancelled');

            DB::commit();
            return $this->repository->find($id);
        } catch (Exception $e) {
            DB::rollback();
            Log::error("Failed to update and notify order refusal {$id}. Error: " . $e->getMessage());
            throw new Exception("Failed to update and notify order refusal: " . $e->getMessage());
        }
    }

    public function getLateOrders(int $minutes): Collection
    {
        $timeAgo = Carbon::now()->subMinutes($minutes);

        return DB::table('orders as o')
            ->leftJoin('driver_transactions as t', function ($join) use ($minutes) {
                $join->on('o.id', '=', 't.order_id')
                    ->where('t.created_at', '>', DB::raw('o.completed_at'))
                    ->where('t.created_at', '<=', DB::raw('DATE_ADD(o.completed_at, INTERVAL ' . $minutes . ' MINUTE)'))
                    ->where('t.status', '=', DriverTransactionStatus::Pending);
            })
            ->where('o.status', OrderStatus::Completed)
            ->where('o.completed_at', '<=', $timeAgo)
            ->groupBy('o.id', 'o.completed_at', 'o.driver_id')
            ->havingRaw('COUNT(t.id) = 0')
            ->select('o.id', 'o.completed_at', 'o.driver_id')
            ->get();
    }

}
