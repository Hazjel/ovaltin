<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotificationSetting;
use App\Services\WhatsAppService;

class NotificationSettingController extends Controller
{
    public function index()
    {
        $settings = NotificationSetting::getSettings();
        $logs = \App\Models\NotificationLog::latest()->take(15)->get();
        return view('admin.notification-settings.index', compact('settings', 'logs'));
    }

    public function update(Request $request, NotificationSetting $notificationSetting)
    {
        $request->validate([
            'recipient_phone'  => 'required|string|min:10|max:15',
            'morning_time'     => 'required|date_format:H:i',
            'evening_time'     => 'required|date_format:H:i',
            'target_days'      => 'required|array|min:1',
            'target_days.*'    => 'string|in:0,1,2,3,4,5,6',
            'message_template' => 'nullable|string|max:1000',
            'is_active'        => 'nullable|boolean',
        ]);

        $notificationSetting->update([
            'recipient_phone'  => $request->recipient_phone,
            'morning_time'     => $request->morning_time,
            'evening_time'     => $request->evening_time,
            'target_days'      => $request->target_days,
            'message_template' => $request->message_template ?: null,
            'is_active'        => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'Pengaturan notifikasi berhasil disimpan!');
    }

    public function testSend(Request $request, WhatsAppService $wa)
    {
        $settings = NotificationSetting::getSettings();

        $sent = $wa->sendTest($settings->recipient_phone, $settings);

        if ($sent) {
            return back()->with('success', '✅ Pesan test berhasil dikirim ke ' . $settings->recipient_phone . '!');
        }

        return back()->with('error', '❌ Gagal mengirim pesan test. Pastikan token Fonnte sudah benar di .env');
    }
}
