<?php

return [
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
        'DT_RowIndex' => [
            'title' => 'STT',
            'width' => '20px',
            'orderable' => false
        ],
        'fullname' => [
            'title' => 'Họ tên',
            'orderable' => false
        ],
        'phone' => [
            'title' => 'Số điện thoại',
            'orderable' => false
        ],
        'email' => [
            'title' => 'Email',
            'orderable' => false,
        ],
		'roles' => [
            'title' => 'Vai trò',
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
            'addClass' => 'text-center'
        ],
    ],
    'user' => [
        'DT_RowIndex' => [
            'title' => 'STT',
            'width' => '20px',
            'orderable' => false
        ],
        'username' => [
            'title' => 'Tên đăng nhập',
            'orderable' => false,
            'visible' => false
        ],
        'fullname' => [
            'title' => 'Họ tên',
            'orderable' => false
        ],
        'email' => [
            'title' => 'Email',
            'orderable' => false,
        ],
        'phone' => [
            'title' => 'Số điện thoại',
            'orderable' => false
        ],
        'gender' => [
            'title' => 'Giới tính',
            'orderable' => false,
            'visible' => false
        ],
        'vip' => [
            'title' => 'Vip',
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
            'addClass' => 'text-center'
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
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'is_user_discount' => [
            'title' => 'Chiếc khẩu',
            'orderable' => false,
            'addClass' => 'text-center align-middle'
        ],
        'categories' => [
            'title' => 'Danh mục',
            'orderable' => false,
            'visible' => false,
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
            'title' => 'Thành viên',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'payment_code' => [
            'title' => 'Mã thanh toán',
            'orderable' => false,
            'addClass' => 'align-middle'
        ],
        'status' => [
            'title' => 'Trạng thái',
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
        'action' => [
            'title' => 'Thao tác',
            'orderable' => false,
            'exportable' => false,
            'printable' => false,
            'addClass' => 'text-center align-middle'
        ],
    ],
];