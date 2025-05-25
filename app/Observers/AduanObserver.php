<?php

namespace App\Observers;

use App\Models\Aduan;

class AduanObserver
{
    /**
     * Handle the Aduan "created" event.
     */
    public function created(Aduan $aduan): void
    {
        dd($aduan);
    }

    /**
     * Handle the Aduan "updated" event.
     */
    public function updated(Aduan $aduan): void
    {
        dd($aduan);
    }

    /**
     * Handle the Aduan "deleted" event.
     */
    public function deleted(Aduan $aduan): void
    {
        //
    }

    /**
     * Handle the Aduan "restored" event.
     */
    public function restored(Aduan $aduan): void
    {
        //
    }

    /**
     * Handle the Aduan "force deleted" event.
     */
    public function forceDeleted(Aduan $aduan): void
    {
        //
    }
}
