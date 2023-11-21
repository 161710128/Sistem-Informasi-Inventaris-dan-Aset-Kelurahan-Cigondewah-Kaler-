<?php

namespace App\Models;

use App\Models\Supplier;
use App\Models\Inventaris;
use App\Models\Pengadaan_item;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi_pengadaan extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'kode_transaksi_pengadaan'];

    public function inventaris()
    {
        return $this->hasMany(Inventaris::class);
    }
    public function pengadaanItem()
    {
        return $this->hasMany(Pengadaan_item::class);
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaksi_pengadaan) {

            $tahun = date('Y');
            $kode = strtoupper(substr($transaksi_pengadaan->tgl_transaksi_pengadaan, 0, 3)); // Ambil 3 huruf depan nama barang
            $detik = Carbon::now()->format('s'); // Ambil detik dari waktu sekarang
            $transaksi_pengadaan->kode_transaksi_pengadaan = Str::uuid();
            $existingKodeBarang = self::where('kode_transaksi_pengadaan', 'like', $kode . $tahun . $detik  . '%')->orderBy('created_at', 'desc')->first();

            if ($existingKodeBarang) {
                $counter = (int)substr($existingKodeBarang->kode_transaksi_pengadaan, -4) + 1;
                $transaksi_pengadaan->kode_transaksi_pengadaan = $kode .  $tahun . $detik  . str_pad($counter, 4, '0', STR_PAD_LEFT);
            } else {
                $transaksi_pengadaan->kode_transaksi_pengadaan = $kode . $tahun . $detik  . '0001';
            }
        });
    }

    public function scopeFilter($query, array $filters)
    {

        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('kode_transaksi_pengadaan', 'like', '%' . $search . '%')
                ->orWhere('slug', 'like', '%' . $search . '%')
                ->orWhere('jenis_pengadaan', 'like', '%' . $search . '%');
        });

        $query->when($filters['supplier'] ?? false, function ($query, $supplier) {
            return $query->whereHas('supplier', function ($query) use ($supplier) {
                $query->where('nama_supplier', $supplier);
            });
        });

        // $query->when($filters['author'] ?? false, function ($query, $user) {
        //     return $query->whereHas('user', function ($query) use ($user) {
        //         $query->where('username', $user);
        //     });
        // });
    }
}
