<?php

namespace App\Admin\Services\Discount;

use  App\Admin\Repositories\Discount\DiscountApplicationRepositoryInterface;
use  App\Admin\Repositories\Discount\DiscountRepositoryInterface;
use Exception;
use Illuminate\Http\Request;


class DiscountService implements DiscountServiceInterface
{
    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    protected DiscountApplicationRepositoryInterface $discountApplicationRepository;
    protected DiscountRepositoryInterface $repository;

    public function __construct(DiscountApplicationRepositoryInterface $discountApplicationRepository,
                                DiscountRepositoryInterface            $repository)
    {
        $this->repository = $repository;
        $this->discountApplicationRepository = $discountApplicationRepository;
    }


    public function update(Request $request)
    {

    }

    /**
     * @throws Exception
     */
    public function delete($id): object|bool
    {
        return $this->repository->delete($id);
    }


    public function store(Request $request)
    {
        // TODO: Implement store() method.
    }
}
