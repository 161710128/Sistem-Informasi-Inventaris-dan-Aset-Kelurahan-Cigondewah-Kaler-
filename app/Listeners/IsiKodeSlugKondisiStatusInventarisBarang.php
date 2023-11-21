<?php

namespace App\Listeners;

use App\Events\EntriBarang;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;
use App\Models\Inventaris;

class IsiKodeSlugKondisiStatusInventarisBarang implements ShouldQueue
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
     * @param  \App\Events\EntriBarang  $event
     * @return void
     */
    public function handle(EntriBarang $event)
    {
        $barang = $event->barang;

        $kodeInventaris = 'INV-' . $barang->id;
        $slug = Str::slug($barang->nama_barang);

        Inventaris::create([
            'barang_id' => $barang->id,
            'kode_inventaris' => $kodeInventaris,
            'slug' => $slug,
            'kondisi' => 'baik', // Default kondisi
            'status' => 'Tersedia', // Default status
            // Kolom lain yang sesuai
        ]);
    }
}
