<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StrawberryProduct;
use App\Models\Testimonial;
use App\Models\ProductIntroduction;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil semua produk strawberry untuk ditampilkan di dashboard user
        $products = StrawberryProduct::whereIn('status', ['active', 'out_of_stock'])->orderBy('created_at', 'desc')->get();
        
        // Ambil semua testimoni untuk ditampilkan di dashboard dengan auto-scroll
        $testimonials = Testimonial::latest()->get();
        
        // Ambil product introduction yang aktif
        $productIntroduction = ProductIntroduction::getActive();

        return view('dashboard.index', compact('products', 'testimonials', 'productIntroduction'));
    }
}
