<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\Setting\SettingTypeInput;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('settings')->truncate();
        DB::table('settings')->insert([
            [
                'setting_key' => 'site_name',
                'setting_name' => 'Tên site',
                'plain_value' => 'Topzone',
                'type_input' => SettingTypeInput::Text,
                'group' => 1
            ],
            [
                'setting_key' => 'site_logo',
                'setting_name' => 'Logo',
                'plain_value' => '/public/assets/images/logo.png',
                'type_input' => SettingTypeInput::Image,
                'group' => 1
            ],
            [
                'setting_key' => 'email',
                'setting_name' => 'Email',
                'plain_value' => 'mevivu@gmail.com',
                'type_input' => SettingTypeInput::Email,
                'group' => 1
            ],
            [
                'setting_key' => 'holine',
                'setting_name' => 'Số điện thoại',
                'plain_value' => '0999999999',
                'type_input' => SettingTypeInput::Phone,
                'group' => 1
            ],
            [
                'setting_key' => 'user_vip_default',
                'setting_name' => 'Thành viên mặc định (%)',
                'plain_value' => 0,
                'type_input' => SettingTypeInput::Number,
                'group' => 2
            ],
            [
                'setting_key' => 'user_vip_bronze',
                'setting_name' => 'Thành viên đồng (%)',
                'plain_value' => 1,
                'type_input' => SettingTypeInput::Number,
                'group' => 2
            ],
            [
                'setting_key' => 'user_vip_silver',
                'setting_name' => 'Thành viên bạc (%)',
                'plain_value' => 2,
                'type_input' => SettingTypeInput::Number,
                'group' => 2
            ],
            [
                'setting_key' => 'user_vip_gold',
                'setting_name' => 'Thành viên vàng (%)',
                'plain_value' => 3,
                'type_input' => SettingTypeInput::Number,
                'group' => 2
            ],
            [
                'setting_key' => 'user_vip_diamond',
                'setting_name' => 'Thành viên kim cương (%)',
                'plain_value' => 4,
                'type_input' => SettingTypeInput::Number,
                'group' => 2
            ],
            [
                'setting_key' => 'quantity_product_up_bronze',
                'setting_name' => 'Nâng cấp thành viên đồng (SP)',
                'plain_value' => 1,
                'type_input' => SettingTypeInput::Number,
                'group' => 3
            ],
            [
                'setting_key' => 'quantity_product_up_silver',
                'setting_name' => 'Nâng cấp thành viên bạc (SP)',
                'plain_value' => 2,
                'type_input' => SettingTypeInput::Number,
                'group' => 3
            ],
            [
                'setting_key' => 'quantity_product_up_gold',
                'setting_name' => 'Nâng cấp thành viên vàng (SP)',
                'plain_value' => 5,
                'type_input' => SettingTypeInput::Number,
                'group' => 3
            ],
            [
                'setting_key' => 'quantity_product_up_diamond',
                'setting_name' => 'Nâng cấp thành viên kim cương (SP)',
                'plain_value' => 10,
                'type_input' => SettingTypeInput::Number,
                'group' => 3
            ],
        ]);
    }
}
