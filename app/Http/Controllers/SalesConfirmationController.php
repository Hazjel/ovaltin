<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesConfirmation;

class SalesConfirmationController extends Controller
{
    /**
     * Simpan konfirmasi dari popup
     */
    public function store(Request $request)
    {
        $request->validate([
            'has_sales' => 'required|in:yes,no',
        ]);

        $hasSales = $request->has_sales === 'yes';

        SalesConfirmation::confirmToday($hasSales);

        if ($hasSales) {
            return redirect()->route('sales-data.index')
                ->with('success', 'Silakan isi data penjualan hari ini.');
        }

        return redirect()->route('sales-data.index')
            ->with('info', 'Tercatat: Tidak ada penjualan hari ini. Pengingat WA minggu ini dihentikan.');
    }
}
