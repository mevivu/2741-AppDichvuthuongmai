<?php

use App\Enums\Admin\AdminRoles;
use App\Enums\Order\OrderStatus;
use App\Enums\PostCategory\PostCategoryStatus;
use App\Enums\Post\PostStatus;
use App\Enums\Module\ModuleStatus;
use App\Enums\Product\{ProductType, ProductVariationAction};
use App\Enums\Setting\SettingGroup;
use App\Enums\Slider\SliderStatus;
use App\Enums\User\{UserGender, UserVip, UserRoles};

return [
    UserGender::class => [
        UserGender::Male => 'Nam',
        UserGender::Female => 'Nữ',
        UserGender::Other => 'Khác',
    ],
    UserVip::class => [
        UserVip::Default => 'Mặc định',
        UserVip::Bronze => 'Đồng',
        UserVip::Silver => 'Bạc',
        UserVip::Gold => 'Vàng',
        UserVip::Diamond => 'Kim cương',
    ],
    UserRoles::class => [
        UserRoles::Member => 'Thành viên',
    ],
    ProductType::class => [
        ProductType::Simple => 'Sản phẩm đơn giản',
        ProductType::Variable => 'Sản phẩm có biến thể'
    ],
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