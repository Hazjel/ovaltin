<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InAppNotification;

class NotificationController extends Controller
{
    /**
     * Tampilkan riwayat notifikasi in-app
     */
    public function index(Request $request)
    {
        $notifications = InAppNotification::latest()->paginate(15);
        
        return view('admin.notifications.index', compact('notifications'));
    }

    /**
     * Tandai satu notifikasi sebagai dibaca dan redirect ke link target
     */
    public function read($id)
    {
        $notification = InAppNotification::findOrFail($id);
        
        $notification->update(['is_read' => true]);

        return redirect($notification->link);
    }

    /**
     * Tandai semua notifikasi belum dibaca sebagai dibaca
     */
    public function markAllRead()
    {
        InAppNotification::where('is_read', false)->update(['is_read' => true]);

        return back()->with('success', 'Semua notifikasi berhasil ditandai sebagai dibaca.');
    }
}
