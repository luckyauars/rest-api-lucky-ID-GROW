<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = [
        'nama_produk',
        'kode_produk',
        'kategori',
        'satuan',
    ];

    public function lokasis()
    {
        return $this->belongsToMany(Lokasi::class, 'produk_lokasi')
            ->using(ProdukLokasi::class)
            ->withPivot('stok')
            ->withTimestamps();
    }
}
