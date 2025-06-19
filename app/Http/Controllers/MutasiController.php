<?php

namespace App\Http\Controllers;

use App\Models\Mutasi;
use App\Models\ProdukLokasi;
use Illuminate\Http\Request;

class MutasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Mutasi::with(['produk', 'lokasi'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'produk_id'     => 'required|exists:produks,id',
            'lokasi_id'     => 'required|exists:lokasis,id',
            'jenis_mutasi'  => 'required|in:masuk,keluar',
            'jumlah'        => 'required|integer|min:1',
            'keterangan'    => 'nullable|string'
        ]);

        $produkLokasi = ProdukLokasi::where('produk_id', $validated['produk_id'])
            ->where('lokasi_id', $validated['lokasi_id'])
            ->first();

        if (!$produkLokasi) {
            return response()->json([
                'message' => 'Produk tidak ditemukan di lokasi tersebut.'
            ], 404);
        }

        // Validasi jika keluar & stok tidak cukup
        if ($validated['jenis_mutasi'] === 'keluar' && $produkLokasi->stok < $validated['jumlah']) {
            return response()->json([
                'message' => 'Stok tidak mencukupi untuk mutasi keluar.'
            ], 422);
        }

        // Simpan mutasi
        $mutasi = Mutasi::create([
            'tanggal'            => now(),
            'jenis_mutasi'       => $validated['jenis_mutasi'],
            'jumlah'             => $validated['jumlah'],
            'keterangan'         => $validated['keterangan'] ?? null,
            'produk_lokasi_id'   => $produkLokasi->id,
            'user_id'            => auth()->id(),
        ]);

        // Update stok
        if ($validated['jenis_mutasi'] === 'masuk') {
            $produkLokasi->increment('stok', $validated['jumlah']);
        } else {
            $produkLokasi->decrement('stok', $validated['jumlah']);
        }

        return response()->json([
            'message' => 'Mutasi berhasil disimpan.',
            'mutasi' => $mutasi
        ], 201);
    }
    /**
     * Display the specified resource.
     */
    public function show(Mutasi $mutasi)
    {
        return $mutasi->load(['produk', 'lokasi']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'jenis_mutasi'  => 'required|in:masuk,keluar',
            'jumlah'        => 'required|integer|min:1',
            'keterangan'    => 'nullable|string',
        ]);

        $mutasi = Mutasi::findOrFail($id);
        $produkLokasi = $mutasi->produkLokasi;

        if (!$produkLokasi) {
            return response()->json(['message' => 'ProdukLokasi tidak ditemukan.'], 404);
        }

        // Kembalikan stok ke kondisi sebelum mutasi
        if ($mutasi->jenis_mutasi === 'masuk') {
            $produkLokasi->decrement('stok', $mutasi->jumlah);
        } elseif ($mutasi->jenis_mutasi === 'keluar') {
            $produkLokasi->increment('stok', $mutasi->jumlah);
        }

        // Cek jika jenis mutasi baru "keluar" dan stok tidak cukup
        if ($validated['jenis_mutasi'] === 'keluar' && $produkLokasi->stok < $validated['jumlah']) {
            // Balikkan stok ke kondisi awal sebelum update
            if ($mutasi->jenis_mutasi === 'masuk') {
                $produkLokasi->increment('stok', $mutasi->jumlah);
            } elseif ($mutasi->jenis_mutasi === 'keluar') {
                $produkLokasi->decrement('stok', $mutasi->jumlah);
            }

            return response()->json([
                'message' => 'Stok tidak cukup untuk update mutasi keluar.'
            ], 422);
        }

        // Update data mutasi
        $mutasi->update([
            'jenis_mutasi' => $validated['jenis_mutasi'],
            'jumlah'       => $validated['jumlah'],
            'keterangan'   => $validated['keterangan'] ?? null,
        ]);

        // Hitung ulang stok berdasarkan mutasi baru
        if ($validated['jenis_mutasi'] === 'masuk') {
            $produkLokasi->increment('stok', $validated['jumlah']);
        } else {
            $produkLokasi->decrement('stok', $validated['jumlah']);
        }

        return response()->json([
            'message' => 'Mutasi berhasil diperbarui.',
            'mutasi'  => $mutasi
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mutasi $mutasi)
    {
        $mutasi->delete();
        return response()->json(null, 204);
    }

    public function test(Request $request)
    {
        $produkLokasi = ProdukLokasi::where('produk_id', 1)->where('lokasi_id', 1)->first();

        Mutasi::create([
            'tanggal' => now(),
            'jenis_mutasi' => 'keluar',
            'jumlah' => 10,
            'keterangan' => 'Pengambilan untuk pengiriman',
            'produk_lokasi_id' => $produkLokasi->id,
            'user_id' => auth()->id(),
        ]);

        // Kurangi stok
        $produkLokasi->decrement('stok', 10);
    }

    public function historyByUser($userId)
    {
        $mutasi = Mutasi::with(['produkLokasi.produk', 'produkLokasi.lokasi'])
            ->where('user_id', $userId)
            ->orderBy('tanggal', 'desc')
            ->get();

        return response()->json([
            'user_id' => $userId,
            'history' => $mutasi
        ]);
    }
    public function historyByProduk($produkId)
    {
        $mutasi = Mutasi::with(['produkLokasi.lokasi', 'user'])
            ->whereHas('produkLokasi', function ($query) use ($produkId) {
                $query->where('produk_id', $produkId);
            })
            ->orderBy('tanggal', 'desc')
            ->get();

        return response()->json([
            'produk_id' => $produkId,
            'history' => $mutasi
        ]);
    }
}
