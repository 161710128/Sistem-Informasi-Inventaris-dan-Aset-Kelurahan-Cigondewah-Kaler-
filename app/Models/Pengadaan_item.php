<?php

namespace App\Models;

use App\Models\Barang;
use App\Models\Transaksi_pengadaan;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengadaan_item extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'kode_pengadaan_item'];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
    public function transaksiPengadaan()
    {
        return $this->belongsTo(Transaksi_pengadaan::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pengadaan_item) {
            $tahun = date('Y');
            $kode = strtoupper(substr($pengadaan_item->barang_id, 0, 3)); // Ambil 3 huruf depan nama supplier
            $detik = Carbon::parse($pengadaan_item->created_at)->format('s'); // Ambil detik dari created_at
            $pengadaan_item->kode_pengadaan_item = $kode . $tahun . $detik . $pengadaan_item->id;
        });
    }
}
