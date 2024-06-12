<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Tạo một người dùng mới
        $user = new User();
        $user->code = Str::random(10);
        $user->username = "minhhuy";
        $user->fullname = "Nguyễn Minh Huy";
        $user->email = "minhhuy122001@gmail.com";
        $user->phone = '0383476965';
        $user->address = '123 Đường ABC, Quận 1, TP.HCM';
        $user->avatar = null;
        $user->gender = 1;
        $user->email_verified_at = now();
        $user->token_get_password = Str::random(20);
        $user->password = Hash::make('123456');
        $user->active = true;
        $user->status = 1;
        $user->roles = 1;
        $user->vip = 1;


        $user->save();
    }
}
