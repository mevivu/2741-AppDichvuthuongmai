<?php

use App\Enums\DefaultStatus;
use App\Enums\Product\ProductInStock;
use App\Enums\Product\ProductManagerStock;
use App\Enums\Product\ProductStatus;
use App\Enums\Product\ProductType;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->double('price')->nullable();
            $table->double('selling_price')->nullable();
            $table->double('promotion_price')->nullable();
            $table->string('sku')->nullable();
            $table->integer('qty')->nullable();
            $table->tinyInteger('type')->default(ProductType::Simple->value);
            $table->tinyInteger('manager_stock')->default(ProductManagerStock::NotManaged->value);
            $table->tinyInteger('in_stock')->default(ProductInStock::InStock->value);
            $table->tinyInteger('is_active')->default(ProductStatus::Active->value);
            $table->text('avatar')->nullable();
            $table->longText('gallery')->nullable();
            $table->longText('desc')->nullable();
            $table->longText('informations')->nullable();

            $table->tinyInteger('is_deleted')->default(DefaultStatus::Published->value);

            $table->unsignedBigInteger('store_id')->nullable();
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');


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
        Schema::dropIfExists('products');
    }
};
