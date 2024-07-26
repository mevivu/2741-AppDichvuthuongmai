<?php

namespace App\Store\Services\Product;

use Illuminate\Http\Request;

interface ProductServiceInterface
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
     * @param  $id
     *
     */
    public function delete($id);

}
