<?php

namespace App\Admin\Repositories\VehicleOwner;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface VehicleOwnerRepositoryInterface extends EloquentRepositoryInterface
{
    public function searchAllLimit($keySearch = '', $meta = [], $limit = 10);
}
