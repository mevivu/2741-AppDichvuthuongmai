<?php

namespace App\Models;

use App\Enums\DefaultStatus;
use App\Enums\Product\ProductInStock;
use App\Enums\Product\ProductManagerStock;
use App\Enums\Product\ProductStatus;
use App\Supports\Eloquent\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use App\Enums\Product\ProductType;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory, Sluggable;

    protected $table = 'products';

    protected $guarded = [];

    protected $fillable = [
        'type', // Loại sản phẩm
        'name', // Tên sản phẩm
        'price', // Giá sản phẩm
        'selling_price', // Giá bán
        'promotion_price', // Giá khuyến mãi
        'sku', // Mã SKU
        'manager_stock', // Quản lý kho
        'qty', // Số lượng
        'in_stock', // Còn hàng
        'is_active', // Hoạt động
        'avatar', // Ảnh
        'gallery', // Bộ sưu tập ảnh
        'desc', // Mô tả
        'informations', // Thông tin chi tiết
        'store_id', // ID cửa hàng
        'is_deleted', // Trạng thái xóa
    ];

    protected $columnSlug = 'name';


    protected static function boot()
    {
        parent::boot();
    }

    protected $casts = [
        'gallery' => AsArrayObject::class,
        'type' => ProductType::class,
        'is_active' => ProductStatus::class,
        'in_stock' => ProductInStock::class,
        'manager_stock' => ProductManagerStock::class,
        'is_deleted' => DefaultStatus::class,
        'price' => 'double',
        'promotion_price' => 'double'
    ];
    public function isSimple()
    {
        return $this->type == ProductType::Simple->value;
    }
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'products_categories', 'product_id', 'category_id')->orderBy('position', 'asc');
    }
    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, ProductAttribute::class, 'product_id', 'attribute_id')->orderBy('position', 'asc');
    }
    public function productAttributes(): HasMany
    {
        return $this->hasMany(ProductAttribute::class, 'product_id')->orderBy('position', 'asc');
    }

    public function productVariations(): HasMany
    {
        return $this->hasMany(ProductVariation::class, 'product_id')->orderBy('position', 'asc');
    }
    public function productVariation(): HasOne
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

    public function discounts(): BelongsToMany
    {
        return $this->belongsToMany(Discount::class, 'discount_applications', 'product_id', 'discount_code_id');
    }
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'product_id', 'id');
    }
}
