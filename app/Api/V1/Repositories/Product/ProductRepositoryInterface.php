<?php

namespace App\Api\V1\Repositories\Product;

interface ProductRepositoryInterface
{
    public function findOrFail($id);
    
    public function getByCategoriesWithRelations(array $categories_id = [], array $relations = ['productVariations']);

    public function findOrFailWithRelations($id, array $relations = []);

    public function getAllWithRelations(array $relations = ['productVariations']);

    public function getSearchByKeysWithRelations(array $data, array $relations = ['productVariations']);

    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC');
}