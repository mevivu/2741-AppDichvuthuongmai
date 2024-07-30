<?php

namespace App\Api\V1\Http\Controllers\Review;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\Review\ReviewRequest;
use App\Api\V1\Services\Review\ReviewServiceInterface;
use App\Api\V1\Support\Response;
use App\Api\V1\Support\UseLog;
use Illuminate\Http\JsonResponse;
use Mockery\Exception;
use App\Api\V1\Http\Resources\Review\{ReviewResource, ShowReviewResource};
use App\Api\V1\Repositories\Review\ReviewRepositoryInterface;

/**
 * @group Đánh giá sản phẩm
 */

class ReviewController extends Controller
{
    use Response, UseLog;
    public function __construct(
        ReviewServiceInterface $service,
        ReviewRepositoryInterface $repository
    )
    {
        $this->service = $service;
        $this->repository = $repository;
    }

    /**
     * Danh sách review của sản phẩm
     *
     * Lấy danh sách review của sản phẩm.
     *
     * @headersParam X-TOKEN-ACCESS string required
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @queryParam product_id integer required
     * id sản phẩm. Example: 1
     *
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": [
     *          {
     *              "id": 10,
     *               "fullname": "Tran Van A",
     *               "avatar": "http://domain.com/public/assets/images/default-image.png",
     *               "content": "content",
     *               "rating": 5
     *           }
     *      ]
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */

    public function index(ReviewRequest $request): JsonResponse{
        try {
        $reviews = $this->service->index($request);
            return $this->jsonResponseSuccess($reviews);
        }catch (Exception $e){
            $this->logError('Review filtering failed:', $e);
            return $this->jsonResponseError('',500);
        }
    }

    /**
     * Tạo đánh giá
     *
     * Tạo đánh giá cho sản phẩm.
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @bodyParam product_id integer required
     * id sản phẩm. Example: 1
     *
     * @bodyParam rating integer required
     * Xếp hạng đánh giá. Example: 5
     *
     * @bodyParam content string
     * Nội dung đánh giá. Example: content
     *
     * @authenticated
     *
     * @response {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *       "data": {
     *            "id": 10,
     *            "fullname": "Tran Van A",
     *            "avatar": "http://domain.com/public/assets/images/default-image.png",
     *            "content": "content",
     *            "rating": 5
     *      }
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */

    public function store(ReviewRequest $request):JsonResponse{
        try {
            $response = $this->service->store($request);
            return $this->jsonResponseSuccess($response);
        }catch(Exception $e){
            $this->logError('Review creation failed:', $e);
            return $this->jsonResponseError('',500);
        }
    }


    /**
     * Lọc đánh giá theo số sao
     *
     * Lọc danh sách đánh giá của sản phẩm theo số sao.
     *
     * @headersParam X-TOKEN-ACCESS string required
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @queryParam product_id integer required
     * id sản phẩm. Example: 1
     *
     * @queryParam rating integer
     * số sao của đánh giá. Example: 5
     *
     * @queryParam per_page integer
     * số lượng đánh giá mỗi trang. Example: 10
     *
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": {
     *          "current_page": 1,
     *          "data": [
     *              {
     *                  "id": 10,
     *                  "fullname": "Tran Van A",
     *                  "avatar": "http://domain.com/public/assets/images/default-image.png",
     *                  "content": "content",
     *                  "rating": 5
     *              }
     *          ],
     *          "last_page": 1,
     *          "per_page": 10,
     *          "total": 1
     *      }
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function filter(ReviewRequest $request): JsonResponse
    {
        try {
            $reviews = $this->service->filterReviews($request);
            return $this->jsonResponseSuccess($reviews);
        } catch (Exception $e) {
            $this->logError('Review filtering failed:', $e);
            return $this->jsonResponseError('', 500);
        }
    }



}
