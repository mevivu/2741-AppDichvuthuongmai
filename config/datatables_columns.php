<?php

return [
    'area' => [
        'name' => [
            'title' => 'name',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'created_at' => [
            'title' => 'createdAt',
            'orderable' => false,
            'addClass' => 'align-middle',
            'visible' => true
        ],
        'status' => [
            'title' => 'status',
            'orderable' => false,
            'addClass' => 'align-middle',
            'visible' => true
        ],
        'address' => [
            'title' => 'address',
            'orderable' => false,
            'addClass' => 'align-middle',
            'visible' => true
        ],
        'action' => [
            'title' => 'action',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'notifications' => [

        'title' => [
            'title' => 'Tiêu đề',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'user_id' => [
            'title' => 'Người nhận',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'message' => [
            'title' => 'Nội dung',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'status' => [
            'title' => 'status',
            'orderable' => false,
            'addClass' => 'align-middle',
        ],

        'created_at' => [
            'title' => 'Ngày thông báo',
            'orderable' => false,
            'addClass' => 'align-middle',
        ],
        'action' => [
            'title' => 'action',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle',
        ],

    ],
    'discount' => [
        'code' => [
            'title' => 'Mã',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'stores' => [
            'title' => 'store',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'products' => [
            'title' => 'product',
            'orderable' => false,
            'addClass' => 'align-middle',
            'visible' => false,
        ],
        'users' => [
            'title' => 'user',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'drivers' => [
            'title' => 'driver',
            'orderable' => false,
            'addClass' => 'align-middle',
            'visible' => false,
        ],

        'date_start' => [
            'title' => 'Ngày bắt đầu',
            'orderable' => false,
            'addClass' => 'align-middle',
            'visible' => true
        ],
        'date_end' => [
            'title' => 'Ngày kết thúc',
            'orderable' => false,
            'addClass' => 'align-middle',
            'visible' => true
        ],
        'max_usage' => [
            'title' => 'Số lượng phiếu',
            'orderable' => false,
            'addClass' => 'align-middle',
            'visible' => false
        ],
        'min_order_amount' => [
            'title' => 'Giá trị ĐH',
            'orderable' => false,
            'addClass' => 'align-middle',
        ],
        'type' => [
            'title' => 'Loại',
            'orderable' => false,
            'addClass' => 'align-middle',
            'visible' => false
        ],
        'discount_value' => [
            'title' => 'giá trị giảm',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'action' => [
            'title' => 'action',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'topping' => [
        'name' => [
            'title' => 'Tên',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'price' => [
            'title' => 'Giá',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'status' => [
            'title' => 'Trạng thái',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'avatar' => [
            'title' => 'Ảnh',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'created_at' => [
            'title' => 'createdAt',
            'orderable' => false,
            'addClass' => 'align-middle',
            'visible' => false
        ],
        'action' => [
            'title' => 'action',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'vehicle' => [
        'id' => [
            'title' => 'Mã phương tiện',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'vehicle_owner' => [
            'title' => 'Chủ xe',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'driver' => [
            'title' => 'Tài xế',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'name' => [
            'title' => 'Tên xe',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'vehicle_company' => [
            'title' => 'Nhà sản xuất',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'color' => [
            'title' => 'Màu phương tiện',
            'orderable' => false,
            'visible' => false,
            'addClass' => 'text-center align-middle'
        ],
        'type' => [
            'title' => 'Loại xe',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'license_plate' => [
            'title' => 'biển số xe',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'created_at' => [
            'title' => 'Ngày đặt',
            'orderable' => false,
            'visible' => false,
            'addClass' => 'text-center align-middle'
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'module' => [
        'id' => [
            'title' => 'ID',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'align-middle'
        ],
        'name' => [
            'title' => 'Tên Module',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'align-middle'
        ],
        'status' => [
            'title' => 'Trạng thái',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'align-middle'
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'role' => [
        'id' => [
            'title' => 'ID',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'align-middle'
        ],
        'title' => [
            'title' => 'Tên vai trò',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'align-middle'
        ],
        'name' => [
            'title' => 'Slug ( role_name )',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'align-middle'
        ],
        'guard_name' => [
            'title' => 'Vai trò của nhóm ( Guard Name )',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'align-middle'
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'permission' => [
        'id' => [
            'title' => 'ID',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'align-middle'
        ],
        'title' => [
            'title' => 'Tên quyền',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'align-middle'
        ],
        'name' => [
            'title' => 'Slug ( Permission_name )',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'align-middle'
        ],
        'module_id' => [
            'title' => 'Thuộc Module',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'align-middle'
        ],
        'guard_name' => [
            'title' => 'Nhóm quyền ( Guard Name )',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'align-middle'
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'admin' => [

        'fullname' => [
            'title' => 'Họ tên',
            'addClass' => 'align-middle',
            'orderable' => false
        ],
        'phone' => [
            'title' => 'Số điện thoại',
            'addClass' => 'align-middle',
            'orderable' => false
        ],
        'email' => [
            'title' => 'Email',
            'addClass' => 'align-middle',
            'orderable' => false,
        ],
        'roles' => [
            'title' => 'Vai trò',
            'addClass' => 'align-middle',
            'orderable' => false,
        ],
        'created_at' => [
            'title' => 'Ngày tạo',
            'orderable' => false,
            'visible' => false
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle',
        ],
    ],
    'user' => [

        'fullname' => [
            'title' => 'Họ tên',
            'addClass' => 'align-middle',
            'orderable' => false
        ],
        'email' => [
            'title' => 'Email',
            'addClass' => 'align-middle',
            'orderable' => false,
        ],
        'phone' => [
            'title' => 'Số điện thoại',
            'addClass' => 'align-middle',
            'orderable' => false
        ],
        'gender' => [
            'title' => 'Giới tính',
            'addClass' => 'align-middle',
            'orderable' => false,
            'visible' => false
        ],
        'created_at' => [
            'title' => 'Ngày tạo',
            'orderable' => false,
            'addClass' => 'align-middle',
            'visible' => false
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'store' => [
        'priority' => [
            'title' => 'priority',
            'addClass' => 'align-middle',
            'orderable' => true
        ],
        'store_name' => [
            'title' => 'storeName',
            'addClass' => 'align-middle',
            'orderable' => false
        ],
        'category' => [
            'title' => 'category2',
            'addClass' => 'align-middle',
            'orderable' => false
        ],
        'area' => [
            'title' => 'area',
            'addClass' => 'align-middle',
            'orderable' => false
        ],
        'open_hours_1' => [
            'title' => 'operatingTime',
            'addClass' => 'align-middle',
            'orderable' => false,
            'visible' => false
        ],
        'status' => [
            'title' => 'status',
            'addClass' => 'align-middle',
            'orderable' => false
        ],
        'address_detail' => [
            'title' => 'address',
            'addClass' => 'align-middle',
            'orderable' => false
        ],
        'created_at' => [
            'title' => 'createdAt',
            'addClass' => 'align-middle',
            'orderable' => false,
            'visible' => false
        ],
        'action' => [
            'title' => 'action',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],

    ],
    'store_category' => [
        'name' => [
            'title' => 'name',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'status' => [
            'title' => 'status',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'align-middle'
        ],
        'created_at' => [
            'title' => 'createdAt',
            'orderable' => false,
            'addClass' => 'align-middle',
            'visible' => true
        ],
        'action' => [
            'title' => 'action',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'store_product' => [
        'name' => [
            'title' => 'name',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'created_at' => [
            'title' => 'createdAt',
            'orderable' => false,
            'addClass' => 'align-middle',
            'visible' => true
        ],
        'view-topping' => [
            'title' => 'Topping',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'view-discount' => [
            'title' => 'Discount',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'action' => [
            'title' => 'action',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],

    ],
    'product_topping' => [
        'name' => [
            'title' => 'name',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'created_at' => [
            'title' => 'createdAt',
            'orderable' => false,
            'addClass' => 'align-middle',
            'visible' => true
        ],
        'action' => [
            'title' => 'action',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],

    ],
    'category' => [
        'name' => [
            'title' => 'Tên danh mục',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'avatar' => [
            'title' => 'Hình ảnh',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'is_active' => [
            'title' => 'Trạng thái',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'created_at' => [
            'title' => 'Ngày tạo',
            'orderable' => false,
            'addClass' => 'align-middle',
            'visible' => false
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'attribute' => [
        'position' => [
            'title' => 'Vị trí',
            'addClass' => 'align-middle',
            'orderable' => false,
        ],
        'name' => [
            'title' => 'Tên thuộc tính',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'type' => [
            'title' => 'Loại',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'variations' => [
            'title' => 'Các biến thể',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'attributes_variations' => [
        'position' => [
            'title' => 'Vị trí',
            'orderable' => false,
        ],
        'name' => [
            'title' => 'Tên biến thể',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'desc' => [
            'title' => 'Mô tả',
            'addClass' => 'align-middle',
            'orderable' => false,
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'product' => [
        'avatar' => [
            'title' => 'Ảnh',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'name' => [
            'title' => 'Tên',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'in_stock' => [
            'title' => 'Kho',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'price' => [
            'title' => 'Giá',
            'width' => '150px',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'categories' => [
            'title' => 'Danh mục',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'toppings' => [
            'title' => 'Topping',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'created_at' => [
            'title' => 'Ngày tạo',
            'orderable' => false,
            'visible' => false,
            'addClass' => 'align-middle'
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'order' => [
        'id' => [
            'title' => 'Mã đơn hàng',
            'orderable' => false,
        ],
        'user' => [
            'title' => 'customer',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'driver' => [
            'title' => 'driver',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'payment_code' => [
            'title' => 'Mã thanh toán',
            'orderable' => false,
            'addClass' => 'align-middle',
            'visible' => false,
        ],
        'status' => [
            'title' => 'Trạng thái',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'order_type' => [
            'title' => 'Loại hợp đồng',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'total' => [
            'title' => 'Tổng tiền',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'created_at' => [
            'title' => 'Ngày đặt',
            'orderable' => false,
            'visible' => false,
            'addClass' => 'align-middle'
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'renting-order' => [
        'id' => [
            'title' => 'Mã đơn hàng',
            'orderable' => false,
        ],
        'user' => [
            'title' => 'customer',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'payment_code' => [
            'title' => 'Mã thanh toán',
            'orderable' => false,
            'addClass' => 'align-middle',
            'visible' => false,
        ],
        'status' => [
            'title' => 'Trạng thái',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'payment_method' => [
            'title' => 'Phương thức thanh toán',
            'orderable' => false,
            'addClass' => 'align-middle text-center',
        ],
        'order_type' => [
            'title' => 'Loại hợp đồng',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'total' => [
            'title' => 'Tổng tiền',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'created_at' => [
            'title' => 'Ngày đặt',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'slider' => [
        'name' => [
            'title' => 'Tên',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'align-middle'
        ],
        'plain_key' => [
            'title' => 'Key',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'align-middle'
        ],
        'status' => [
            'title' => 'Trạng thái',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'align-middle'
        ],
        'items' => [
            'title' => 'Slider Item',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'created_at' => [
            'title' => 'Ngày tạo',
            'orderable' => false,
            'visible' => false,
            'addClass' => 'align-middle'
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'slider_item' => [
        'title' => [
            'title' => 'Tên',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'align-middle'
        ],
        'image' => [
            'title' => 'Hình ảnh',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'position' => [
            'title' => 'Vị trí',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'align-middle'
        ],
        'created_at' => [
            'title' => 'Ngày tạo',
            'orderable' => false,
            'visible' => false,
            'addClass' => 'align-middle'
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'post_category' => [
        'name' => [
            'title' => 'Tên danh mục',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'parents_name' => [
            'title' => 'Danh mục cha',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'status' => [
            'title' => 'Trạng thái',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'created_at' => [
            'title' => 'Ngày tạo',
            'orderable' => false,
            'addClass' => 'align-middle',
            'visible' => false
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'post' => [
        'image' => [
            'title' => 'Ảnh',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'title' => [
            'title' => 'Tiêu đề',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'status' => [
            'title' => 'Trạng thái',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'is_featured' => [
            'title' => 'Nổi bật',
            'orderable' => false,
            'addClass' => 'align-middle',
            'visible' => false
        ],
        'created_at' => [
            'title' => 'Ngày tạo',
            'orderable' => false,
            'addClass' => 'align-middle',
            'visible' => false
        ],
//        'action' => [
//            'title' => 'Thao tác',
//            'orderable' => false,
//            'exportable' => false,
//            'printable' => false,
//            'addClass' => 'text-center align-middle'
//        ],
    ],
    'driver' => [
        'fullname' => [
            'title' => 'fullname',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'id_card' => [
            'title' => 'id_card',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'bank_name' => [
            'title' => 'bank_name',
            'addClass' => 'align-middle',
            'orderable' => false,
        ],
        //        'roles' => [
//            'title' => 'role',
//            'orderable' => false,
//            'visible' => false
//        ],
        'order_accepted' => [
            'title' => 'status',
            'orderable' => false,
        ],
        'auto_accept' => [
            'title' => 'Tự động nhận chuyến',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],

        'created_at' => [
            'title' => 'createdAt',
            'orderable' => false,
            'addClass' => 'align-middle',
            'visible' => true
        ],

        'action' => [
            'title' => 'action',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
    'category_system' => [
        'id' => [
            'title' => 'ID',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'align-middle'
        ],

        'name' => [
            'title' => 'Tên dịch vụ',
            'orderable' => false,
            'width' => '150px',
            'addClass' => 'align-middle'
        ],
        'avatar' => [
            'title' => 'Hình ảnh',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'created_at' => [
            'title' => 'Ngày tạo',
            'orderable' => false,
            'addClass' => 'align-middle',
            'width' => '150px',
            'visible' => true
        ],
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'width' => '150px',
            'addClass' => 'text-center align-middle'
        ],

    ],

];
