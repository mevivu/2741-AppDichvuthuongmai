<?php

namespace App\Api\V1\Repositories\Driver;

use App\Admin\Repositories\EloquentRepositoryInterface;

interface DriverRepositoryInterface extends EloquentRepositoryInterface
{

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);



}
