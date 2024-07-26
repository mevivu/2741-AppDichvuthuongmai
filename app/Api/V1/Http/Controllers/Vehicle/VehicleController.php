<?php

namespace App\Api\V1\Http\Controllers\Vehicle;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\Vehicle\VehicleRequest;
use App\Api\V1\Http\Resources\Vehicle\VehicleResourceCollection;
use App\Api\V1\Services\Vehicle\VehicleServiceInterface;
use App\Api\V1\Repositories\Vehicle\VehicleRepositoryInterface;
use App\Api\V1\Repositories\User\UserRepositoryInterface;
use App\Api\V1\Support\AuthServiceApi;
use App\Api\V1\Support\Response;
use App\Api\V1\Support\UseLog;
use App\Traits\JwtService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * @group Đơn hàng
 */
class VehicleController extends Controller
{
    use JwtService, Response, AuthServiceApi, UseLog;

    private static string $GUARD_API = 'api';

    private $login;

    protected $auth;

    protected UserRepositoryInterface $userRepository;

    public function __construct(
        VehicleRepositoryInterface $repository,
        UserRepositoryInterface $userRepository,
        VehicleServiceInterface    $service
    ) {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->service = $service;
        $this->middleware('auth:api');
    }

    protected function resolve(): bool
    {
        $user = $this->userRepository->findByField('phone', $this->login['phone']);
        if ($user) {
            Auth::login($user);
            return true;
        }
        return false;
    }

    public function view(VehicleRequest $request): JsonResponse
    {
        $vehicles = $this->repository->searchVehicle($request);
        return response()->json([
            'status' => 200,
            'message' => __('notifySuccess'),
            'data' => new VehicleResourceCollection($vehicles)
        ]);
    }
}
