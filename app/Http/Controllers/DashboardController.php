<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StrawberryProduct;
use App\Models\Testimonial;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil semua produk strawberry untuk ditampilkan di dashboard user
        $products = StrawberryProduct::whereIn('status', ['active', 'out_of_stock'])->orderBy('created_at', 'desc')->get();

        // Ambil semua testimoni untuk ditampilkan di dashboard dengan auto-scroll
        $testimonials = Testimonial::latest()->get();

        return view('dashboard.index', compact('products', 'testimonials'));
    }
}
