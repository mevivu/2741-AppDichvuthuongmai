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
        Schema::create('driver_activity_rates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('driver_id');
            $table->double('order_acceptance_rate')->default(0);
            $table->double('order_completion_rate')->default(0);
            $table->double('order_cancellation_rate')->default(0);
            $table->timestamps();

            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver_activity_rates');
    }
};
