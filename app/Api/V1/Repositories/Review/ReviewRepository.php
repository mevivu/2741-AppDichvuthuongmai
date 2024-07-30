<?php

namespace App\Api\V1\Repositories\Review;

use App\Admin\Repositories\EloquentRepository;
use App\Api\V1\Repositories\Review\ReviewRepositoryInterface;
use App\Models\Review;

class ReviewRepository extends EloquentRepository implements ReviewRepositoryInterface
{
    public function getModel()
    {
        return Review::class;
    }

    public function getByProductId($product_id){
        $this->instance = $this->model->where('product_id', $product_id)
        ->with('user')
        ->get();
        return $this->instance;
    }
    public function createAuthCurrent($data){
        $this->instance = auth('sanctum')->user()->reviews()->create($data);
        return $this->instance;
    }
    public function store(array $data)
    {
        return $this->model->create($data);
    }
    public function filterByRating($product_id, $rating = null, $perPage)
    {
        $query = $this->model::where('product_id', $product_id);

        if ($rating !== null) {
            $query->where('rating', $rating);
        }

        return $query->with('user')->paginate($perPage);
    }

}
