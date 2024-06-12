<?php

namespace App\Api\V1\Repositories\Category;

interface CategoryRepositoryInterface
{
    public function getTree();
    
    public function findByIdOrSlug($idOrSlug);

    public function findByIdOrSlugWithAncestorsAndDescendants($idOrSlug);

    public function getRootWithAllChildren();
}