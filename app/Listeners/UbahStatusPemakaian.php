<?php

namespace App\Listeners;

use App\Models\Pemakaian;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\EntriPemakaian;

class UbahStatusPemakaian
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(EntriPemakaian $event)
    {
        // Temukan inventaris yang terkait dengan peminjaman
        $pemakaian = $event->pemakaian;
        $inventaris = $pemakaian->inventaris;

        // Jika inventaris ditemukan, ubah statusnya
        if ($inventaris) {
            $inventaris->update(['status' => 'dipakai']);
        }
    }
}
