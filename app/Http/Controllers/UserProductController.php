<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StrawberryProduct;

class UserProductController extends Controller
{
    /**
     * Display a listing of products for users
     */
    public function index()
    {
        $products = StrawberryProduct::whereIn('status', ['active', 'out_of_stock'])->orderBy('created_at', 'desc')->paginate(12);
        return view('user.products.index', compact('products'));
    }

    /**
     * Display the specified product for users
     */
    public function show(StrawberryProduct $product)
    {
        // Check if product is active or out of stock (but not inactive)
        if (!in_array($product->status, ['active', 'out_of_stock'])) {
            abort(404, 'Produk tidak tersedia');
        }

        // Get related products (same category, excluding current product)
        $relatedProducts = StrawberryProduct::where('category', $product->category)
            ->whereIn('status', ['active', 'out_of_stock'])
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('user.products.show', compact('product', 'relatedProducts'));
    }
}