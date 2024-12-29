<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item; // Pastikan model Item sudah dibuat

class ItemController extends Controller
{
    /**
     * Simpan barang baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'detail' => 'required|string',
            'harga' => 'required|numeric|min:0',
        ]);

        $item = Item::create([
            'nama_barang' => $request->nama_barang,
            'detail' => $request->detail,
            'harga' => $request->harga,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil ditambahkan!',
            'data' => $item,
        ], 201);
    }

    public function index()
    {
        // Mengambil semua data barang dari database
        $items = Item::all();

        // Mengembalikan data barang dalam bentuk JSON
        return response()->json([
            'success' => true,
            'data' => $items
        ], 200);
    }

    public function show($itemId)
    {
        $item = Item::find($itemId);

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $item,
        ]);
    }
}
