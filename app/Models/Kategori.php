<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Carbon\Carbon;
use App\Models\Barang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Kategori extends Model
{
    use HasFactory;
    use Sluggable;

    protected $guarded = ['id', 'kode_kategori'];

    public function barang()
    {
        return $this->hasMany(Barang::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($kategoris) {
            $tahun = date('Y');
            $kode = strtoupper(substr($kategoris->nama_kategori, 0, 3)); // Ambil 3 huruf depan nama pegawai
            $detik = Carbon::parse($kategoris->created_at)->format('s'); // Ambil detik dari created_at
            $kategoris->kode_kategori = $kode . $tahun . $detik . $kategoris->id;
        });
    }
    public function getSlugAttribute()
    {
        return Str::slug($this->nama_kategori);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nama_kategori'
            ]
        ];
    }
}
