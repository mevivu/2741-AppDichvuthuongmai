<?php

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
        Schema::create('topping_product', function (Blueprint $table) {
<<<<<<< HEAD
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('topping_id');

            $table->primary(['product_id', 'topping_id']);

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('topping_id')->references('id')->on('toppings')->onDelete('cascade');
=======
            $table->id();
            $table->bigInteger('product_id')->unsigned();
            $table->bigInteger('topping_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('topping_id')->references('id')->on('toppings')->onDelete('cascade');
            $table->timestamps();
>>>>>>> 4b56050f4255d0d88105c67cfbc5436467f668fc
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
<<<<<<< HEAD
        Schema::table('topping_product', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['product_id']);
            $table->dropForeign(['topping_id']);
        });
        Schema::dropIfExists('topping_product');

=======
        Schema::dropIfExists('topping_product');
>>>>>>> 4b56050f4255d0d88105c67cfbc5436467f668fc
    }
};
