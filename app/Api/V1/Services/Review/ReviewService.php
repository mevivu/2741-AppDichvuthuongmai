<?php

namespace App\Api\V1\Services\Review;

use App\Api\V1\Repositories\Review\ReviewRepositoryInterface;
use App\Api\V1\Support\AuthServiceApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Api\V1\Support\AuthSupport;

class ReviewService implements ReviewServiceInterface{
    use AuthSupport, AuthServiceApi;

    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    protected ReviewRepositoryInterface $repository;

    public function __construct(
        ReviewRepositoryInterface $repository,
    )
    {
        $this->repository = $repository;
    }

    public function store(Request $request):object
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $userId = $this->getCurrentUserId();
            $data['user_id'] = $userId;
            $review = $this->repository->create($data);
            DB::commit();
            return $review;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;

        }
    }
    public function filterReviews(Request $request): object
    {
        $data = $request->validated();
        $perPage = $request->query('per_page', 10);
        return $this->repository->filterByRating($data['product_id'], $data['rating'], $perPage);
    }



}
