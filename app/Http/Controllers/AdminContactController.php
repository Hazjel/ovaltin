<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactInfo;

class AdminContactController extends Controller
{
    /**
     * Show contact management page
     */
    public function index()
    {
        $contactInfo = ContactInfo::getActive();
        return view('admin.contact.index', compact('contactInfo'));
    }

    /**
     * Show edit contact form
     */
    public function edit($id)
    {
        $contactInfo = ContactInfo::findOrFail($id);
        return view('admin.contact.edit', compact('contactInfo'));
    }

    /**
     * Update contact information
     */
    public function update(Request $request, $id)
    {
        $contactInfo = ContactInfo::findOrFail($id);
        
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone_primary' => 'nullable|string|max:20',
            'phone_secondary' => 'nullable|string|max:20',
            'email_primary' => 'nullable|email|max:255',
            'email_secondary' => 'nullable|email|max:255',
            'whatsapp' => 'nullable|string|max:20',
            'business_hours' => 'nullable|string',
            'map_embed_url' => 'nullable|url',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        // Handle business hours as JSON
        if ($request->has('business_hours')) {
            $businessHours = [
                'monday_friday' => $request->input('monday_friday', '08:00 - 17:00'),
                'saturday' => $request->input('saturday', '08:00 - 15:00'),
                'sunday' => $request->input('sunday', '09:00 - 14:00')
            ];
            $validated['business_hours'] = json_encode($businessHours);
        }

        $contactInfo->update($validated);

        return redirect()->route('admin.contact.index')
            ->with('success', 'Informasi kontak berhasil diperbarui!');
    }

    /**
     * Create new contact info
     */
    public function create()
    {
        return view('admin.contact.create');
    }

    /**
     * Store new contact info
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone_primary' => 'nullable|string|max:20',
            'phone_secondary' => 'nullable|string|max:20',
            'email_primary' => 'nullable|email|max:255',
            'email_secondary' => 'nullable|email|max:255',
            'whatsapp' => 'nullable|string|max:20',
            'business_hours' => 'nullable|string',
            'map_embed_url' => 'nullable|url',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        // Handle business hours as JSON
        $businessHours = [
            'monday_friday' => $request->input('monday_friday', '08:00 - 17:00'),
            'saturday' => $request->input('saturday', '08:00 - 15:00'),
            'sunday' => $request->input('sunday', '09:00 - 14:00')
        ];
        $validated['business_hours'] = json_encode($businessHours);

        ContactInfo::create($validated);

        return redirect()->route('admin.contact.index')
            ->with('success', 'Informasi kontak berhasil dibuat!');
    }

    /**
     * Set contact info as active
     */
    public function setActive($id)
    {
        $contactInfo = ContactInfo::findOrFail($id);
        
        // Deactivate all contact infos
        ContactInfo::where('is_active', true)->update(['is_active' => false]);
        
        // Activate selected contact info
        $contactInfo->update(['is_active' => true]);

        return redirect()->route('admin.contact.index')
            ->with('success', 'Informasi kontak berhasil diaktifkan!');
    }

    /**
     * Delete contact info
     */
    public function destroy($id)
    {
        $contactInfo = ContactInfo::findOrFail($id);
        
        if ($contactInfo->is_active) {
            return redirect()->route('admin.contact.index')
                ->with('error', 'Tidak dapat menghapus informasi kontak yang sedang aktif!');
        }

        $contactInfo->delete();

        return redirect()->route('admin.contact.index')
            ->with('success', 'Informasi kontak berhasil dihapus!');
    }
}
