<?php

namespace App\Admin\Repositories\Topping;

use App\Admin\Repositories\EloquentRepositoryInterface;

interface ToppingRepositoryInterface extends EloquentRepositoryInterface
{
    /**
     * make query
     *
     * @return mixed
     */
    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC');
    public function getAllRoles();
    public function getFlatTree();

    public function searchAllLimit();
<<<<<<< HEAD
    public function getFlatTreeNotInNode(array $nodeId);
=======



>>>>>>> 4b56050f4255d0d88105c67cfbc5436467f668fc

}