<?php

namespace App\Traits;

use App\Models\AktivitasLog;
use Illuminate\Support\Facades\Log;

trait LogsActivity
{
    protected function logActivity($aktivitas, $deskripsi = null, $subject = null)
    {
        try {
            // ✅ CEK USER LOGIN
            if (!auth()->check()) {
                Log::warning('User tidak login, logging dibatalkan');
                return null;
            }

            Log::info('=== LOGGING AKTIVITAS ===');
            Log::info('Aktivitas: ' . $aktivitas);
            Log::info('User ID: ' . auth()->id());

            $log = new AktivitasLog();
            $log->user_id = auth()->id();
            $log->aktivitas = $aktivitas;
            $log->deskripsi = $deskripsi;
            
            if ($subject) {
                $log->subject_type = get_class($subject);
                $log->subject_id = $subject->id;
                Log::info('Subject Type: ' . get_class($subject));
                Log::info('Subject ID: ' . $subject->id);
            }
            
            $log->ip_address = request()->ip();
            $log->user_agent = request()->userAgent();
            $log->method = request()->method();
            $log->url = request()->fullUrl();
            $log->created_at = now();
            $log->save();
            
            Log::info('Log berhasil disimpan, ID: ' . $log->id);
            return $log;
            
        } catch (\Exception $e) {
            Log::error('Gagal mencatat aktivitas: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return null;
        }
    }

    protected function logWithSubject($aktivitas, $subject, $deskripsi = null)
    {
        return $this->logActivity($aktivitas, $deskripsi, $subject);
    }

    protected function logSimple($aktivitas, $deskripsi = null)
    {
        return $this->logActivity($aktivitas, $deskripsi);
    }
}