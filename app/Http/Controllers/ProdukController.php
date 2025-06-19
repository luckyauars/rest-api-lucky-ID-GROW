<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Produk::all();
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk'  => 'required|string|max:255',
            'kode_produk'  => 'required|string|max:100|unique:produks',
            'kategori'     => 'required|string|max:100',
            'satuan'       => 'required|string|max:50',
        ]);

        $produk = Produk::create($validated);

        return response()->json($produk, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produk $produk)
    {
        $validated = $request->validate([
            'nama_produk'  => 'sometimes|required|string|max:255',
            'kode_produk'  => 'sometimes|required|string|max:100|unique:produks,kode_produk,' . $produk->id,
            'kategori'     => 'sometimes|required|string|max:100',
            'satuan'       => 'sometimes|required|string|max:50',
        ]);

        $produk->update($validated);

        return response()->json($produk);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        $produk->delete();
        return response()->json(null, 204);
    }
}