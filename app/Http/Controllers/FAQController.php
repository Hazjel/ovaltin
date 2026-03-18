<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FAQ;

class FAQController extends Controller
{
    /**
     * Display a listing of active FAQs
     */
    public function index()
    {
        $faqs = FAQ::active()->ordered()->get();
        return view('faqs.index', compact('faqs'));
    }
}
