<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    /**
     * Display settings page.
     */
    public function index()
    {
        // General Settings
        $generalSettings = [
            'app_name' => Setting::get('app_name', 'AKTALINK'),
            'app_version' => Setting::get('app_version', '1.0.0'),
            'company_name' => Setting::get('company_name', 'Dinas Kependudukan dan Pencatatan Sipil Kota Medan'),
            'company_address' => Setting::get('company_address', 'Jalan Contoh No. 123, Kota Medan'),
            'company_phone' => Setting::get('company_phone', '061-1234567'),
            'company_email' => Setting::get('company_email', 'info@disdukcapil.go.id'),
            'timezone' => Setting::get('timezone', 'Asia/Jakarta'),
            'date_format' => Setting::get('date_format', 'd-m-Y'),
        ];

        // Notification Settings
        $notificationSettings = [
            'email_notification' => Setting::get('email_notification', true),
            'push_notification' => Setting::get('push_notification', true),
            'notify_new_permohonan' => Setting::get('notify_new_permohonan', true),
            'notify_status_change' => Setting::get('notify_status_change', true),
        ];

        // Security Settings
        $securitySettings = [
            'password_min_length' => Setting::get('password_min_length', 6),
            'session_timeout' => Setting::get('session_timeout', 120),
            'max_login_attempts' => Setting::get('max_login_attempts', 5),
            'force_strong_password' => Setting::get('force_strong_password', false),
        ];

        // System Settings
        $systemSettings = [
            'maintenance_mode' => Setting::get('maintenance_mode', false),
            'debug_mode' => Setting::get('debug_mode', false),
            'log_aktivitas' => Setting::get('log_aktivitas', true),
            'auto_backup' => Setting::get('auto_backup', false),
        ];

        return view('admin.settings.index', compact(
            'generalSettings',
            'notificationSettings',
            'securitySettings',
            'systemSettings'
        ));
    }

    /**
     * Update general settings.
     */
    public function updateGeneral(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'app_name' => 'required|string|max:100',
            'app_version' => 'required|string|max:20',
            'company_name' => 'required|string|max:200',
            'company_address' => 'nullable|string|max:500',
            'company_phone' => 'nullable|string|max:20',
            'company_email' => 'nullable|email|max:100',
            'timezone' => 'required|string|max:50',
            'date_format' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            foreach ($request->except(['_token', '_method']) as $key => $value) {
                Setting::set($key, $value);
            }

            return response()->json([
                'success' => true,
                'message' => 'Pengaturan umum berhasil diperbarui!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update notification settings.
     */
    public function updateNotification(Request $request)
    {
        try {
            $settings = [
                'email_notification' => $request->has('email_notification'),
                'push_notification' => $request->has('push_notification'),
                'notify_new_permohonan' => $request->has('notify_new_permohonan'),
                'notify_status_change' => $request->has('notify_status_change'),
            ];

            foreach ($settings as $key => $value) {
                Setting::set($key, $value);
            }

            return response()->json([
                'success' => true,
                'message' => 'Pengaturan notifikasi berhasil diperbarui!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update security settings.
     */
    public function updateSecurity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password_min_length' => 'required|integer|min:4|max:20',
            'session_timeout' => 'required|integer|min:5|max:480',
            'max_login_attempts' => 'required|integer|min:1|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $settings = [
                'password_min_length' => $request->password_min_length,
                'session_timeout' => $request->session_timeout,
                'max_login_attempts' => $request->max_login_attempts,
                'force_strong_password' => $request->has('force_strong_password'),
            ];

            foreach ($settings as $key => $value) {
                Setting::set($key, $value);
            }

            return response()->json([
                'success' => true,
                'message' => 'Pengaturan keamanan berhasil diperbarui!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update system settings.
     */
    public function updateSystem(Request $request)
    {
        try {
            $settings = [
                'maintenance_mode' => $request->has('maintenance_mode'),
                'debug_mode' => $request->has('debug_mode'),
                'log_aktivitas' => $request->has('log_aktivitas'),
                'auto_backup' => $request->has('auto_backup'),
            ];

            foreach ($settings as $key => $value) {
                Setting::set($key, $value);
            }

            return response()->json([
                'success' => true,
                'message' => 'Pengaturan sistem berhasil diperbarui!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reset all settings to default.
     */
    public function reset()
    {
        try {
            Setting::truncate();

            // Seed default settings
            $defaults = [
                ['key' => 'app_name', 'value' => 'AKTALINK', 'group' => 'general'],
                ['key' => 'app_version', 'value' => '1.0.0', 'group' => 'general'],
                ['key' => 'company_name', 'value' => 'Dinas Kependudukan dan Pencatatan Sipil Kota Medan', 'group' => 'general'],
                ['key' => 'company_address', 'value' => 'Jalan Contoh No. 123, Kota Medan', 'group' => 'general'],
                ['key' => 'company_phone', 'value' => '061-1234567', 'group' => 'general'],
                ['key' => 'company_email', 'value' => 'info@disdukcapil.go.id', 'group' => 'general'],
                ['key' => 'timezone', 'value' => 'Asia/Jakarta', 'group' => 'general'],
                ['key' => 'date_format', 'value' => 'd-m-Y', 'group' => 'general'],
                ['key' => 'email_notification', 'value' => true, 'group' => 'notification'],
                ['key' => 'push_notification', 'value' => true, 'group' => 'notification'],
                ['key' => 'notify_new_permohonan', 'value' => true, 'group' => 'notification'],
                ['key' => 'notify_status_change', 'value' => true, 'group' => 'notification'],
                ['key' => 'password_min_length', 'value' => 6, 'group' => 'security'],
                ['key' => 'session_timeout', 'value' => 120, 'group' => 'security'],
                ['key' => 'max_login_attempts', 'value' => 5, 'group' => 'security'],
                ['key' => 'force_strong_password', 'value' => false, 'group' => 'security'],
                ['key' => 'maintenance_mode', 'value' => false, 'group' => 'system'],
                ['key' => 'debug_mode', 'value' => false, 'group' => 'system'],
                ['key' => 'log_aktivitas', 'value' => true, 'group' => 'system'],
                ['key' => 'auto_backup', 'value' => false, 'group' => 'system'],
            ];

            foreach ($defaults as $default) {
                Setting::create($default);
            }

            return response()->json([
                'success' => true,
                'message' => 'Semua pengaturan berhasil direset ke default!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}