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
    public function getFlatTreeNotInNode(array $nodeId);

}