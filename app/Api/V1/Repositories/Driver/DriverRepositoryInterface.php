<?php

namespace App\Api\V1\Repositories\Driver;

interface DriverRepositoryInterface
{

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);



}
