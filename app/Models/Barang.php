<?php

namespace App\Models;


use App\Models\Stok;
use App\Models\Kategori;
use App\Models\Pemakaian;
use App\Models\Inventaris;
use App\Models\Penempatan;
use App\Models\Pemeliharaan;
use App\Models\Pengadaan_item;
use App\Models\Peminjaman_barang;
use App\Models\Barang_habis_pakai;
use Cviebrock\EloquentSluggable\Sluggable;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barang extends Model
{
    use HasFactory;
    use Sluggable;

    protected $guarded = ['id', 'kode_barang'];
    // protected $with = ['kategoribarang', 'penempatan'];
    protected $with = ['inventaris'];

    public function kategoribarang()
    {
        return $this->belongsTo(Kategori::class);
    }
    public function penempatan()
    {
        return $this->hasMany(Penempatan::class);
    }

    public function inventaris()
    {
        return $this->hasMany(Inventaris::class);
    }

    public function stok()
    {
        return $this->hasOne(Stok::class);
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
        return $this->hasMany(Peminjaman_barang::class);
    }

    public function barangHabisPakai()
    {
        return $this->hasMany(Barang_habis_pakai::class);
    }
    public function pengadaanItem()
    {
        return $this->hasMany(Pengadaan_item::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($barang) {
            // Generate kode_barang unik
            // Generate kode_barang unik
            $tahun = date('Y');
            $kode = strtoupper(substr($barang->nama_barang, 0, 3)); // Ambil 3 huruf depan nama barang
            $detik = Carbon::now()->format('s'); // Ambil detik dari waktu sekarang

            do {
                $counter = (int)rand(1, 9999);
                $barang->kode_barang = $kode . $tahun . $detik . str_pad($counter, 4, '0', STR_PAD_LEFT);
                // Pastikan kode_barang benar-benar unik dengan memeriksa basis data
            } while (Barang::where('kode_barang', $barang->kode_barang)->exists());
        });



        static::creating(function ($barang) {
            // Generate kode_label unik
            $tahun = date('Y');
            $kode = strtoupper(substr($barang->nama_barang, 0, 3)); // Ambil 3 huruf depan nama barang
            $detik = Carbon::now()->format('s'); // Ambil detik dari waktu sekarang

            do {
                $counter = (int)rand(1, 9999);
                $barang->kode_label = $kode . $tahun . $detik . str_pad($counter, 4, '0', STR_PAD_LEFT);
                // Pastikan kode_label benar-benar unik dengan memeriksa basis data
            } while (Barang::where('kode_label', $barang->kode_label)->exists());
        });
    }


    public function scopeFilter($query, array $filters)
    {

        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('nama_barang', 'like', '%' . $search . '%')
                ->orWhere('slug', 'like', '%' . $search . '%')
                ->orWhere('merk', 'like', '%' . $search . '%')
                ->orWhere('spesifikasi', 'like', '%' . $search . '%')
                ->orWhere('satuan', 'like', '%' . $search . '%');
        });

        // $query->when($filters['category'] ?? false, function ($query, $category) {
        //     return $query->whereHas('category', function ($query) use ($category) {
        //         $query->where('slug', $category);
        //     });
        // });

        // $query->when($filters['author'] ?? false, function ($query, $user) {
        //     return $query->whereHas('user', function ($query) use ($user) {
        //         $query->where('username', $user);
        //     });
        // });
    }

    public function getSlugAttribute()
    {
        return Str::slug($this->nama_barang);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nama_barang'
            ]
        ];
    }
}
