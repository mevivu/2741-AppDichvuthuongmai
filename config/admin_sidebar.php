<?php

return [
    [
        'title' => 'Dashboard',
        'routeName' => 'admin.dashboard',
        'icon' => '<i class="ti ti-home"></i>',
        'roles' => [],
        'permissions' => ['mevivuDev'],
        'sub' => []
    ],
    [
        'title' => 'area',
        'routeName' => null,
        'icon' => '<i class="ti ti-map-pin"></i>',
        'roles' => [],
        'permissions' => ['createArea', 'viewArea', 'updateArea', 'deleteArea'],
        'sub' => [
            [
                'title' => 'Thêm khu vực',
                'routeName' => 'admin.area.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createArea'],
            ],
            [
                'title' => 'DS khu vực',
                'routeName' => 'admin.area.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewArea'],
            ]
        ]
    ],
    [
        'title' => 'notification',
        'routeName' => null,
        'icon' => '<i class="ti ti-bell-check"></i>',
        'roles' => [],
        'permissions' => ['createNotification', 'viewNotification', 'updateNotification', 'deleteNotification'],
        'sub' => [
            [
                'title' => 'Thêm thông báo',
                'routeName' => 'admin.notification.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createNotification'],
            ],
            [
                'title' => 'DS thông báo',
                'routeName' => 'admin.notification.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewNotification'],
            ]
        ]
    ],
    [
        'title' => 'Bài viết',
        'routeName' => null,
        'icon' => '<i class="ti ti-article"></i>',
        'roles' => [],
        'permissions' =>
            [
                'createPost', 'viewPost', 'updatePost',
                'deletePost', 'viewPostCategory', 'createPostCategory', 'updatePostCategory'
            ],
        'sub' => [
            [
                'title' => 'Thêm bài viết',
                'routeName' => 'admin.post.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createPost'],
            ],
            [
                'title' => 'DS bài viết',
                'routeName' => 'admin.post.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewPost'],
            ],
            [
                'title' => 'DS chuyên mục',
                'routeName' => 'admin.post_category.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewPostCategory'],
            ]
        ]
    ],
    [
        'title' => 'Mã giảm giá',
        'routeName' => null,
        'icon' => '<i class="ti ti-ticket"></i>',
        'roles' => [],
        'permissions' => ['all', 'createDiscountCode', 'viewDiscountCode', 'updateDiscountCode', 'deleteDiscountCode'],
        'sub' => [
            [
                'title' => 'Thêm mã giảm giá',
                'routeName' => 'admin.discount.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['all', 'createDiscountCode'],
            ],
            [
                'title' => 'DS mã giảm giá',
                'routeName' => 'admin.discount.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['all', 'viewDiscountCode'],
            ],
        ]
    ],
    [
        'title' => 'Topping',
        'routeName' => null,
        'icon' => '<i class="ti ti-brand-producthunt"></i>',
        'roles' => [],
        'permissions' => ['all', 'createTopping', 'viewTopping', 'updateTopping', 'deleteTopping'],
        'sub' => [
            [
                'title' => 'Thêm topping',
                'routeName' => 'admin.topping.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createTopping'],
            ],
            [
                'title' => 'DS Topping',
                'routeName' => 'admin.topping.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewTopping'],
            ],

        ]
    ],

    [
        'title' => 'Dịch Vụ',
        'routeName' => null,
        'icon' => '<i class="ti ti-bed"></i>',
        'roles' => [],
        'permissions' => ['viewServices', 'createServices', 'updateServices', 'deleteServices'],
        'sub' => [
            [
                'title' => 'Thêm Dịch Vụ',
                'routeName' => 'admin.category_system.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createServices'],
            ],
            [
                'title' => 'Danh sách Dịch Vụ',
                'routeName' => 'admin.category_system.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewServices'],
            ]
        ]
    ],
    [
        'title' => 'Đơn hàng',
        'routeName' => null,
        'icon' => '<i class="ti ti-box"></i>',
        'roles' => [],
        'permissions' => ['createOrder', 'viewOrder', 'updateOrder', 'deleteOrder'],
        'sub' => [
            [
                'title' => 'Thêm đơn hàng',
                'routeName' => 'admin.order.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createOrder'],
            ],
            [
                'title' => 'DS đơn hàng',
                'routeName' => 'admin.order.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewOrder'],
            ],
        ]
    ],
    [
        'title' => 'Thuê xe',
        'routeName' => null,
        'icon' => '<i class="ti ti-car"></i>',
        'roles' => [],
        'permissions' => ['createRentingOrder', 'viewRentingOrder', 'updateRentingOrder', 'deleteRentingOrder'],
        'sub' => [
            [
                'title' => 'Thêm đơn thuê xe',
                'routeName' => 'admin.renting-order.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createRentingOrder'],
            ],
            [
                'title' => 'DS đơn hàng thuê xe',
                'routeName' => 'admin.renting-order.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewRentingOrder'],
            ]
        ]
    ],
    [
        'title' => 'Phương tiện',
        'routeName' => null,
        'icon' => '<i class="ti ti-motorbike"></i>',
        'roles' => [],
        'permissions' => ['all', 'viewVehicle', 'updateVehicle', 'createVehicle', 'deleteVehicle'],
        'sub' => [
            [
                'title' => 'add',
                'routeName' => 'admin.vehicle.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['all', 'createVehicle'],
            ],
            [
                'title' => 'DS phương tiện',
                'routeName' => 'admin.vehicle.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['all', 'viewVehicle'],
            ],
        ]
    ],
    [
        'title' => 'Sản phẩm',
        'routeName' => null,
        'icon' => '<i class="ti ti-brand-producthunt"></i>',
        'roles' => [],
        'permissions' => [
            'createProduct', 'viewProduct',
            'updateProduct', 'deleteProduct',
            'createProductCategory','updateProductCategory',
            'viewProductCategory'
        ],
        'sub' => [
            [
                'title' => 'Thêm sản phẩm',
                'routeName' => 'admin.product.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createProduct'],
            ],
            [
                'title' => 'DS sản phẩm',
                'routeName' => 'admin.product.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewProduct'],
            ],
