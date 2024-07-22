<?php

namespace App\Models;

use App\Enums\DefaultStatus;
use App\Enums\Product\StockStatus;
use App\Supports\Eloquent\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use App\Enums\Product\ProductType;

class Product extends Model
{
    use HasFactory, Sluggable;

    protected $table = 'products';

    protected $guarded = [];
    protected $columnSlug = 'name';


    protected static function boot()
    {
        parent::boot();
    }

    protected $casts = [
        'gallery' => AsArrayObject::class,
        'type' => ProductType::class,
        'is_active' => 'boolean',
        'in_stock' => 'boolean',
        'price' => 'double',
        'promotion_price' => 'double'
    ];
    public function isSimple()
    {
        return $this->type == ProductType::Simple();
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'products_categories', 'product_id', 'category_id')->orderBy('position', 'asc');
    }
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, ProductAttribute::class, 'product_id', 'attribute_id')->orderBy('position', 'asc');
    }
    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id')->orderBy('position', 'asc');
    }

    public function productVariations()
    {
        return $this->hasMany(ProductVariation::class, 'product_id')->orderBy('position', 'asc');
    }
    public function productVariation()
    {
        return $this->hasOne(ProductVariation::class, 'product_id');
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    public function scopeUserDiscount($query)
    {
        return $query->where('is_user_discount', true);
    }
    public function scopeSimple($query)
    {
        return $query->where('type', ProductType::Simple);
    }
    public function scopeVariable($query)
    {
        return $query->where('type', ProductType::Variable);
    }
    public function toppings(): BelongsToMany
    {
        return $this->belongsToMany(Topping::class, 'topping_product', 'product_id', 'topping_id')->orderBy('position', 'asc');
    }
}
