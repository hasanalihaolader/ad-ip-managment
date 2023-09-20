<?php

namespace App\Repositories;

use App\Models\IpAddress;
use Illuminate\Support\Facades\DB;

class IpManagementRepository extends Repository
{
    /*
    |--------------------------------------------------------------------------
    | CONSTANTS
    |--------------------------------------------------------------------------
   */
    public static function model()
    {
        return IpAddress::class;
    }

    public static function createOrUpdate($request)
    {
        DB::beginTransaction();
            $is_performed = self::model()::updateOrCreate([
                self::model()::ID => $request->{self::model()::ID},
            ], [
                self::model()::IP => $request->{self::model()::IP},
                self::model()::LABEL => $request->{self::model()::LABEL},
            ]);
        DB::commit();
        return $is_performed;
    }
}