//            [
//                'title' => 'Các thuộc tính',
//                'routeName' => 'admin.attribute.index',
//                'icon' => '<i class="ti ti-clipboard-list"></i>',
//                'roles' => [],
//                'permissions' => ['viewProductAttribute'],
//            ],
            [
                'title' => 'DS danh mục',
                'routeName' => 'admin.category.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewProductCategory'],
            ],
        ]
    ],
    [
        'title' => 'customer',
        'routeName' => null,
        'icon' => '<i class="ti ti-users"></i>',
        'roles' => [],
        'permissions' => ['createUser', 'viewUser', 'updateUser', 'deleteUser'],
        'sub' => [
            [
                'title' => 'add',
                'routeName' => 'admin.user.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createUser'],
            ],
            [
                'title' => 'list',
                'routeName' => 'admin.user.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewUser'],
            ],
        ]
    ],
    [
        'title' => 'Cửa hàng',
        'routeName' => null,
        'icon' => '<i class="ti ti-building-warehouse"></i>',
        'roles' => [],
        'permissions' => [
            'createUser',
            'viewUser',
            'updateUser',
            'deleteUser',
            'viewStoreCategory',
            'updateStoreCategory',
            'createStoreCategory'
        ],
        'sub' => [
            [
                'title' => 'Thêm Cửa hàng',
                'routeName' => 'admin.store.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createUser'],
            ],

            [
                'title' => 'DS Cửa hàng',
                'routeName' => 'admin.store.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewUser'],
            ],
            [
                'title' => 'DS Danh mục',
                'routeName' => 'admin.store.category.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewStoreCategory'],
            ]
        ]
    ],
    [
        'title' => 'Tài Xế',
        'routeName' => null,
        'icon' => '<i class="ti ti-user"></i>',
        'roles' => [],
        'permissions' => ['createDriver', 'viewDriver', 'updateDriver', 'deleteDriver'],
        'sub' => [
            [
                'title' => 'Thêm Tài Xế',
                'routeName' => 'admin.driver.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createDriver'],
            ],
            [
                'title' => 'DS Tài Xế',
                'routeName' => 'admin.driver.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewDriver'],
            ]
        ]
    ],
