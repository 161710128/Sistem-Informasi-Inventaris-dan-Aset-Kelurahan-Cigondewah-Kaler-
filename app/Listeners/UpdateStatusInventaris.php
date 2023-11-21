<?php

namespace App\Listeners;

use App\Models\Pengembalian;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\PengembalianDiterima;

class UpdateStatusInventaris
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
    public function handle(PengembalianDiterima $event)
    {
        $peminjamanId = $event->peminjamanId;

        // Cari pengembalian yang terkait dengan peminjaman ID
        $pengembalian = Pengembalian::where('peminjaman_id', $peminjamanId)->FindOneById();

        if ($pengembalian) {
            // Ubah status inventaris menjadi 'tersedia'
            $pengembalian->peminjaman->inventaris->update(['status' => 'tersedia']);
        }
    }
}
