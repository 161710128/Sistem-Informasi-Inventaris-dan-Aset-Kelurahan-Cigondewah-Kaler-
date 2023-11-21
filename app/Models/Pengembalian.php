<?php

namespace App\Models;

use App\Models\Peminjaman_barang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\Sluggable;
use Carbon\Carbon;
use Illuminate\Support\Str;

class Pengembalian extends Model
{
    use HasFactory;
    use Sluggable;

    protected $guarded = ['id', 'kode_pengembalian'];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman_barang::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaksi_pengembalian) {
            $tahun = date('Y');
            $kode = strtoupper(substr($transaksi_pengembalian->barang_id, 0, 3)); // Ambil 3 huruf depan nama supplier
            $detik = Carbon::parse($transaksi_pengembalian->created_at)->format('s'); // Ambil detik dari created_at
            $transaksi_pengembalian->kode_pengembalian = $kode . $tahun . $detik . $transaksi_pengembalian->id;
        });
    }
    public function scopeFilter($query, array $filters)
    {

        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('peminjaman_id', 'like', '%' . $search . '%')
                ->orWhere('slug', 'like', '%' . $search . '%')
                ->orWhere('keterangan', 'like', '%' . $search . '%')
                ->orWhere('kode_pengembalian', 'like', '%' . $search . '%');
        });

        // $query->when($filters['barang'] ?? false, function ($query, $barang) {
        //     return $query->whereHas('barang', function ($query) use ($barang) {
        //         $query->where('nama_barang', $barang);
        //     });
        // });
    }
    public function getSlugAttribute()
    {
        return Str::slug($this->keterangan);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'keterangan'
            ]
        ];
    }
}
