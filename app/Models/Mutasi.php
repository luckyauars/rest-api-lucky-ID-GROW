<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mutasi extends Model
{
    protected $fillable = [
        'tanggal',
        'jenis_mutasi',
        'jumlah',
        'keterangan',
        'produk_lokasi_id',
        'user_id',
        'produk_id',
        'lokasi_id'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    public function produkLokasi()
    {
        return $this->belongsTo(ProdukLokasi::class, 'produk_lokasi_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
