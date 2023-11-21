<?php

namespace App\Models;

use App\Models\Transaksi_pengadaan;
use Cviebrock\EloquentSluggable\Sluggable;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;
    use Sluggable;

    protected $guarded = ['id', 'kode_supplier'];

    public function transaksipengadaan()
    {
        return $this->hasMany(Transaksi_pengadaan::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($supplier) {
            $tahun = date('Y');
            $kode = strtoupper(substr($supplier->nama_supplier, 0, 3)); // Ambil 3 huruf depan nama supplier
            $detik = Carbon::parse($supplier->created_at)->format('s'); // Ambil detik dari created_at
            $supplier->kode_supplier = $kode . $tahun . $detik . $supplier->id;
        });
    }

    public function scopeFilter($query, array $filters)
    {

        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('nama_supplier', 'like', '%' . $search . '%')
                ->orWhere('slug', 'like', '%' . $search . '%')
                ->orWhere('kode_supplier', 'like', '%' . $search . '%')
                ->orWhere('alamat', 'like', '%' . $search . '%');
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
        return Str::slug($this->nama_supplier);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nama_supplier'
            ]
        ];
    }
}
