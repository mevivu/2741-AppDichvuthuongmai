<?php

use App\Enums\Order\OrderStatus;
use App\Enums\Order\OrderType;
use App\Enums\Payment\PaymentMethod;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->unsignedBigInteger('store_id')->nullable();
            $table->unsignedBigInteger('vehicle_id')->nullable();

            $table->double('start_latitude', 10, 6)->nullable();
            $table->double('start_longitude', 10, 6)->nullable();
            $table->string('start_address', 255)->nullable();
            $table->double('end_latitude', 10, 6)->nullable();
            $table->double('end_longitude', 10, 6)->nullable();
            $table->string('end_address', 255)->nullable();
            $table->double('sub_total')->nullable();
            $table->string('payment_code')->nullable();
            $table->tinyInteger('shipping_method')->nullable();
            $table->tinyInteger('payment_method')->default(PaymentMethod::Online->value);
            $table->text('shipping_address')->nullable();
            $table->tinyInteger('order_type')->default(OrderType::Booking->value);
            $table->double('total');
            $table->unsignedInteger('passenger_count')->default(1);
            $table->unsignedInteger('luggage_count')->default(1);
            $table->dateTime('departure_time')->nullable();
            $table->dateTime('return_time')->nullable();
            $table->tinyInteger('status')->default(OrderStatus::Pending->value);
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('driver_id')
                ->references('id')
                ->on('drivers')
                ->onDelete('set null');
            $table->foreign('store_id')
                ->references('id')
                ->on('stores')
                ->onDelete('set null');
            $table->foreign('vehicle_id')
                ->references('id')
                ->on('vehicles')
                ->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
