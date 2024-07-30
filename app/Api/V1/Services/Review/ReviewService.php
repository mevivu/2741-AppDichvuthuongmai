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

    public function createReview(Request $request):object
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
//           return false;
        }
    }
    public function filterReviews(Request $request): object
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'stars' => 'nullable|integer|min:1|max:5',
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);
        $productId = $request->query('product_id');
        $rating = $request->query('rating');
        $perPage = $request->query('per_page', 10);
        $query = $this->repository->getModel()->where('product_id', $productId);
        if (!is_null($rating)) {
            $query->where('rating', $rating);
        }
        return $query->with('user')->paginate($perPage);
    }


}
