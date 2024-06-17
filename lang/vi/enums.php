<?php

use App\Enums\Area\AreaStatus;
use App\Enums\DefaultStatus;
use App\Enums\Driver\AutoAccept;
use App\Enums\Driver\DriverAssignmentType;
use App\Enums\Driver\DriverStatus;
use App\Enums\Driver\DriverTransactionStatus;
use App\Enums\Order\OrderStatus;
use App\Enums\Payment\PaymentMethod;
use App\Enums\PostCategory\PostCategoryStatus;
use App\Enums\Post\PostStatus;
use App\Enums\Module\ModuleStatus;
use App\Enums\Product\{ProductType, ProductVariationAction};
use App\Enums\Setting\SettingGroup;
use App\Enums\Slider\SliderStatus;
use App\Enums\User\{Gender, UserVip, UserRoles};

return [
    Gender::class => [
        Gender::Male->value => 'Nam',
        Gender::Female->value => 'Nữ',
        Gender::Other->value => 'Khác',
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
        ProductType::Simple => 'Sản phẩm đơn giản',
        ProductType::Variable => 'Sản phẩm có biến thể'
    ],
    DefaultStatus::class => array(
        DefaultStatus::Published->value => 'Đã xuất bản',
        DefaultStatus::Draft->value => 'Bản nháp'
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
        OrderStatus::Processing => 'Đang xử lý',
        OrderStatus::Processed => 'Đã xử lý',
        OrderStatus::Completed => 'Đã hoàn thành',
        OrderStatus::Cancelled => 'Đã hủy'
    ],
    SliderStatus::class => [
        SliderStatus::Active => 'Hoạt động',
        SliderStatus::Inactive => 'Ngưng hoạt động'
    ],
    SettingGroup::class => [
        SettingGroup::General => 'Chung',
        SettingGroup::UserDiscount => 'Chiếc khấu mua hàng theo cấp TV',
        SettingGroup::UserUpgrade => 'SL SP nâng cấp TV',
    ],
    PostCategoryStatus::class => [
        PostCategoryStatus::Published => 'Đã xuất bản',
        PostCategoryStatus::Draft => 'Bản nháp'
    ],
    PostStatus::class => [
        PostStatus::Published => 'Đã xuất bản',
        PostStatus::Draft => 'Bản nháp'
    ],
	ModuleStatus::class => [
        ModuleStatus::ChuaXong => 'Chưa xong',
        ModuleStatus::DaXong => 'Đã xong',
        ModuleStatus::DaDuyet => 'Đã duyệt'
    ]
];
