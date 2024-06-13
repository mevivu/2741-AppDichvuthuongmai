<?php

use App\Enums\User\AutoNotification;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('area_id')->nullable();
            $table->char('code', 50);
            $table->char('username', 100)->unique();
            $table->string('slug')->unique();
            $table->string('fullname');
            $table->char('email', 100)->unique();
            $table->char('phone', 20)->unique();
            $table->text('address')->nullable();
            $table->text('avatar')->nullable();
            $table->date('birthday');
            $table->string('device_token')->nullable();
            $table->tinyInteger('gender');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('token_get_password')->nullable();
            $table->string('password');
            $table->boolean('active')->default(true);
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('roles');
            $table->tinyInteger('vip');
            $table->integer('notification_preference')->default(AutoNotification::Auto->value);
            $table->double('latitude', 10, 6)->nullable();
            $table->double('longitude', 10, 6)->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('area_id')->references('id')->on('areas')->onDelete('SET NULL');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
