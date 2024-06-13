<?php

namespace App\Admin\Services\Driver;
use Illuminate\Http\Request;

use App\Admin\Repositories\Order\OrderRepositoryInterface;
use App\Admin\Repositories\User\UserRepositoryInterface;
use App\Admin\Repositories\Driver\DriverRepository;
use App\Enums\Driver\AutoAccept;
use App\Enums\User\UserRoles;
use App\Events\DriverCreated;
use Illuminate\Support\Facades\DB;
interface DriverServiceInterface
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
    public function delete($id,$userId);


}
