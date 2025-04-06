<?php

namespace App\Observers;

use App\Models\Package;
use App\Models\Scan;

class ScanObserver
{
    /**
     * Handle the Scan "created" event.
     */
    public function created(Scan $scan): void
    {
        if ($scan->status === 'registered') {
            return;
        }
        Package::find($scan->package_id)->update([
            'status' => $scan->status,
        ]);
    }

    /**
     * Handle the Scan "updated" event.
     */
    public function updated(Scan $scan): void
    {
        //
    }

    /**
     * Handle the Scan "deleted" event.
     */
    public function deleted(Scan $scan): void
    {
        //
    }

    /**
     * Handle the Scan "restored" event.
     */
    public function restored(Scan $scan): void
    {
        //
    }

    /**
     * Handle the Scan "force deleted" event.
     */
    public function forceDeleted(Scan $scan): void
    {
        //
    }
}
