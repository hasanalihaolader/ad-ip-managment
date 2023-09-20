<?php

namespace App\Observers;

use App\Models\IpAddress;
use App\Services\AuditTrailService;

class IpAddressObserver
{
    /**
     * Handle the IpAddress "created" event.
     *
     * @param  \App\Models\IpAddress  $ipAddress
     * @return void
     */
    public function saved(IpAddress $ipAddress): void
    {
        AuditTrailService::track(
            'saved',
            IpAddress::class,
            optional($ipAddress)->toArray()
        );
    }

    /**
     * Handle the IpAddress "updated" event.
     *
     * @param  \App\Models\IpAddress  $ipAddress
     * @return void
     */
    public function updated(IpAddress $ipAddress)
    {
        AuditTrailService::track(
            'update',
            IpAddress::class,
            optional($ipAddress)->toArray()
        );
        //TODO:have improvement scope during update also fire saved event
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
