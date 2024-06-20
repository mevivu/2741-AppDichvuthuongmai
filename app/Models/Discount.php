<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function discount_applications()
    {
        return $this->hasMany(DiscountApplication::class, 'discount_code_id', 'id');
    }

    public function setIdDiscountApplicationAttribute(){
        $this->discount_applications[0]->id;
    }

    public function getIdDiscountApplicationAttribute()
    {
        return $this->discount_applications[0]->id;
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
