<?php

namespace App\Api\V1\Repositories\Review;

use App\Admin\Repositories\EloquentRepositoryInterface;

interface ReviewRepositoryInterface extends EloquentRepositoryInterface
{

    public function getByProductId($product_id);
    public function createAuthCurrent($data);
    public function filterByRating($product_id, $rating, $perPage);
    public function store(array $data);
}
