<?php

namespace App\Observers;

use App\Models\Package;
use App\Models\Scan;
use Filament\Notifications\Notification;

class ScanObserver
{
    /**
     * Handle the Scan "created" event.
     */
    public function created(Scan $scan): void
    {
        $user = $scan->package->user;
        Notification::make()
            ->title('You package has been ' . $scan->status)
            ->success()
            ->sendToDatabase($user);
        if ($scan->status === 'arrived') {
            $user->notify(new \App\Notifications\PackageArrived($scan->package_id));
        }
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
