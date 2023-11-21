<?php

namespace App\Listeners;

use App\Events\EntriTransaksiPengadaan;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;
use App\Models\Inventaris;

class IsiKodeSlugKondisiStatusInventarisTransaksiPengadaan implements ShouldQueue
{
    use InteractsWithQueue;
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
     * @param  \App\Events\EntriTransaksiPengadaan  $event
     * @return void
     */
    public function handle(EntriTransaksiPengadaan $event)
    {
        $transaksiPengadaan = $event->transaksiPengadaan;

        Inventaris::create([
            'transaksi_pengadaan_id' => $transaksiPengadaan->id
        ]);
    }
}
