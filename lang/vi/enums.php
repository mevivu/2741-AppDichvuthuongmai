<?php

use App\Enums\Area\AreaStatus;
use App\Enums\DefaultStatus;
use App\Enums\Discount\DiscountType;
use App\Enums\Driver\AutoAccept;
use App\Enums\Driver\DriverAssignmentType;
use App\Enums\Driver\DriverStatus;
use App\Enums\Driver\DriverTransactionStatus;
use App\Enums\FeaturedStatus;
use App\Enums\Order\OrderStatus;
use App\Enums\Payment\PaymentMethod;
use App\Enums\PostCategory\PostCategoryStatus;
use App\Enums\Post\PostStatus;
use App\Enums\Module\ModuleStatus;
use App\Enums\Notification\NotificationOption;
use App\Enums\Notification\NotificationStatus;
use App\Enums\Notification\NotificationType;
use App\Enums\Order\OrderType;
use App\Enums\PriorityStatus;
use App\Enums\Store\StoreStatus;
use App\Enums\Vehicle\VehicleType;
use App\Enums\Product\{ProductInStock, ProductManagerStock, ProductStatus, ProductType, ProductVariationAction};
use App\Enums\Setting\SettingGroup;
use App\Enums\Slider\SliderStatus;
use App\Enums\Topping\ToppingStatus;
use App\Enums\User\{Gender, UserVip, UserRoles};
use App\Enums\Vehicle\VehicleStatus;

