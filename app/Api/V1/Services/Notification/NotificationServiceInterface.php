<?php

namespace App\Api\V1\Services\Notification;
use Illuminate\Http\Request;

interface NotificationServiceInterface
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

    public function getInstance();

    public function updateDeviceToken($request);




}
