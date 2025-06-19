<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    protected $fillable = [
        'kode_lokasi',
        'nama_lokasi',
    ];

    public function produks()
    {
        return $this->belongsToMany(Produk::class, 'produk_lokasi')
            ->using(ProdukLokasi::class)
            ->withPivot('stok')
            ->withTimestamps();
    }
}
