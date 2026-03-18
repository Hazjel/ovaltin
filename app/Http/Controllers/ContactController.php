<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\ContactInfo;

class ContactController extends Controller
{
    /**
     * Show the contact page.
     */
    public function index()
    {
        $contactInfo = ContactInfo::getActive();
        return view('contact.index', compact('contactInfo'));
    }

    /**
     * Handle contact form submission.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // For now, we'll just store the contact in session and show success message
        // In a real application, you would send an email or store in database
        session()->flash('success', 'Terima kasih! Pesan Anda telah berhasil dikirim. Kami akan segera menghubungi Anda.');

        return redirect()->route('contact.index');
    }
}
