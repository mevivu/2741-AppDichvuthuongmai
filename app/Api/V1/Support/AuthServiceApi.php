<?php

namespace App\Api\V1\Support;

use Illuminate\Contracts\Auth\Authenticatable;


trait AuthServiceApi
{
    private static string $GUARD_API = 'api';

    /** Api */


    public function getCurrentUserId()
    {

        return auth(self::$GUARD_API)->user()->id;
    }

    public function getCurrentUser(): ?Authenticatable
    {
        return auth(self::$GUARD_API)->user();
    }


}
