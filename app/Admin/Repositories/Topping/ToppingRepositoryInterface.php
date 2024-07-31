<?php

namespace App\Admin\Repositories\Topping;

use App\Admin\Repositories\EloquentRepositoryInterface;
use App\Models\Topping;

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
    public function findOrFailWithRelations($id, array $relations = ['products']);
    public function attachProducts(Topping $topping, array $productsId);
    public function syncProducts(Topping $topping, array $productsId);
    public function getAllProducts();











}