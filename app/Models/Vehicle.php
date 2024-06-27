<?php

namespace App\Models;

use App\Enums\Vehicle\VehicleStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Vehicle\VehicleType;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehicle extends Model
{
    use HasFactory;

    protected $table = 'vehicles';
    protected $fillable = [
        'driver_id',
        'name',
        'brand',
        'color',
        'type',
        'seat_number',
        'license_plate',
        'price',
        'amenities',
        'description',
        'avatar',
        'status'
    ];

    protected $casts = [
        'name' => 'string',
        'brand' => 'string',
        'color' => 'string',
        'seat_number' => 'integer',
        'license_plate' => 'string',
        'type' => VehicleType::class,
        'status' => VehicleStatus::class
    ];

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }


}
