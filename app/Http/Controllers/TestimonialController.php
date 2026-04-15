<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    /**
     * Display a listing of approved testimonials
     */
    public function index()
    {
        $testimonials = Testimonial::where('is_approved', true)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(6);
            
        return view('testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new testimonial
     */
    public function create()
    {
        $user = Auth::user();

        if (!$user instanceof User) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu untuk memberikan testimoni.');
        }

        if ($user->isAdmin()) {
            return redirect()->route('testimonials.index')
                ->with('error', 'Admin tidak dapat memberikan testimoni.');
        }

        return view('testimonials.create');
    }

    /**
     * Store a newly created testimonial
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user instanceof User) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu untuk memberikan testimoni.');
        }

        if ($user->isAdmin()) {
            return redirect()->route('testimonials.index')
                ->with('error', 'Admin tidak dapat memberikan testimoni.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string|min:10|max:1000',
        ]);

        // Snapshot identitas dari profil user saat testimoni dibuat —
        // tidak menerima name/email dari form supaya tidak bisa dipalsukan.
        $validated['user_id'] = $user->id;
        $validated['name'] = $user->name;
        $validated['email'] = $user->email;
        $validated['is_approved'] = true;

        Testimonial::create($validated);

        return redirect()->route('testimonials.index')
            ->with('success', 'Testimoni Anda telah berhasil ditambahkan! Terima kasih atas feedback-nya.');
    }

    /**
     * Display the specified testimonial
     */
    public function show(Testimonial $testimonial)
    {
        return view('testimonials.show', compact('testimonial'));
    }
}