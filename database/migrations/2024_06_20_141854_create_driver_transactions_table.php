<?php

use App\Enums\Driver\DriverTransactionStatus;
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
        Schema::create('driver_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('driver_id');
            $table->unsignedBigInteger('order_id');
            $table->string('transaction_code')->nullable();
            $table->double('amount')->default(0);
            $table->text('description')->nullable();
            $table->text('feature_image')->nullable();
            $table->text('gallery')->nullable();
            $table->double('system_debt_file')->default(0);
            $table->tinyInteger('status')->default(DriverTransactionStatus::Pending->value);
            $table->timestamps();

            $table->foreign('driver_id')->references('id')
                ->on('drivers')->onDelete('cascade');
            $table->foreign('order_id')->references('id')
                ->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver_transactions');
    }
};
