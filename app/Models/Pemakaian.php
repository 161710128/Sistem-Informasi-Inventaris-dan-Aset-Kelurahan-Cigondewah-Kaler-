<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Barang;
use App\Models\Pegawai;
use App\Models\Inventaris;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pemakaian extends Model
{
    use HasFactory;
    use Sluggable;

    protected $guarded = ['id', 'kode_pemakaian'];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaksi_pemakaian) {
            $tahun = date('Y');
            $kode = strtoupper(substr($transaksi_pemakaian->barang_id, 0, 3)); // Ambil 3 huruf depan nama supplier
            $detik = Carbon::parse($transaksi_pemakaian->created_at)->format('s'); // Ambil detik dari created_at
            $transaksi_pemakaian->kode_pemakaian = $kode . $tahun . $detik . $transaksi_pemakaian->id;
        });
    }
    public function scopeFilter($query, array $filters)
    {

        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('pegawai_id', 'like', '%' . $search . '%')
                ->orWhere('slug', 'like', '%' . $search . '%')
                ->orWhere('keterangan', 'like', '%' . $search . '%')
                ->orWhere('kode_pemakaian', 'like', '%' . $search . '%');
        });

        $query->when($filters['barang'] ?? false, function ($query, $barang) {
            return $query->whereHas('barang', function ($query) use ($barang) {
                $query->where('nama_barang', $barang);
            });
        });
        // $query->when($filters['category'] ?? false, function ($query, $category) {
        //     return $query->whereHas('category', function ($query) use ($category) {
        //         $query->where('slug', $category);
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
