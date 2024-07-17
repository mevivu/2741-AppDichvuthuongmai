<?php

namespace App\Api\V1\Repositories\Discount;
use App\Admin\Repositories\EloquentRepositoryInterface;

interface DiscountRepositoryInterface extends EloquentRepositoryInterface
{
    public function findByID($id);
    public function paginate($page = 1, $limit = 10);
    public function getDiscountsByStoreId($storeId); // thêm dòng này
    public function getDiscountsByUserId($userId); // thêm dòng này
    public function getDiscountsByDriverId($driverId); // thêm dòng này
    public function getDiscountsByProductId($productId); // thêm dòng này
}
