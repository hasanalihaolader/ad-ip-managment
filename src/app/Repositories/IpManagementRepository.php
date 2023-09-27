<?php

namespace App\Repositories;

use App\Models\IpAddress;
use Illuminate\Database\Eloquent\Collection;
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

    public static function get(): Collection
    {
        return self::model()::get();
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

    public static function getById(int $id)
    {
        return self::model()::where(self::model()::ID, $id)->first();
    }
}
