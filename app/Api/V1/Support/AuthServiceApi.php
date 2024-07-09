<?php

namespace App\Api\V1\Support;

use App\Api\V1\Repositories\Driver\DriverRepositoryInterface;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;


trait AuthServiceApi
{
    private static string $GUARD_API = 'api';

    private static string $GUARD_API_STORE = 'store-api';


    public function getCurrentUserId()
    {

        return auth(self::$GUARD_API)->user()->id;
    }

    public function getCurrentUser(): ?Authenticatable
    {
        return auth(self::$GUARD_API)->user();
    }

    public function getCurrentStoreId()
    {
        return auth(self::$GUARD_API_STORE)->user()->id;
    }

    public function getCurrentStoreUser():?Authenticatable{
        return auth(self::$GUARD_API_STORE)->user();
    }

    /**
     * @throws Exception
     */
    public function getCurrentDriver(){
        $driverRepository = app(DriverRepositoryInterface::class);
        $userId = $this->getCurrentUserId();
        return $driverRepository->findByField('user_id', $userId);
    }

    /**
     * @throws Exception
     */
    public function getCurrentDriverId(){
        $userId = $this->getCurrentUserId();
        $driverRepository = app(DriverRepositoryInterface::class);
        return $driverRepository->findByField('user_id', $userId)->id;
    }
   

}
