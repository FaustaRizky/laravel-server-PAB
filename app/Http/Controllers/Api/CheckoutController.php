<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class CheckoutController extends Controller
{
    public function processCheckout(Request $request, $itemId)
    {
        try {
            // Validasi input
            $request->validate([
                'name' => 'required|string',
                'address' => 'required|string',
                'payment_method' => 'required|string',
            ]);

            // Ambil item berdasarkan ID
            $item = Item::find($itemId);

            if (!$item) {
                return response()->json(['error' => 'Item not found'], 404);
            }

            // Simulasikan transaksi pembayaran
            $transaction = [
                'item' => $item,
                'name' => $request->name,
                'address' => $request->address,
                'payment_method' => $request->payment_method,
                'status' => 'success', // Simulasi pembayaran berhasil
            ];

            return response()->json([
                'message' => 'Transaction successful',
                'transaction' => $transaction
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred during checkout',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
