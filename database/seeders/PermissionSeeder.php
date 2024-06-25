<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // seeding

        // roles
        DB::table('roles')->insert([
            'title' => 'Super Admin',
            'name' => 'superAdmin',
            'guard_name' => 'admin',
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('roles')->insert([
            'title' => 'Phụ huynh',
            'name' => 'parents',
            'guard_name' => 'web',
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('roles')->insert([
            'title' => 'Khách hàng',
            'name' => 'customer',
            'guard_name' => 'web',
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('roles')->insert([
            'title' => 'Tài xế',
            'name' => 'driver',
            'guard_name' => 'web',
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        //modules
        DB::table('modules')->insert([
            'id' => 1,
            'name' => 'Quản lý Bài viết',
            'description' => '<p>Quản l&yacute; c&aacute;c B&agrave;i viết trong hệ thống</p>',
            'status' => 2,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('modules')->insert([
            'id' => 2,
            'name' => 'QL Chuyên mục Bài viết',
            'description' => '<p>Quản l&yacute; Chuy&ecirc;n mục B&agrave;i viết</p>',
            'status' => 2,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('modules')->insert([
            'id' => 3,
            'name' => 'Quản lý Vai trò',
            'description' => '<p>Quản l&yacute; Vai tr&ograve; tr&ecirc;n hệ thống</p>',
            'status' => 2,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('modules')->insert([
            'id' => 4,
            'name' => 'Quản lý Admin',
            'description' => '<p>Quản l&yacute; c&aacute;c quản trị vi&ecirc;n trong Hệ thống v&agrave; Ph&acirc;n vai tr&ograve; cho c&aacute;c Admin</p>',
            'status' => 2,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('modules')->insert([
            'id' => 5,
            'name' => 'Quản lý Thành viên',
            'description' => '<p>Quản l&yacute; Th&agrave;nh vi&ecirc;n</p>',
            'status' => 2,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('modules')->insert([
            'id' => 6,
            'name' => 'Quản lý Sản phẩm',
            'description' => '<p>Quản l&yacute; c&aacute;c th&ocirc;ng tin Sản phẩm của hệ thống</p>',
            'status' => 2,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('modules')->insert([
            'id' => 7,
            'name' => 'QL Thuộc tính Sản phẩm',
            'description' => '<p>QL Thuộc t&iacute;nh Sản phẩm</p>',
            'status' => 2,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('modules')->insert([
            'id' => 8,
            'name' => 'QL Danh mục Sản phẩm',
            'description' => '<p>Quản l&yacute; Danh mục Sản phẩm</p>',
            'status' => 2,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('modules')->insert([
            'id' => 9,
            'name' => 'Quản lý Đơn hàng',
            'description' => '<p>Quản l&yacute; Đơn h&agrave;ng</p>',
            'status' => 2,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('modules')->insert([
            'id' => 10,
            'name' => 'Quản lý Slider',
            'description' => '<p>Quản l&yacute; Slider c&aacute;c h&igrave;nh ảnh chạy qua lại ở trang Web b&ecirc;n ngo&agrave;i</p>',
            'status' => 2,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('modules')->insert([
            'id' => 11,
            'name' => 'Quản lý Slider Items',
            'description' => '<p>Quản l&yacute; c&aacute;c H&igrave;nh ảnh b&ecirc;n trong một Slider</p>',
            'status' => 2,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('modules')->insert([
            'id' => 12,
            'name' => 'Quản lý Khu vực',
            'description' => '<p>Quản l&yacute; khu vực</p>',
            'status' => 2,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('modules')->insert([
            'id' => 13,
            'name' => 'Quản lý danh mục cửa hàng',
            'description' => '<p>Quản lý danh mục cửa hàng</p>',
            'status' => 2,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('modules')->insert([
            'id' => 14,
            'name' => 'Quản lý cửa hàng',
            'description' => '<p>Quản lý cửa hàng</p>',
            'status' => 2,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('modules')->insert([
            'id' => 15,
            'name' => 'Quản lý thông báo',
            'description' => '<p>Quản lý thông báo</p>',
            'status' => 2,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('modules')->insert([
            'id' => 16,
            'name' => 'Quản lý tài xế',
            'description' => '<p>Quản lý tài xế</p>',
            'status' => 2,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        // Module store
        DB::table('modules')->insert([
            'id' => 17,
            'name' => 'Quản lý cửa hàng',
            'description' => '<p>Quản lý cửa hàng</p>',
            'status' => 2,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        // Module Category
        DB::table('modules')->insert([
            'id' => 18,
            'name' => 'Quản lý danh mục',
            'description' => '<p>Quản lý danh mục</p>',
            'status' => 2,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        // Module Discount Code
        DB::table('modules')->insert([
            'id' => 19,
            'name' => 'Quản lý mã giảm giá',
            'description' => '<p>Quản lý mã giảm giá</p>',
            'status' => 2,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        // Module Topping
        DB::table('modules')->insert([
            'id' => 20,
            'name' => 'Quản lý topping',
            'description' => '<p>Quản lý topping</p>',
            'status' => 2,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        // Module Vehicle
        DB::table('modules')->insert([
            'id' => 21,
            'name' => 'Quản lý phương tiện',
            'description' => '<p>Quản lý phương tiện</p>',
            'status' => 2,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        // permissions
        DB::table('permissions')->insert([
            'id' => 1,
            'title' => 'Đọc tài liệu API',
            'name' => 'readAPIDoc',
            'guard_name' => 'admin',
            'module_id' => null,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('permissions')->insert([
            'id' => 2,
            'title' => 'Xem Bài viết',
            'name' => 'viewPost',
            'guard_name' => 'admin',
            'module_id' => 1,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('permissions')->insert([
            'id' => 3,
            'title' => 'Thêm Bài viết',
            'name' => 'createPost',
            'guard_name' => 'admin',
            'module_id' => 1,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('permissions')->insert([
            'id' => 4,
            'title' => 'Sửa Bài viết',
            'name' => 'updatePost',
            'guard_name' => 'admin',
            'module_id' => 1,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('permissions')->insert([
            'id' => 5,
            'title' => 'Xóa Bài viết',
            'name' => 'deletePost',
            'guard_name' => 'admin',
            'module_id' => 1,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('permissions')->insert([
            'id' => 6,
            'title' => 'Xem Vai Trò',
            'name' => 'viewRole',
            'guard_name' => 'admin',
            'module_id' => 3,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('permissions')->insert([
            'id' => 7,
            'title' => 'Thêm Vai Trò',
            'name' => 'createRole',
            'guard_name' => 'admin',
            'module_id' => 3,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('permissions')->insert([
            'id' => 8,
            'title' => 'Sửa Vai Trò',
            'name' => 'updateRole',
            'guard_name' => 'admin',
            'module_id' => 3,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('permissions')->insert([
            'id' => 9,
            'title' => 'Xóa Vai Trò',
            'name' => 'deleteRole',
            'guard_name' => 'admin',
            'module_id' => 3,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('permissions')->insert([
            'id' => 10,
            'title' => 'Xem Chuyên mục Bài viết',
            'name' => 'viewPostCategory',
            'guard_name' => 'admin',
            'module_id' => 2,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('permissions')->insert([
            'id' => 11,
            'title' => 'Thêm Chuyên mục Bài viết',
            'name' => 'createPostCategory',
            'guard_name' => 'admin',
            'module_id' => 2,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('permissions')->insert([
            'id' => 12,
            'title' => 'Sửa Chuyên mục Bài viết',
            'name' => 'updatePostCategory',
            'guard_name' => 'admin',
            'module_id' => 2,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('permissions')->insert([
            'id' => 13,
            'title' => 'Xóa Chuyên mục Bài viết',
            'name' => 'deletePostCategory',
            'guard_name' => 'admin',
            'module_id' => 2,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('permissions')->insert([
            'id' => 14,
            'title' => 'Xem Admin',
            'name' => 'viewAdmin',
            'guard_name' => 'admin',
            'module_id' => 4,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('permissions')->insert([
            'id' => 15,
            'title' => 'Thêm Admin',
            'name' => 'createAdmin',
            'guard_name' => 'admin',
            'module_id' => 4,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('permissions')->insert([
            'id' => 16,
            'title' => 'Sửa Admin',
            'name' => 'updateAdmin',
            'guard_name' => 'admin',
            'module_id' => 4,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('permissions')->insert([
            'id' => 17,
            'title' => 'Xóa Admin',
            'name' => 'deleteAdmin',
            'guard_name' => 'admin',
            'module_id' => 4,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);



        DB::table('permissions')->insert([
            'id' => 18,
            'title' => 'Xem Thành viên',
            'name' => 'viewUser',
            'guard_name' => 'admin',
            'module_id' => 5,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('permissions')->insert([
            'id' => 19,
            'title' => 'Thêm Thành viên',
            'name' => 'createUser',
            'guard_name' => 'admin',
            'module_id' => 5,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('permissions')->insert([
            'id' => 20,
            'title' => 'Sửa Thành viên',
            'name' => 'updateUser',
            'guard_name' => 'admin',
            'module_id' => 5,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('permissions')->insert([
            'id' => 21,
            'title' => 'Xóa Thành viên',
            'name' => 'deleteUser',
            'guard_name' => 'admin',
            'module_id' => 5,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('permissions')->insert([
            'id' => 22,
            'title' => 'Xem Đơn hàng',
            'name' => 'viewOrder',
            'guard_name' => 'admin',
            'module_id' => 9,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('permissions')->insert([
            'id' => 23,
            'title' => 'Thêm Đơn hàng',
            'name' => 'createOrder',
            'guard_name' => 'admin',
            'module_id' => 9,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);


        DB::table('permissions')->insert([
            'id' => 24,
            'title' => 'Sửa Đơn hàng',
            'name' => 'updateOrder',
            'guard_name' => 'admin',
            'module_id' => 9,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);


        DB::table('permissions')->insert([
            'id' => 25,
            'title' => 'Xóa Đơn hàng',
            'name' => 'deleteOrder',
            'guard_name' => 'admin',
            'module_id' => 9,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);


        DB::table('permissions')->insert([
            'id' => 26,
            'title' => 'Xem Sản phẩm',
            'name' => 'viewProduct',
            'guard_name' => 'admin',
            'module_id' => 6,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('permissions')->insert([
            'id' => 27,
            'title' => 'Thêm Sản phẩm',
            'name' => 'createProduct',
            'guard_name' => 'admin',
            'module_id' => 6,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);


        DB::table('permissions')->insert([
            'id' => 28,
            'title' => 'Sửa Sản phẩm',
            'name' => 'updateProduct',
            'guard_name' => 'admin',
            'module_id' => 6,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('permissions')->insert([
            'id' => 29,
            'title' => 'Xóa Sản phẩm',
            'name' => 'deleteProduct',
            'guard_name' => 'admin',
            'module_id' => 6,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('permissions')->insert([
            'id' => 30,
            'title' => 'Xem Thuộc tính Sản phẩm',
            'name' => 'viewProductAttribute',
            'guard_name' => 'admin',
            'module_id' => 7,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('permissions')->insert([
            'id' => 31,
            'title' => 'Thêm Thuộc tính Sản phẩm',
            'name' => 'createProductAttribute',
            'guard_name' => 'admin',
            'module_id' => 7,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('permissions')->insert([
            'id' => 32,
            'title' => 'Sửa Thuộc tính Sản phẩm',
            'name' => 'updateProductAttribute',
            'guard_name' => 'admin',
            'module_id' => 7,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('permissions')->insert([
            'id' => 33,
            'title' => 'Xóa Thuộc tính Sản phẩm',
            'name' => 'deleteProductAttribute',
            'guard_name' => 'admin',
            'module_id' => 7,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);


        DB::table('permissions')->insert([
            'id' => 34,
            'title' => 'Xem Danh mục Sản phẩm',
            'name' => 'viewProductCategory',
            'guard_name' => 'admin',
            'module_id' => 8,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('permissions')->insert([
            'id' => 35,
            'title' => 'Thêm Danh mục Sản phẩm',
            'name' => 'createProductCategory',
            'guard_name' => 'admin',
            'module_id' => 8,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('permissions')->insert([
            'id' => 36,
            'title' => 'Sửa Danh mục Sản phẩm',
            'name' => 'updateProductCategory',
            'guard_name' => 'admin',
            'module_id' => 8,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('permissions')->insert([
            'id' => 37,
            'title' => 'Xóa Danh mục Sản phẩm',
            'name' => 'deleteProductCategory',
            'guard_name' => 'admin',
            'module_id' => 8,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('permissions')->insert([
            'id' => 38,
            'title' => 'Xem Slider',
            'name' => 'viewSlider',
            'guard_name' => 'admin',
            'module_id' => 10,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('permissions')->insert([
            'id' => 39,
            'title' => 'Thêm Slider',
            'name' => 'createSlider',
            'guard_name' => 'admin',
            'module_id' => 10,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('permissions')->insert([
            'id' => 40,
            'title' => 'Sửa Slider',
            'name' => 'updateSlider',
            'guard_name' => 'admin',
            'module_id' => 10,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('permissions')->insert([
            'id' => 41,
            'title' => 'Xóa Slider',
            'name' => 'deleteSlider',
            'guard_name' => 'admin',
            'module_id' => 10,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('permissions')->insert([
            'id' => 42,
            'title' => 'Xem Slider Item',
            'name' => 'viewSliderItem',
            'guard_name' => 'admin',
            'module_id' => 11,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);


        DB::table('permissions')->insert([
            'id' => 43,
            'title' => 'Thêm Slider Item',
            'name' => 'createSliderItem',
            'guard_name' => 'admin',
            'module_id' => 11,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('permissions')->insert([
            'id' => 44,
            'title' => 'Sửa Slider Item',
            'name' => 'updateSliderItem',
            'guard_name' => 'admin',
            'module_id' => 11,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('permissions')->insert([
            'id' => 45,
            'title' => 'Xóa Slider Item',
            'name' => 'deleteSliderItem',
            'guard_name' => 'admin',
            'module_id' => 11,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('permissions')->insert([
            'id' => 46,
            'title' => 'Cài đặt chung',
            'name' => 'settingGeneral',
            'guard_name' => 'admin',
            'module_id' => null,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        /** start Area */
        DB::table('permissions')->insert([
            'id' => 47,
            'title' => 'Thêm khu vực',
            'name' => 'createArea',
            'guard_name' => 'admin',
            'module_id' => 12,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('permissions')->insert([
            'id' => 48,
            'title' => 'Sửa khu vực ',
            'name' => 'updateArea',
            'guard_name' => 'admin',
            'module_id' => 12,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('permissions')->insert([
            'id' => 49,
            'title' => 'Xoá khu vực',
            'name' => 'deleteArea',
            'guard_name' => 'admin',
            'module_id' => 12,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('permissions')->insert([
            'id' => 50,
            'title' => 'Xem khu vực',
            'name' => 'viewArea',
            'guard_name' => 'admin',
            'module_id' => 12,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('role_has_permissions')->insert([
            'permission_id' => 47,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 48,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 49,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 50,
            'role_id' => 1
        ]);
        /** End Area */

        /** start Store Category */
        DB::table('permissions')->insert([
            'id' => 51,
            'title' => 'Thêm danh mục cửa hàng',
            'name' => 'createStoreCategory',
            'guard_name' => 'admin',
            'module_id' => 13,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('permissions')->insert([
            'id' => 52,
            'title' => 'Sửa danh mục cửa hàng',
            'name' => 'updateStoreCategory',
            'guard_name' => 'admin',
            'module_id' => 13,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('permissions')->insert([
            'id' => 53,
            'title' => 'Xoá danh mục cửa hàng',
            'name' => 'deleteStoreCategory',
            'guard_name' => 'admin',
            'module_id' => 13,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('permissions')->insert([
            'id' => 54,
            'title' => 'Xem danh mục cửa hàng',
            'name' => 'viewStoreCategory',
            'guard_name' => 'admin',
            'module_id' => 13,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('role_has_permissions')->insert([
            'permission_id' => 51,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 52,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 53,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 54,
            'role_id' => 1
        ]);
        /** End Store Category */

        /** start Notification */
        DB::table('permissions')->insert([
            'id' => 59,
            'title' => 'Thêm thông báo',
            'name' => 'createNotification',
            'guard_name' => 'admin',
            'module_id' => 15,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('permissions')->insert([
            'id' => 60,
            'title' => 'Sửa thông báo',
            'name' => 'updateNotification',
            'guard_name' => 'admin',
            'module_id' => 15,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('permissions')->insert([
            'id' => 61,
            'title' => 'Xoá thông báo',
            'name' => 'deleteNotification',
            'guard_name' => 'admin',
            'module_id' => 15,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('permissions')->insert([
            'id' => 62,
            'title' => 'Xem thông báo',
            'name' => 'viewNotification',
            'guard_name' => 'admin',
            'module_id' => 15,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('role_has_permissions')->insert([
            'permission_id' => 59,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 60,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 61,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 62,
            'role_id' => 1
        ]);
        /** End Notification */

        /** start Permission Driver */
        DB::table('permissions')->insert([
            'id' => 63,
            'title' => 'Thêm tài xế',
            'name' => 'createDriver',
            'guard_name' => 'admin',
            'module_id' => 16,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('permissions')->insert([
            'id' => 64,
            'title' => 'Sửa tài xế',
            'name' => 'updateDriver',
            'guard_name' => 'admin',
            'module_id' => 16,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('permissions')->insert([
            'id' => 65,
            'title' => 'Xoá tài xế',
            'name' => 'deleteDriver',
            'guard_name' => 'admin',
            'module_id' => 16,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('permissions')->insert([
            'id' => 66,
            'title' => 'Xem tài xế',
            'name' => 'viewDriver',
            'guard_name' => 'admin',
            'module_id' => 16,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('role_has_permissions')->insert([
            'permission_id' => 63,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 64,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 65,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 66,
            'role_id' => 1
        ]);
        /** End Permission Driver */


        /** start Permission Store */
        DB::table('permissions')->insert([
            'id' => 67,
            'title' => 'Thêm cửa hàng',
            'name' => 'createStore',
            'guard_name' => 'admin',
            'module_id' => 17,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('permissions')->insert([
            'id' => 68,
            'title' => 'Sửa cửa hàng',
            'name' => 'updateStore',
            'guard_name' => 'admin',
            'module_id' => 17,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('permissions')->insert([
            'id' => 69,
            'title' => 'Xoá cửa hàng',
            'name' => 'deleteStore',
            'guard_name' => 'admin',
            'module_id' => 17,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('permissions')->insert([
            'id' => 70,
            'title' => 'Xem cửa hàng',
            'name' => 'viewStore',
            'guard_name' => 'admin',
            'module_id' => 17,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 67,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 68,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 69,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 70,
            'role_id' => 1
        ]);
        // end Permission Store

        /** start Permission Category */
        DB::table('permissions')->insert([
            'id' => 71,
            'title' => 'Thêm danh mục',
            'name' => 'createCategory',
            'guard_name' => 'admin',
            'module_id' => 18,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('permissions')->insert([
            'id' => 72,
            'title' => 'Sửa danh mục',
            'name' => 'updateCategory',
            'guard_name' => 'admin',
            'module_id' => 18,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('permissions')->insert([
            'id' => 73,
            'title' => 'Xoá danh mục',
            'name' => 'deleteCategory',
            'guard_name' => 'admin',
            'module_id' => 18,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('permissions')->insert([
            'id' => 74,
            'title' => 'Xem danh mục',
            'name' => 'viewCategory',
            'guard_name' => 'admin',
            'module_id' => 18,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('role_has_permissions')->insert([
            'permission_id' => 71,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 72,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 73,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 74,
            'role_id' => 1
        ]);

        // end Permission Category

        /** start Permission Discount Code */
        DB::table('permissions')->insert([
            'id' => 75,
            'title' => 'Thêm mã giảm giá',
            'name' => 'createDiscountCode',
            'guard_name' => 'admin',
            'module_id' => 19,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('permissions')->insert([
            'id' => 76,
            'title' => 'Sửa mã giảm giá',
            'name' => 'updateDiscountCode',
            'guard_name' => 'admin',
            'module_id' => 19,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('permissions')->insert([
            'id' => 77,
            'title' => 'Xoá mã giảm giá',
            'name' => 'deleteDiscountCode',
            'guard_name' => 'admin',
            'module_id' => 19,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('permissions')->insert([
            'id' => 78,
            'title' => 'Xem mã giảm giá',
            'name' => 'viewDiscountCode',
            'guard_name' => 'admin',
            'module_id' => 19,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('role_has_permissions')->insert([
            'permission_id' => 75,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 76,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 77,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 78,
            'role_id' => 1
        ]);

        /** End Permission DiscountCode */

        /** start Permission Topping */
        DB::table('permissions')->insert([
            'id' => 79,
            'title' => 'Thêm topping',
            'name' => 'createTopping',
            'guard_name' => 'admin',
            'module_id' => 20,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('permissions')->insert([
            'id' => 80,
            'title' => 'Sửa topping',
            'name' => 'updateTopping',
            'guard_name' => 'admin',
            'module_id' => 20,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('permissions')->insert([
            'id' => 81,
            'title' => 'Xoá topping',
            'name' => 'deleteTopping',
            'guard_name' => 'admin',
            'module_id' => 20,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('permissions')->insert([
            'id' => 82,
            'title' => 'Xem topping',
            'name' => 'viewTopping',
            'guard_name' => 'admin',
            'module_id' => 20,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('role_has_permissions')->insert([
            'permission_id' => 79,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 80,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 81,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 82,
            'role_id' => 1
        ]);

        /** End Permission Topping */

        /** start Permission Vehicle */
        DB::table('permissions')->insert([
            'id' => 83,
            'title' => 'Thêm phương tiện',
            'name' => 'createVehicle',
            'guard_name' => 'admin',
            'module_id' => 21,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('permissions')->insert([
            'id' => 84,
            'title' => 'Sửa phương tiện',
            'name' => 'updateVehicle',
            'guard_name' => 'admin',
            'module_id' => 21,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('permissions')->insert([
            'id' => 85,
            'title' => 'Xoá phương tiện',
            'name' => 'deleteVehicle',
            'guard_name' => 'admin',
            'module_id' => 21,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);
        DB::table('permissions')->insert([
            'id' => 86,
            'title' => 'Xem phương tiện',
            'name' => 'viewVehicle',
            'guard_name' => 'admin',
            'module_id' => 21,
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()')
        ]);

        DB::table('role_has_permissions')->insert([
            'permission_id' => 83,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 84,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 85,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 86,
            'role_id' => 1
        ]);

        /** End Permission Vehicle */


        //seeding model_has_roles
        DB::table('model_has_roles')->insert([
            'role_id' => 1,
            'model_type' => 'AppModelsAdmin',
            'model_id' => 1
        ]);
        //seeding role_has_permissions
        DB::table('role_has_permissions')->insert([
            'permission_id' => 1,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 2,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 3,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 4,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 5,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 6,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 7,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 8,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 9,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 10,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 11,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 12,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 13,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 14,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 15,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 16,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 17,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 18,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 19,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 20,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 21,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 22,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 23,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 24,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 25,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 26,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 27,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 28,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 29,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 30,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 31,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 32,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 33,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 34,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 35,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 36,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 37,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 38,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 39,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 40,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 41,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 42,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 43,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 44,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 45,
            'role_id' => 1
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 46,
            'role_id' => 1
        ]);
    }
}
