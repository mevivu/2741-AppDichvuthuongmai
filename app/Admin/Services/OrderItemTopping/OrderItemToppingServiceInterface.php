<?php

namespace App\Admin\Services\OrderItemTopping;

use Illuminate\Http\Request;

interface OrderItemToppingServiceInterface
{

    public function store(Request $request);

    public function update(Request $request);

    public function delete($id);

}
