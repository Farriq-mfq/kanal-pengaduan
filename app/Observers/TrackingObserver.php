<?php

namespace App\Observers;

use App\Mail\ProgressUpdateMail;
use App\Models\Tracking;
use Illuminate\Support\Facades\Mail;

class TrackingObserver
{
    /**
     * Handle the Tracking "created" event.
     */
    public function created(Tracking $tracking): void
    {
        $mail = new ProgressUpdateMail($tracking);
        $aduan = $tracking->aduan;
        $masyarakat = $aduan->masyarakat;
        Mail::to($masyarakat->email)->send($mail);
    }

    /**
     * Handle the Tracking "updated" event.
     */
    public function updated(Tracking $tracking): void
    {
        $mail = new ProgressUpdateMail($tracking);
        $aduan = $tracking->aduan;
        $masyarakat = $aduan->masyarakat;
        Mail::to($masyarakat->email)->send($mail);
    }

    /**
     * Handle the Tracking "deleted" event.
     */
    public function deleted(Tracking $tracking): void
    {
        //
    }

    /**
     * Handle the Tracking "restored" event.
     */
    public function restored(Tracking $tracking): void
    {
        //
    }

    /**
     * Handle the Tracking "force deleted" event.
     */
    public function forceDeleted(Tracking $tracking): void
    {
        //
    }
}
