<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Stok;
use App\Models\Barang;
// use App\Models\Stok;
use App\Models\Pemakaian;
use App\Models\Penempatan;
use App\Models\Pemeliharaan;
use App\Models\Peminjaman_barang;
use App\Models\Barang_habis_pakai;
use App\Models\Transaksi_pengadaan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventaris extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'kode_inventaris'];
    protected $with = ['pemeliharaan', 'pemakaian', 'peminjaman', 'barangHabisPakai', 'penempatan'];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
    public function transaksiPengadaan()
    {
        return $this->belongsTo(Transaksi_pengadaan::class);
    }
    public function pemeliharaan()
    {
        return $this->hasOne(Pemeliharaan::class);
    }

    public function pemakaian()
    {
        return $this->hasOne(Pemakaian::class);
    }

    public function peminjaman()
    {
        return $this->hasOne(Peminjaman_barang::class);
    }
    public function penempatan()
    {
        return $this->hasMany(Penempatan::class);
    }
    public function barangHabisPakai()
    {
        return $this->hasMany(Barang_habis_pakai::class);
    }

    // public function stok()
    // {
    //     return $this->belongsTo(Stok::class);
    // }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($inventaris) {
            // Generate kode_inventaris unik
            $tahun = date('Y');
            $kode = strtoupper(substr($inventaris->nama_barang, 0, 3)); // Ambil 3 huruf depan nama barang
            $detik = Carbon::now()->format('s'); // Ambil detik dari waktu sekarang

            do {
                $counter = (int)rand(1, 9999);
                $inventaris->kode_inventaris = $kode . $tahun . $detik . str_pad($counter, 4, '0', STR_PAD_LEFT);
                // Pastikan kode_inventaris benar-benar unik dengan memeriksa basis data
            } while (Inventaris::where('kode_inventaris', $inventaris->kode_inventaris)->exists());
        });
    }

    public function scopeFilter($query, array $filters)
    {

        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('barang_id', 'like', '%' . $search . '%')
                ->orWhere('slug', 'like', '%' . $search . '%')
                ->orWhere('kondisi', 'like', '%' . $search . '%')
                ->orWhere('status', 'like', '%' . $search . '%');
        });
    }
}
