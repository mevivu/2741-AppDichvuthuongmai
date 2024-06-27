<?php

use App\Enums\Vehicle\VehicleStatus;
use App\Enums\Vehicle\VehicleType;
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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('driver_id');
            $table->string('name');
            $table->string('brand');
            $table->string('color');
            $table->integer('type')->default(VehicleType::Car->value);
            $table->integer('seat_number')->nullable();
            $table->string('license_plate');
            $table->double('price', 10, 2)->nullable();
            $table->text('amenities')->nullable();
            $table->text('description')->nullable();
            $table->text('avatar')->nullable();
            $table->tinyInteger('status')->default(VehicleStatus::Pending->value);
            $table->timestamps();

            $table->foreign('driver_id')
                ->references('id')
                ->on('drivers')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
};
