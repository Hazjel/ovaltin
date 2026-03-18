<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StrawberryProduct;

class StrawberryProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = StrawberryProduct::latest()->paginate(10);
        return view('strawberry-products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('strawberry-products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240', // 10MB max
            'origin' => 'required|string|max:255',
            'harvest_date' => 'required|date',
            'is_organic' => 'boolean',
            'status' => 'required|in:active,inactive,out_of_stock',
            'tokopedia_url' => 'nullable|url|max:255',
            'shopee_url' => 'nullable|url|max:255',
            'lazada_url' => 'nullable|url|max:255',
            'whatsapp_url' => 'nullable|url|max:255',
        ]);

        // Pastikan checkbox yang tidak dicentang tersimpan sebagai false
        $validated['is_organic'] = $request->boolean('is_organic');

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        StrawberryProduct::create($validated);

        return redirect()->route('strawberry-products.index')
            ->with('success', 'Produk stroberi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(StrawberryProduct $strawberryProduct)
    {
        return view('strawberry-products.show', compact('strawberryProduct'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StrawberryProduct $strawberryProduct)
    {
        return view('strawberry-products.edit', compact('strawberryProduct'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StrawberryProduct $strawberryProduct)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240', // 10MB max
            'origin' => 'required|string|max:255',
            'harvest_date' => 'required|date',
            'is_organic' => 'boolean',
            'status' => 'required|in:active,inactive,out_of_stock',
            'tokopedia_url' => 'nullable|url|max:255',
            'shopee_url' => 'nullable|url|max:255',
            'lazada_url' => 'nullable|url|max:255',
            'whatsapp_url' => 'nullable|url|max:255',
        ]);

        // Pastikan checkbox yang tidak dicentang tersimpan sebagai false
        $validated['is_organic'] = $request->boolean('is_organic');

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($strawberryProduct->image) {
                \Storage::disk('public')->delete($strawberryProduct->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        $strawberryProduct->update($validated);

        return redirect()->route('strawberry-products.index')
            ->with('success', 'Produk stroberi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StrawberryProduct $strawberryProduct)
    {
        $strawberryProduct->delete();

        return redirect()->route('strawberry-products.index')
            ->with('success', 'Produk stroberi berhasil dihapus!');
    }

    /**
     * Update the status of the specified resource.
     */
    public function updateStatus(Request $request, StrawberryProduct $strawberryProduct)
    {
        $request->validate([
            'status' => 'required|in:active,inactive,out_of_stock',
        ]);

        $strawberryProduct->update([
            'status' => $request->status,
        ]);

        return redirect()->route('strawberry-products.index')
            ->with('success', 'Status produk berhasil diperbarui!');
    }
}
