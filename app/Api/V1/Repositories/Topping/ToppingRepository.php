<?php

namespace App\Api\V1\Repositories\Topping;

<<<<<<< HEAD
use App\Admin\Repositories\Topping\ToppingRepository as AdminToppingRepository;
use App\Api\V1\Repositories\Topping\ToppingRepositoryInterface;
use App\Models\Topping;

class ToppingRepository extends AdminToppingRepository implements ToppingRepositoryInterface
=======
use App\Admin\Repositories\Topping\ToppingRepository as AdminRoomRepository;
use App\Api\V1\Repositories\Topping\ToppingRepositoryInterface;
use App\Models\Topping;

class ToppingRepository extends AdminRoomRepository implements ToppingRepositoryInterface
>>>>>>> 4b56050f4255d0d88105c67cfbc5436467f668fc
{
    public function getModel()
    {
        return Topping::class;
    }

    public function findByID($id)
    {
        $this->instance = $this->model->where('id', $id)
            ->firstOrFail();

        if ($this->instance && $this->instance->exists()) {
            return $this->instance;
        }

        return null;
    }
    public function paginate($page = 1, $limit = 10)
    {
        $page = $page ? $page - 1 : 0;
        $this->instance = $this->model
            ->offset($page * $limit)
            ->limit($limit)
            ->orderBy('id', 'desc')
            ->get();
        return $this->instance;
    }

}