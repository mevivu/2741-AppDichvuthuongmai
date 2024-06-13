<?php

use App\Enums\Store\StoreStatus;
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
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('area_id');
            $table->string('code')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('store_name');
            $table->char('store_phone', 20)->unique();
            $table->string('contact_name');
            $table->char('contact_email', 100)->nullable();
            $table->char('contact_phone', 20);
            $table->text('logo')->nullable();
            $table->text('address')->nullable();
            $table->text('address_detail')->nullable();
            $table->string('tax_code')->nullable();
            $table->time('open_hours_1')->nullable();
            $table->time('close_hours_1')->nullable();
            $table->time('open_hours_2')->nullable();
            $table->time('close_hours_2')->nullable();
            $table->tinyInteger('status')->default(StoreStatus::Open->value);
            $table->integer('priority')->default(0);
            $table->double('lng');
            $table->double('lat');
            $table->string('token_get_password')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->text('device_token')->nullable();

            $table->foreign('category_id')->references('id')
                ->on('store_categories')
                ->onDelete('cascade');

            $table->foreign('area_id')
                ->references('id')
                ->on('areas')
                ->onDelete('cascade');

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store');
    }
};
