<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\PeminjamanBarangCreated;

class UbahStatusInventaris
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
    public function handle(PeminjamanBarangCreated $event)
    {
        $peminjaman = $event->peminjaman;
        $inventaris = $peminjaman->inventaris;

        if ($inventaris) {
            $inventaris->update(['status' => 'dipinjam']);
        }
    }
}
