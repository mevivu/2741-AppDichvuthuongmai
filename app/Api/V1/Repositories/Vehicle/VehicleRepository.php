<?php

namespace App\Api\V1\Repositories\Vehicle;

use App\Admin\Repositories\Vehicle\VehicleRepository as AdminVehicleRepository;
use App\Api\V1\Repositories\Vehicle\VehicleRepositoryInterface;
use App\Enums\Vehicle\VehicleStatus;
use Illuminate\Http\Request;

class VehicleRepository extends AdminVehicleRepository implements VehicleRepositoryInterface
{
    public function searchVehicle(Request $request)
    {
        $filters = [['status', '=' , VehicleStatus::Pending]];

        if (isset($request['type'])) {
            $filters[] = ['type', '=', $request['type']];
        }

        if (isset($request['vehicle_company'])) {
            $filters[] = ['vehicle_company', '=', $request['vehicle_company']];
        }

        $limit = $request->input('limit', 10);
        $page = $request->input('page', 1);

        $query = $this->getQueryBuilder()->where($filters);

        return $query->paginate($limit, ['*'], 'page', $page);
    }
}
