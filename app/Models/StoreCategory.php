<?php

namespace App\Models;

use App\Admin\Support\Eloquent\Sluggable;
use App\Enums\DefaultStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class StoreCategory extends Model
{
    use HasFactory, NodeTrait, Sluggable;

    protected $table = 'store_categories';

    protected $guarded = [];

    protected $casts = [
        'status' => DefaultStatus::class
    ];

    public function scopePublished($query): void
    {
        $query->where('status', DefaultStatus::Published);
    }
}
