<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PackageOrder;

class AdminPackageOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = PackageOrder::latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(PackageOrder $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, PackageOrder $order)
    {
        $request->validate([
            'status'      => 'required|in:pending,confirmed,selesai,dibatalkan',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $order->update([
            'status'      => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Status order berhasil diperbarui.');
    }
}