return [

    Gender::class => [
        Gender::Male->value => 'Nam',
        Gender::Female->value => 'Nữ',
        Gender::Other->value => 'Khác',
    ],
    NotificationStatus::class => [
        NotificationStatus::READ->value => 'Đã đọc',
        NotificationStatus::NOT_READ->value => 'Chưa đọc',
    ],
    NotificationOption::class => [
        NotificationOption::All->value => 'Cho tất cả',
        NotificationOption::One->value => 'Cho một người',
    ],
    NotificationType::class => [
        NotificationType::All->value => 'Thông báo tất cả',
        NotificationType::Driver->value => 'Thông báo tài xế',
        NotificationType::Store->value => 'Thông báo cửa hàng',
        NotificationType::Customer->value => 'Thông báo khách hàng',
    ],
    ProductStatus::class => [
        ProductStatus::Active->value => 'Đang hoạt động',
        ProductStatus::InActive->value => 'Ngưng hoạt động',
    ],
    ProductManagerStock::class => [
        ProductManagerStock::Managed->value => 'Có quản lý',
        ProductManagerStock::NotManaged->value => 'Không quản lý',
    ],
    ProductInStock::class => [
        ProductInStock::InStock->value => 'Còn hàng',
        ProductInStock::OutOfStock->value => 'Hết hàng',
    ],
    VehicleType::class => [
        VehicleType::Unclassified->value => 'Chưa được phân loại',
        VehicleType::Motorcycle->value => ' Xe gắn máy',
        VehicleType::Car->value => 'Ô tô',
        VehicleType::Truck->value => 'Xe tải',
        VehicleType::RefrigeratedRuck->value => 'Xe tải đông lạnh',
    ],
    AutoAccept::class => [
        AutoAccept::Auto->value => 'Tự động nhận chuyến',
        AutoAccept::Off->value => 'Tắt tự động nhận chuyến',
        AutoAccept::Locked->value => 'Khoá tự động nhận chuyến',
    ],
    DriverTransactionStatus::class => [
        DriverTransactionStatus::Pending->value => 'Chưa chuyển khoản',
        DriverTransactionStatus::Success->value => 'Đã chuyển',
//        DriverTransactionStatus::Late->value => 'Chuyển muộn',
    ],
    PaymentMethod::class => [
        PaymentMethod::Online->value => 'Online',
        PaymentMethod::Direct->value => 'Trực tiếp',
    ],
    DriverStatus::class => [
        DriverStatus::NotReceived->value => 'Đang chờ đơn',
        DriverStatus::Received->value => 'Đã nhận đơn',
        DriverStatus::InTransit->value => 'Đang chuyển đơn',
        DriverStatus::PendingConfirmation->value => 'Đang chờ xác nhận đơn',
    ],
    DriverAssignmentType::class => [
        DriverAssignmentType::Auto->value => 'Tự động',
        DriverAssignmentType::Manual->value => 'Thủ công',
    ],
    VehicleStatus::class => [
        VehicleStatus::Pending->value => 'Chờ xác nhận',
        VehicleStatus::Rented->value => 'Đã thuê',
        VehicleStatus::Inactive->value => 'Không hoạt động',
        VehicleStatus::UnderMaintenance->value => 'Đang bảo trì',
    ],
    UserVip::class => [
        UserVip::Default => 'Mặc định',
        UserVip::Bronze => 'Đồng',
        UserVip::Silver => 'Bạc',
        UserVip::Gold => 'Vàng',
        UserVip::Diamond => 'Kim cương',
    ],
    UserRoles::class => [
        UserRoles::Customer->value => 'Khách hàng',
        UserRoles::Driver->value => 'Tài xế',
    ],
    ProductType::class => [
        ProductType::Simple->value => 'Sản phẩm đơn giản',
        ProductType::Variable->value => 'Sản phẩm có biến thể'
    ],
    DefaultStatus::class => array(
        DefaultStatus::Published->value => 'Đã xuất bản',
        DefaultStatus::Draft->value => 'Bản nháp',
        DefaultStatus::Deleted->value => 'Đã xoá',
    ),
    AreaStatus::class => array(
        AreaStatus::On->value => 'Hoạt động',
        AreaStatus::Off->value => 'Không hoạt động'
    ),
    ProductVariationAction::class => [
        ProductVariationAction::AddSimple => 'Thêm biến thể',
        ProductVariationAction::AddFromAllVariations => 'Tạo biến thể từ tất cả thuộc tính'
    ],
    OrderStatus::class => [
        OrderStatus::Pending->value => 'Chờ xác nhận',
        OrderStatus::Confirmed->value => ' Đã xác nhận',
        OrderStatus::InTransit->value => 'Đang di chuyển',
        OrderStatus::ArrivedAtStore->value => 'Đã đến cửa hàng',
        OrderStatus::MovingToDestination->value => 'Đang di chuyển đến điểm đến',
        OrderStatus::Completed->value => 'Hoàn thành',
        OrderStatus::Cancelled->value => 'Hủy bỏ',
        OrderStatus::Failed->value => 'Không thành công',
    ],
    OrderType::class => [
        OrderType::Renting->value => 'Thuê',
        OrderType::Booking->value => 'Đặt',
    ],
    ToppingStatus::class => [
        ToppingStatus::InStock->value => 'Còn hàng',
        ToppingStatus::OutOfStock->value => 'Hết hàng',
    ],
    SliderStatus::class => [
        SliderStatus::Active => 'Hoạt động',
        SliderStatus::Inactive => 'Ngưng hoạt động'
    ],
    StoreStatus::class => [
        StoreStatus::Open->value => 'Mở cửa',
        StoreStatus::Close->value => 'Đóng cửa'
    ],
    DiscountType::class => [
        DiscountType::Money->value => 'Tiền',
        DiscountType::Percent->value => 'Phần trăm'
    ],
    SettingGroup::class => [
        SettingGroup::General => 'Chung',
        SettingGroup::UserDiscount => 'Chiết khấu mua hàng theo cấp TV',
        SettingGroup::UserUpgrade => 'SL SP nâng cấp TV',
    ],
    PostCategoryStatus::class => [
        PostCategoryStatus::Published => 'Đã xuất bản',
        PostCategoryStatus::Draft => 'Bản nháp'
    ],
    PostStatus::class => [
        PostStatus::Published->value => 'Đã xuất bản',
        PostStatus::Draft->value => 'Bản nháp'
    ],
    PriorityStatus::class => [
        PriorityStatus::Priority->value => 'Ưu tiên',
        PriorityStatus::NotPriority->value => 'Không ưu tiên'
    ],
    FeaturedStatus::class => [
        FeaturedStatus::Featured->value => 'Nổi bật',
        FeaturedStatus::Featureless->value => 'Không nổi bật'
    ],
    ModuleStatus::class => [
        ModuleStatus::ChuaXong => 'Chưa xong',
        ModuleStatus::DaXong => 'Đã xong',
        ModuleStatus::DaDuyet => 'Đã duyệt'
    ]
];
