<?php

namespace App\Api\V1\Services\Order;
use Illuminate\Http\Request;

interface OrderServiceInterface
{

    public function store(Request $request);

    public function createBookOrder(Request $request);

    public function update(Request $request);
    public function cancel(Request $request);
    public function delete($id);



}
