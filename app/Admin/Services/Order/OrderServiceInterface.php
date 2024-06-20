<?php

namespace App\Admin\Services\Order;
use Illuminate\Http\Request;

interface OrderServiceInterface
{
    /**
     * Tạo mới
     *
     * @var Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request);
    /**
     * Cập nhật
     *
     * @var Illuminate\Http\Request $request
     *
     * @return boolean
     */
    public function update(Request $request);
    /**
     * Xóa
     *
     * @param int $id
     *
     * @return boolean
     */
    public function delete($id);

    public function getInformationOrder(Request $request);
    public function updateOrder($order);
    public function updateOrderRefuse($order);
    public function updateStore(Request $request);
    public function getLateOrders(int $minutes);



}
