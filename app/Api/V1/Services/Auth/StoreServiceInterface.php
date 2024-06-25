<?php

namespace App\Api\V1\Services\Auth;
use Illuminate\Http\Request;

interface StoreServiceInterface
{
    /**
     * Tạo mới
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request);

    /**
     * Cập nhật
     *
     * @param Request $request
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

    public function updateTokenPassword(Request $request);
    public function generateRouteGetPassword($view);
    public function getInstance();

}
