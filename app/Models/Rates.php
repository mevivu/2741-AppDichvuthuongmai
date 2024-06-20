<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Rates extends Model
{
    use  HasApiTokens, HasFactory, Notifiable;

    protected $table = 'driver_activity_rates';

    protected $fillable = [
        'driver_id',
        'order_acceptance_rate',
        'order_completion_rate',
        'order_cancellation_rate',
    ];

    protected $casts = [
        'order_acceptance_rate' => 'double',
        'order_completion_rate' => 'double',
        'order_cancellation_rate' => 'double',
    ];

    public function driver(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Driver::class, 'id', 'user_id');
    }
}
