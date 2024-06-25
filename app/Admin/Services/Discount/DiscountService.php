<?php

namespace App\Admin\Services\Discount;

use  App\Admin\Repositories\Discount\DiscountApplicationRepositoryInterface;
use  App\Admin\Repositories\Discount\DiscountRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class DiscountService implements DiscountServiceInterface
{
    /**
     * Current Object instance
     *
     * @var array
     */
    protected array $data;

    protected DiscountRepositoryInterface $repository;

    public function __construct(
        DiscountRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


    public function update(Request $request): object|bool
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();
            $discountId = $data['id'];

            $storeIds = $data['store_ids'] ?? [];
            $userIds = $data['user_ids'] ?? [];

            $discount = $this->repository->update($discountId, $data);
            $discount->stores()->sync($storeIds);
            $discount->users()->sync($userIds);
            DB::commit();
            return $discount;
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Discount update failed:', [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public function delete($id): object|bool
    {
        return $this->repository->delete($id);
    }


    /**
     * @throws Exception
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();
            $store_ids = $data['store_ids'];
            $user_ids = $data['user_ids'];

            $discount = $this->repository->create($data);
            $discountId = $discount->id;
            $this->repository->attachRelations($discountId, $store_ids, 'stores');

            $this->repository->attachRelations($discountId, $user_ids, 'users');

            DB::commit();

            return $discount;
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Failed to create discount:', [
                'error' => $e->getMessage()
            ]);
            return false;


        }
    }
}
