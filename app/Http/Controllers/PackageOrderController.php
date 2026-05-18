<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PackageOrder;
use App\Models\StrawberryProduct;
use App\Models\ContactInfo;

class PackageOrderController extends Controller
{
    public function index()
    {
        $products = StrawberryProduct::where('status', 'active')
            ->where('stock_quantity', '>', 0)
            ->get();

        $contact = ContactInfo::getActive();
        $waNumber = $contact?->whatsapp ? preg_replace('/\D/', '', $contact->whatsapp) : '6281234567890';

        return view('order-paket.index', compact('products', 'waNumber'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name'    => 'required|string|max:255',
            'customer_phone'   => 'required|string|max:20',
            'customer_address' => 'nullable|string|max:500',
            'payment_proof'    => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'items'            => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:strawberry_products,id',
            'items.*.qty'        => 'required|integer|min:10',
        ]);

        // Validate each qty is multiple of 10
        foreach ($request->items as $item) {
            if ($item['qty'] % 10 !== 0) {
                return back()->withErrors(['items' => 'Jumlah setiap produk harus kelipatan 10.'])->withInput();
            }
        }

        // Build items array with price snapshot
        $items = [];
        $total = 0;

        foreach ($request->items as $item) {
            $product = StrawberryProduct::findOrFail($item['product_id']);
            $qty = (int) $item['qty'];
            $subtotal = $product->price * $qty;

            $items[] = [
                'product_id'    => $product->id,
                'product_name'  => $product->name,
                'qty'           => $qty,
                'price_per_unit' => $product->price,
                'subtotal'      => $subtotal,
            ];

            $total += $subtotal;
        }

        $proofPath = $request->file('payment_proof')->store('payment-proofs', 'public');

        PackageOrder::create([
            'customer_name'    => $validated['customer_name'],
            'customer_phone'   => $validated['customer_phone'],
            'customer_address' => $validated['customer_address'] ?? null,
            'items'            => $items,
            'total_price'      => $total,
            'payment_proof'    => $proofPath,
        ]);

        return redirect()->route('order-paket.success')
            ->with('success', 'Order paketan berhasil dikirim! Admin akan segera mengkonfirmasi pesanan Anda.');
    }

    public function success()
    {
        return view('order-paket.success');
    }
}
