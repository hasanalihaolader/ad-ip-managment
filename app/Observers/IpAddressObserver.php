<?php

namespace App\Observers;

use App\Models\IpAddress;

class IpAddressObserver
{
    /**
     * Handle the IpAddress "created" event.
     *
     * @param  \App\Models\IpAddress  $ipAddress
     * @return void
     */
    public function saved(IpAddress $ipAddress)
    {
        infoLog(__METHOD__, 'create', [$ipAddress]);
    }

    /**
     * Handle the IpAddress "updated" event.
     *
     * @param  \App\Models\IpAddress  $ipAddress
     * @return void
     */
    public function updated(IpAddress $ipAddress)
    {
        infoLog(__METHOD__, 'Update', [$ipAddress]);
    }

    /**
     * Handle the IpAddress "deleted" event.
     *
     * @param  \App\Models\IpAddress  $ipAddress
     * @return void
     */
    public function deleted(IpAddress $ipAddress)
    {
        //
    }

    /**
     * Handle the IpAddress "restored" event.
     *
     * @param  \App\Models\IpAddress  $ipAddress
     * @return void
     */
    public function restored(IpAddress $ipAddress)
    {
        //
    }

    /**
     * Handle the IpAddress "force deleted" event.
     *
     * @param  \App\Models\IpAddress  $ipAddress
     * @return void
     */
    public function forceDeleted(IpAddress $ipAddress)
    {
        //
    }
}
