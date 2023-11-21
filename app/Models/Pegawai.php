<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Carbon\Carbon;
use App\Models\Pemakaian;
use Illuminate\Support\Str;
use App\Models\Peminjaman_barang;
use App\Models\Barang_habis_pakai;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pegawai extends Model
{
    use HasFactory;
    use Sluggable;

    protected $guarded = ['id', 'kode_pegawai'];
    protected $with = ['baranghabispakai'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pegawai) {
            $tahun = date('Y');
            $kode = strtoupper(substr($pegawai->nama_pegawai, 0, 3)); // Ambil 3 huruf depan nama pegawai
            $detik = Carbon::parse($pegawai->created_at)->format('s'); // Ambil detik dari created_at
            $pegawai->kode_pegawai = $kode . $tahun . $detik . $pegawai->id;
        });
    }

    public function scopeFilter($query, array $filters)
    {

        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('nama_pegawai', 'like', '%' . $search . '%')
                ->orWhere('slug', 'like', '%' . $search . '%')
                ->orWhere('kode_pegawai', 'like', '%' . $search . '%')
                ->orWhere('jabatan', 'like', '%' . $search . '%');
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

    public function pemakaian()
    {
        return $this->hasMany(Pemakaian::class);
    }
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman_barang::class);
    }
    public function baranghabispakai()
    {
        return $this->hasMany(Barang_habis_pakai::class);
    }

    public function getSlugAttribute()
    {
        return Str::slug($this->nama_pegawai);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nama_pegawai'
            ]
        ];
    }
}
