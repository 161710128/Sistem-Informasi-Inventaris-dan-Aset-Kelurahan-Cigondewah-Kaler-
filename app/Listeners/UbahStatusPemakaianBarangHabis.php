<?php

namespace App\Listeners;

use App\Events\EntriPemakaianBarangHabis;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UbahStatusPemakaianBarangHabis
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
    public function handle(EntriPemakaianBarangHabis $event)
    {
        // Temukan inventaris yang terkait dengan peminjaman
        $pemakaianBarangHabis = $event->pemakaianBarangHabis;
        $inventaris = $pemakaianBarangHabis->inventaris;

        // Jika inventaris ditemukan, ubah statusnya
        if ($inventaris) {
            $inventaris->update(['status' => 'Habis Pakai']);
        }
    }
}
