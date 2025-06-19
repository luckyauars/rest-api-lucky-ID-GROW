<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Lokasi::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_lokasi'  => 'required|string|max:50|unique:lokasis,kode_lokasi',
            'nama_lokasi'  => 'required|string|max:100',
        ]);

        $lokasi = Lokasi::create($validated);

        return response()->json($lokasi, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Lokasi $lokasi)
    {
        return $lokasi;
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lokasi $lokasi)
    {
        $validated = $request->validate([
            'kode_lokasi'  => 'sometimes|required|string|max:50|unique:lokasis,kode_lokasi,' . $lokasi->id,
            'nama_lokasi'  => 'sometimes|required|string|max:100',
        ]);

        $lokasi->update($validated);

        return response()->json($lokasi);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lokasi $lokasi)
    {
        $lokasi->delete();

        return response()->json(null, 204);
    }
}