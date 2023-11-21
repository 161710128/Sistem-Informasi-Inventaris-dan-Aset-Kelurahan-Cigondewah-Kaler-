<?php

namespace App\Models;

use App\Models\Barang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stok extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'kode_stok'];
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
