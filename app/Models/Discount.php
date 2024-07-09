<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Discount extends Model
{
    use HasFactory;

    protected $table = 'discounts';
    protected $dates = ['date_start', 'date_end'];
    protected $fillable = [
        'code',
        'date_start',
        'date_end',
        'max_usage',
        'min_order_amount',
        'type',
        'discount_value',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'discount_applications', 'discount_code_id', 'product_id');
    }
    public function stores(): BelongsToMany
    {
        return $this->belongsToMany(Store::class, 'discount_applications', 'discount_code_id', 'store_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'discount_applications', 'discount_code_id', 'user_id');
    }
    public function drivers(): BelongsToMany
    {
        return $this->belongsToMany(Driver::class, 'discount_applications', 'discount_code_id', 'driver_id');
    }

    public function discount_applications(): HasMany
    {
        return $this->hasMany(DiscountApplication::class, 'discount_code_id', 'id');
    }


    /**
     * Check if the discount code is still active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        $now = Carbon::now();

        if ($now->greaterThan($this->date_start) && $now->lessThan($this->date_end)) {
            if ($this->max_usage !== null && $this->max_usage <= 0) {
                return false;
            }
            return true;
        }

        return false;
    }

    public function scopeActive($query)
    {
        $now = Carbon::now()->toDateTimeString();
        return $query->where('status', '=', 1)
            ->where('date_start', '<=', $now)
            ->where('date_end', '>=', $now);
    }

}
