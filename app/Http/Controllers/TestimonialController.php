<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;
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
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu untuk memberikan testimoni.');
        }
        
        // Admin tidak bisa memberikan testimoni
        if (Auth::user()->isAdmin()) {
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
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu untuk memberikan testimoni.');
        }
        
        // Admin tidak bisa memberikan testimoni
        if (Auth::user()->isAdmin()) {
            return redirect()->route('testimonials.index')
                ->with('error', 'Admin tidak dapat memberikan testimoni.');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string|min:10|max:1000',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['is_approved'] = true; // Langsung disetujui, tidak perlu review admin

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

    /**
     * Show the form for editing the specified testimonial (Admin only)
     */
    public function edit(Testimonial $testimonial)
    {
        $this->authorize('admin');
        return view('testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified testimonial (Admin only)
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $this->authorize('admin');
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string|min:10|max:1000',
            'is_approved' => 'boolean',
        ]);

        $testimonial->update($validated);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimoni berhasil diperbarui!');
    }

    /**
     * Remove the specified testimonial (Admin only)
     */
    public function destroy(Testimonial $testimonial)
    {
        $this->authorize('admin');
        
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimoni berhasil dihapus!');
    }
}