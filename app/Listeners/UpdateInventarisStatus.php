<?php

namespace App\Listeners;

use App\Events\StatusChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Inventaris;
use App\Models\Peminjaman_barang;

class UpdateInventarisStatus
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
    public function handle(Peminjaman_barang $peminjamanBarang)
    {
        // Temukan inventaris yang terkait dengan peminjaman
        $inventaris = $peminjamanBarang->inventaris;

        // Jika inventaris ditemukan, ubah statusnya
        if ($inventaris) {
            $inventaris->update(['status' => 'dipinjam']);
        }
    }
}
