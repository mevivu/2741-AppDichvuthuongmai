<?php

use App\Enums\Driver\AutoAccept;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('vehicle_owners', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->string('avatar')->nullable();
            $table->double('lat', 10, 7);
            $table->double('lng', 10, 7);
            $table->string('address');
            $table->date('birthday')->nullable();
            $table->char('id_card')->unique();
            $table->string('id_card_front')->nullable();
            $table->string('id_card_back')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->char('bank_account_number', 20);
            $table->timestamps();

            $table->unsignedBigInteger('area_id')->nullable();
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
        Schema::dropIfExists('vehicle_owners');
    }
}

