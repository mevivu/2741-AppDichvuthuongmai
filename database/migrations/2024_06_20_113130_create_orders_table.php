<?php

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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->char('code', 50)->unique();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->unsignedBigInteger('store_id');
            $table->text('pickup_address');
            $table->double('lat');
            $table->double('lng');
            $table->text('destination_address');
            $table->text('shipping_address')->nullable();
            $table->tinyInteger('shipping_method');
            $table->tinyInteger('payment_method');
            $table->double('sub_total');
            $table->double('transport_fee')->nullable();
            $table->double('total');
            $table->double('discount_amount')->default(0);
            $table->double('points_used')->default(0);
            $table->double('system_revenue')->nullable();
            $table->text('note')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('users');
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('set null');
            $table->foreign('store_id')->references('id')->on('stores');
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