//    [
//        'title' => 'Sliders',
//        'routeName' => null,
//        'icon' => '<i class="ti ti-slideshow"></i>',
//        'roles' => [],
//        'permissions' => ['createSlider', 'viewSlider', 'updateSlider', 'deleteSlider'],
//        'sub' => [
//            [
//                'title' => 'Thêm Sliders',
//                'routeName' => 'admin.slider.create',
//                'icon' => '<i class="ti ti-plus"></i>',
//                'roles' => [],
//                'permissions' => ['createSlider'],
//            ],
//            [
//                'title' => 'DS Sliders',
//                'routeName' => 'admin.slider.index',
//                'icon' => '<i class="ti ti-list"></i>',
//                'roles' => [],
//                'permissions' => ['viewSlider'],
//            ],
//        ]
//    ],
    [
        'title' => 'Vai trò',
        'routeName' => null,
        'icon' => '<i class="ti ti-user-check"></i>',
        'roles' => [],
        'permissions' => ['createRole', 'viewRole', 'updateRole', 'deleteRole'],
        'sub' => [
            [
                'title' => 'Thêm Vai trò',
                'routeName' => 'admin.role.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createRole'],
            ],
            [
                'title' => 'DS Vai trò',
                'routeName' => 'admin.role.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewRole'],
            ]
        ]
    ],
    [
        'title' => 'Admin',
        'routeName' => null,
        'icon' => '<i class="ti ti-user-shield"></i>',
        'roles' => [],
        'permissions' => ['createAdmin', 'viewAdmin', 'updateAdmin', 'deleteAdmin'],
        'sub' => [
            [
                'title' => 'Thêm admin',
                'routeName' => 'admin.admin.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['createAdmin'],
            ],
            [
                'title' => 'DS admin',
                'routeName' => 'admin.admin.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['viewAdmin'],
            ],
        ]
    ],
    [
        'title' => 'Cài đặt',
        'routeName' => null,
        'icon' => '<i class="ti ti-settings"></i>',
        'roles' => [],
        'permissions' => ['settingGeneral'],
        'sub' => [
            [
                'title' => 'Chung',
                'routeName' => 'admin.setting.general',
                'icon' => '<i class="ti ti-tool"></i>',
                'roles' => [],
                'permissions' => ['settingGeneral'],
            ],
            [
                'title' => 'Thành viên mua hàng',
                'routeName' => 'admin.setting.user_shopping',
                'icon' => '<i class="ti ti-user-cog"></i>',
                'roles' => [],
                'permissions' => [],
            ],
        ]
    ],
    [
        'title' => 'Dev: Quyền',
        'routeName' => null,
        'icon' => '<i class="ti ti-code"></i>',
        'roles' => [],
        'permissions' => ['mevivuDev'],
        'sub' => [
            [
                'title' => 'Thêm Quyền',
                'routeName' => 'admin.permission.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['mevivuDev'],
            ],
            [
                'title' => 'DS Quyền',
                'routeName' => 'admin.permission.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['mevivuDev'],
            ]
        ]
    ],
    [
        'title' => 'Dev: Module',
        'routeName' => null,
        'icon' => '<i class="ti ti-code"></i>',
        'roles' => [],
        'permissions' => ['mevivuDev'],
        'sub' => [
            [
                'title' => 'Thêm Module',
                'routeName' => 'admin.module.create',
                'icon' => '<i class="ti ti-plus"></i>',
                'roles' => [],
                'permissions' => ['mevivuDev'],
            ],
            [
                'title' => 'DS Module',
                'routeName' => 'admin.module.index',
                'icon' => '<i class="ti ti-list"></i>',
                'roles' => [],
                'permissions' => ['mevivuDev'],
            ]
        ]
    ],
    [
        'title' => 'Dev: Nghiệm thu',
        'routeName' => 'admin.module.summary',
        'icon' => '<i class="ti ti-code"></i>',
        'roles' => [],
        'permissions' => ['mevivuDev'],
        'sub' => []
    ],

];
