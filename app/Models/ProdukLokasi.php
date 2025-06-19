<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukLokasi extends Model
{
    protected $table = 'produk_lokasi';

    protected $fillable = [
        'produk_id',
        'lokasi_id',
        'produk_lokasi_id',
        'stok',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    public function mutasis()
    {
        return $this->hasMany(Mutasi::class, 'produk_lokasi_id');
    }
}
