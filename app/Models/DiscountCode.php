<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\DiscountCode\DiscountCodeStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiscountCode extends Model
{
    use HasFactory;

    protected $table = 'discount_code';

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
    }

    protected $casts = [
        'discount' => 'double',
        'apply_qty' => 'integer',
        'maximum_qty' => 'integer',
        'service_applies' => 'string',
        'conditions' => 'string',
        'time_apply' => 'datetime',
        'expiration_date' => 'datetime',
        'status' => DiscountCodeStatus::class,
    ];
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
