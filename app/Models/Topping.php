<?php

namespace App\Models;

use App\Enums\DefaultStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topping extends Model
{
    use HasFactory;

    protected $table = 'toppings';

    protected $guarded = [];
    protected $casts = [];


    public function products()
    {
        return $this->belongsToMany(Product::class, 'topping_product', 'product_id', 'topping_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeHasProducts($query, array $productId)
    {
        return $query->whereHas('products', function ($query) use ($productId) {
            $query->whereIn('products.id', $productId);
        });
    }

}