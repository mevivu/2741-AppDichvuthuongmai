<?php

namespace App\Admin\Services\Driver;
use Illuminate\Http\Request;

interface DriverServiceInterface
{

    public function store(Request $request);

    public function update(Request $request);

    public function delete($id,$userId);


}
