<?php

namespace App\Models;

use App\Enums\Area\AreaStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $table = 'areas';

    protected $guarded = [];

	protected $casts = [
        'status' => AreaStatus::class
    ];



}
