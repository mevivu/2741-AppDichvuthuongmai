<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;





return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_systems', function (Blueprint $table) {
            $table->id();
            $table->string("name", 200);
            $table->text('avatar')->nullable();
            $table->timestamps();
        });
        // module Phòng		
        // $module_id = DB::table('modules')->insertGetId([
        //     'name' => 'Quản lý Dịch Vụ',
        //     'description' => '<p>chức năng quản lý dịch vụ</p>',
        //     'status' => 2,
        //     'created_at' => DB::raw('NOW()'),
        //     'updated_at' => DB::raw('NOW()')
        // ]);
        // //Permission của module Phòng
        // DB::table('permissions')->insert([
        //     'title' => 'Xem Dịch Vụ',
        //     'name' => 'viewService',
        //     'guard_name' => 'admin',
        //     'module_id' => $module_id,
        //     'created_at' => DB::raw('NOW()'),
        //     'updated_at' => DB::raw('NOW()')
        // ]);
        // DB::table('permissions')->insert([
        //     'title' => 'Thêm Dịch Vụ',
        //     'name' => 'createService',
        //     'guard_name' => 'admin',
        //     'module_id' => $module_id,
        //     'created_at' => DB::raw('NOW()'),
        //     'updated_at' => DB::raw('NOW()')
        // ]);
        // DB::table('permissions')->insert([
        //     'title' => 'Chỉnh sửa Dịch Vụ',
        //     'name' => 'updateService',
        //     'guard_name' => 'admin',
        //     'module_id' => $module_id,
        //     'created_at' => DB::raw('NOW()'),
        //     'updated_at' => DB::raw('NOW()')
        // ]);
        // DB::table('permissions')->insert([
        //     'title' => 'Xóa Dịch VỤ',
        //     'name' => 'deleteService',
        //     'guard_name' => 'admin',
        //     'module_id' => $module_id,
        //     'created_at' => DB::raw('NOW()'),
        //     'updated_at' => DB::raw('NOW()')
        // ]);

    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_systems');
    }
};
