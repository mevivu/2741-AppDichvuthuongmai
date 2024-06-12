<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Vehicle\VehicleType;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehicle extends Model
{
    use HasFactory;

    protected $table = 'vehicles';

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
    }

    protected $casts = [
        'name' => 'string',
        'brand' => 'string',
        'color' => 'string',
        'seat_number' => 'integer',
        'license_plate' => 'string',
        'type' => VehicleType::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeCurrentAuth($query)
    {
        return $query->where('user_id', auth()->user()->id);
    }

    public function getShortDescriptionAttribute()
    {
        return substr($this->desc, 0, 100);
    }
}
