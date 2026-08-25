@extends('layouts.app')

@section('title', 'Pengaturan - AKTALINK')
@section('page-title', 'Pengaturan')
@section('page-description', 'Kelola konfigurasi sistem AKTALINK')

@section('page-actions')
    <button type="button" class="btn-outline-danger" onclick="resetSettings()">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="23 4 23 10 17 10"/>
            <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
        </svg>
        Reset Default
    </button>
@endsection

@section('content')

<div class="settings-container">
    {{-- Sidebar Navigation --}}
    <div class="settings-sidebar">
        <div class="settings-nav">
            <a href="#general" class="settings-nav-item active" data-target="general">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="3"/>
                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                </svg>
                <span>Umum</span>
            </a>
            <a href="#notification" class="settings-nav-item" data-target="notification">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                </svg>
                <span>Notifikasi</span>
            </a>
            <a href="#security" class="settings-nav-item" data-target="security">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    <polyline points="9 12 11 14 15 10"/>
                </svg>
                <span>Keamanan</span>
            </a>
            <a href="#system" class="settings-nav-item" data-target="system">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="3" width="20" height="14" rx="2"/>
                    <line x1="8" y1="21" x2="16" y2="21"/>
                    <line x1="12" y1="17" x2="12" y2="21"/>
                </svg>
                <span>Sistem</span>
            </a>
        </div>
    </div>

    {{-- Settings Content --}}
    <div class="settings-content">
        {{-- General Settings --}}
        <div class="settings-panel active" id="panel-general">
            <div class="settings-header">
                <h3>Pengaturan Umum</h3>
                <p>Konfigurasi dasar aplikasi dan informasi perusahaan</p>
            </div>
            <form id="generalForm" class="settings-form">
                @csrf
                @method('PUT')
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nama Aplikasi <span class="text-danger">*</span></label>
                        <input type="text" name="app_name" class="form-input" value="{{ $generalSettings['app_name'] ?? 'AKTALINK' }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Versi Aplikasi <span class="text-danger">*</span></label>
                        <input type="text" name="app_version" class="form-input" value="{{ $generalSettings['app_version'] ?? '1.0.0' }}" required>
                    </div>
                    <div class="form-group full-width">
                        <label class="form-label">Nama Perusahaan <span class="text-danger">*</span></label>
                        <input type="text" name="company_name" class="form-input" value="{{ $generalSettings['company_name'] ?? '' }}" required>
                    </div>
                    <div class="form-group full-width">
                        <label class="form-label">Alamat</label>
                        <textarea name="company_address" class="form-textarea" rows="2">{{ $generalSettings['company_address'] ?? '' }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Telepon</label>
                        <input type="text" name="company_phone" class="form-input" value="{{ $generalSettings['company_phone'] ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="company_email" class="form-input" value="{{ $generalSettings['company_email'] ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Timezone <span class="text-danger">*</span></label>
                        <select name="timezone" class="form-select">
                            <option value="Asia/Jakarta" {{ ($generalSettings['timezone'] ?? 'Asia/Jakarta') == 'Asia/Jakarta' ? 'selected' : '' }}>Asia/Jakarta (WIB)</option>
                            <option value="Asia/Makassar" {{ ($generalSettings['timezone'] ?? '') == 'Asia/Makassar' ? 'selected' : '' }}>Asia/Makassar (WITA)</option>
                            <option value="Asia/Jayapura" {{ ($generalSettings['timezone'] ?? '') == 'Asia/Jayapura' ? 'selected' : '' }}>Asia/Jayapura (WIT)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Format Tanggal <span class="text-danger">*</span></label>
                        <select name="date_format" class="form-select">
                            <option value="d-m-Y" {{ ($generalSettings['date_format'] ?? 'd-m-Y') == 'd-m-Y' ? 'selected' : '' }}>DD-MM-YYYY</option>
                            <option value="m-d-Y" {{ ($generalSettings['date_format'] ?? '') == 'm-d-Y' ? 'selected' : '' }}>MM-DD-YYYY</option>
                            <option value="Y-m-d" {{ ($generalSettings['date_format'] ?? '') == 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                            <option value="d/m/Y" {{ ($generalSettings['date_format'] ?? '') == 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY</option>
                        </select>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/>
                            <polyline points="7 3 7 8 15 8"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        {{-- Notification Settings --}}
        <div class="settings-panel" id="panel-notification">
            <div class="settings-header">
                <h3>Pengaturan Notifikasi</h3>
                <p>Konfigurasi notifikasi dan pengingat sistem</p>
            </div>
            <form id="notificationForm" class="settings-form">
                @csrf
                @method('PUT')
                <div class="form-grid">
                    <div class="form-group full-width">
                        <div class="toggle-group">
                            <label class="toggle-label">
                                <input type="checkbox" name="email_notification" value="1" {{ ($notificationSettings['email_notification'] ?? true) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                                <span class="toggle-text">Notifikasi Email</span>
                            </label>
                            <p class="toggle-desc">Kirim notifikasi melalui email untuk setiap aktivitas penting</p>
                        </div>
                    </div>
                    <div class="form-group full-width">
                        <div class="toggle-group">
                            <label class="toggle-label">
                                <input type="checkbox" name="push_notification" value="1" {{ ($notificationSettings['push_notification'] ?? true) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                                <span class="toggle-text">Notifikasi Push</span>
                            </label>
                            <p class="toggle-desc">Kirim notifikasi push di dalam aplikasi</p>
                        </div>
                    </div>
                    <div class="form-group full-width">
                        <div class="toggle-group">
                            <label class="toggle-label">
                                <input type="checkbox" name="notify_new_permohonan" value="1" {{ ($notificationSettings['notify_new_permohonan'] ?? true) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                                <span class="toggle-text">Notifikasi Permohonan Baru</span>
                            </label>
                            <p class="toggle-desc">Dapatkan notifikasi ketika ada permohonan baru</p>
                        </div>
                    </div>
                    <div class="form-group full-width">
                        <div class="toggle-group">
                            <label class="toggle-label">
                                <input type="checkbox" name="notify_status_change" value="1" {{ ($notificationSettings['notify_status_change'] ?? true) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                                <span class="toggle-text">Notifikasi Perubahan Status</span>
                            </label>
                            <p class="toggle-desc">Dapatkan notifikasi ketika status permohonan berubah</p>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/>
                            <polyline points="7 3 7 8 15 8"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        {{-- Security Settings --}}
        <div class="settings-panel" id="panel-security">
            <div class="settings-header">
                <h3>Pengaturan Keamanan</h3>
                <p>Konfigurasi keamanan dan autentikasi sistem</p>
            </div>
            <form id="securityForm" class="settings-form">
                @csrf
                @method('PUT')
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Minimal Panjang Password <span class="text-danger">*</span></label>
                        <input type="number" name="password_min_length" class="form-input" value="{{ $securitySettings['password_min_length'] ?? 6 }}" min="4" max="20" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Session Timeout (menit) <span class="text-danger">*</span></label>
                        <input type="number" name="session_timeout" class="form-input" value="{{ $securitySettings['session_timeout'] ?? 120 }}" min="5" max="480" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Maksimal Login Gagal <span class="text-danger">*</span></label>
                        <input type="number" name="max_login_attempts" class="form-input" value="{{ $securitySettings['max_login_attempts'] ?? 5 }}" min="1" max="20" required>
                    </div>
                    <div class="form-group full-width">
                        <div class="toggle-group">
                            <label class="toggle-label">
                                <input type="checkbox" name="force_strong_password" value="1" {{ ($securitySettings['force_strong_password'] ?? false) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                                <span class="toggle-text">Password Kuat (Wajib)</span>
                            </label>
                            <p class="toggle-desc">Password harus mengandung huruf besar, kecil, angka, dan simbol</p>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/>
                            <polyline points="7 3 7 8 15 8"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        {{-- System Settings --}}
        <div class="settings-panel" id="panel-system">
            <div class="settings-header">
                <h3>Pengaturan Sistem</h3>
                <p>Konfigurasi sistem dan maintenance</p>
            </div>
            <form id="systemForm" class="settings-form">
                @csrf
                @method('PUT')
                <div class="form-grid">
                    <div class="form-group full-width">
                        <div class="toggle-group">
                            <label class="toggle-label">
                                <input type="checkbox" name="maintenance_mode" value="1" {{ ($systemSettings['maintenance_mode'] ?? false) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                                <span class="toggle-text">Mode Pemeliharaan</span>
                            </label>
                            <p class="toggle-desc">Aktifkan mode pemeliharaan untuk menonaktifkan akses pengguna sementara</p>
                        </div>
                    </div>
                    <div class="form-group full-width">
                        <div class="toggle-group">
                            <label class="toggle-label">
                                <input type="checkbox" name="debug_mode" value="1" {{ ($systemSettings['debug_mode'] ?? false) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                                <span class="toggle-text">Mode Debug</span>
                            </label>
                            <p class="toggle-desc">Aktifkan mode debug untuk menampilkan error detail (hanya untuk pengembangan)</p>
                        </div>
                    </div>
                    <div class="form-group full-width">
                        <div class="toggle-group">
                            <label class="toggle-label">
                                <input type="checkbox" name="log_aktivitas" value="1" {{ ($systemSettings['log_aktivitas'] ?? true) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                                <span class="toggle-text">Log Aktivitas</span>
                            </label>
                            <p class="toggle-desc">Catat semua aktivitas pengguna untuk keperluan audit</p>
                        </div>
                    </div>
                    <div class="form-group full-width">
                        <div class="toggle-group">
                            <label class="toggle-label">
                                <input type="checkbox" name="auto_backup" value="1" {{ ($systemSettings['auto_backup'] ?? false) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                                <span class="toggle-text">Backup Otomatis</span>
                            </label>
                            <p class="toggle-desc">Lakukan backup database secara otomatis setiap hari</p>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/>
                            <polyline points="7 3 7 8 15 8"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- TOAST NOTIFICATION --}}
<div id="toastContainer" style="position: fixed; top: 20px; right: 20px; z-index: 99999; display: flex; flex-direction: column; gap: 8px;"></div>

@endsection

@push('styles')
<style>
/* ============================================
   SETTINGS CONTAINER
============================================ */
.settings-container {
    display: grid;
    grid-template-columns: 220px 1fr;
    gap: 24px;
}

/* ============================================
   SETTINGS SIDEBAR
============================================ */
.settings-sidebar {
    background: white;
    border-radius: 16px;
    border: 1px solid #f0f2f1;
    padding: 16px 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    height: fit-content;
    position: sticky;
    top: 90px;
}

.settings-nav {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.settings-nav-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 14px;
    border-radius: 10px;
    color: #4a5a54;
    text-decoration: none;
    transition: all 0.2s ease;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
}

.settings-nav-item:hover {
    background: #f0f5f2;
    color: #1d2b27;
}

.settings-nav-item.active {
    background: #07573c;
    color: white;
}

.settings-nav-item.active svg {
    stroke: white;
}

.settings-nav-item svg {
    flex-shrink: 0;
}

/* ============================================
   SETTINGS CONTENT
============================================ */
.settings-content {
    background: white;
    border-radius: 16px;
    border: 1px solid #f0f2f1;
    padding: 24px 32px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}

.settings-panel {
    display: none;
}

.settings-panel.active {
    display: block;
}

.settings-header {
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 1px solid #f0f2f1;
}

.settings-header h3 {
    font-size: 18px;
    font-weight: 700;
    color: #1d2b27;
    margin: 0 0 4px;
}

.settings-header p {
    font-size: 13px;
    color: #8a9a94;
    margin: 0;
}

/* ============================================
   FORM
============================================ */
.settings-form .form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.settings-form .form-group {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.settings-form .form-group.full-width {
    grid-column: 1 / -1;
}

.settings-form .form-label {
    font-size: 13px;
    font-weight: 600;
    color: #1d2b27;
}

.settings-form .form-input,
.settings-form .form-select,
.settings-form .form-textarea {
    padding: 10px 14px;
    border: 1px solid #e9ecef;
    border-radius: 10px;
    font-size: 13px;
    font-family: inherit;
    background: #fafcfb;
    color: #1d2b27;
    width: 100%;
    transition: all 0.3s ease;
}

.settings-form .form-input:focus,
.settings-form .form-select:focus,
.settings-form .form-textarea:focus {
    outline: none;
    border-color: #07573c;
    background: white;
    box-shadow: 0 0 0 4px rgba(7, 87, 60, 0.08);
}

.settings-form .form-textarea {
    resize: vertical;
    min-height: 60px;
}

/* ============================================
   TOGGLE
============================================ */
.toggle-group {
    padding: 8px 0;
}

.toggle-label {
    display: flex;
    align-items: center;
    gap: 12px;
    cursor: pointer;
    font-weight: 500;
    font-size: 14px;
    color: #1d2b27;
}

.toggle-label input[type="checkbox"] {
    display: none;
}

.toggle-slider {
    width: 44px;
    height: 24px;
    background: #dce2e0;
    border-radius: 12px;
    position: relative;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.toggle-slider::after {
    content: '';
    position: absolute;
    width: 18px;
    height: 18px;
    background: white;
    border-radius: 50%;
    top: 3px;
    left: 3px;
    transition: all 0.3s ease;
    box-shadow: 0 1px 4px rgba(0,0,0,0.15);
}

.toggle-label input:checked + .toggle-slider {
    background: #07573c;
}

.toggle-label input:checked + .toggle-slider::after {
    left: 23px;
}

.toggle-text {
    user-select: none;
}

.toggle-desc {
    font-size: 12px;
    color: #8a9a94;
    margin: 4px 0 0 56px;
}

/* ============================================
   FORM ACTIONS
============================================ */
.form-actions {
    grid-column: 1 / -1;
    padding-top: 16px;
    border-top: 1px solid #f0f2f1;
    margin-top: 8px;
}

.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 24px;
    background: #07573c;
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    font-family: inherit;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: #043d2a;
    transform: translateY(-1px);
    box-shadow: 0 4px 16px rgba(7, 87, 60, 0.25);
}

.btn-outline-danger {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 9px 16px;
    background: transparent;
    color: #dc2626;
    border: 1px solid #fde8e8;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 600;
    font-family: inherit;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-outline-danger:hover {
    background: #fde8e8;
    border-color: #dc2626;
}

.text-danger { color: #dc2626; }

/* ============================================
   TOAST
============================================ */
#toastContainer .toast {
    padding: 14px 20px;
    border-radius: 12px;
    color: white;
    font-size: 14px;
    font-weight: 500;
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    animation: slideInRight 0.3s ease;
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 280px;
    max-width: 420px;
}

.toast-success { background: #059669; }
.toast-error { background: #dc2626; }
.toast-info { background: #2563eb; }

@keyframes slideInRight {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

@keyframes fadeOut {
    from { opacity: 1; }
    to { opacity: 0; transform: translateX(100%); }
}

#toastContainer .toast.hide {
    animation: fadeOut 0.3s ease forwards;
}

/* ============================================
   RESPONSIVE
============================================ */
@media (max-width: 992px) {
    .settings-container {
        grid-template-columns: 1fr;
    }
    .settings-sidebar {
        position: relative;
        top: 0;
        padding: 12px 8px;
    }
    .settings-nav {
        flex-direction: row;
        flex-wrap: wrap;
        gap: 4px;
    }
    .settings-nav-item {
        padding: 8px 14px;
        font-size: 12px;
    }
    .settings-content {
        padding: 20px;
    }
    .settings-form .form-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .settings-content {
        padding: 16px;
    }
    .settings-nav-item {
        padding: 6px 10px;
        font-size: 11px;
        gap: 6px;
    }
    .settings-nav-item span {
        display: none;
    }
    .settings-nav-item svg {
        margin: 0;
    }
    .toggle-desc {
        margin-left: 0;
    }
}
</style>
@endpush

@push('scripts')
<script>
// ============================================
// TOAST NOTIFICATION
// ============================================
function showToast(message, type = 'success') {
    const container = document.getElementById('toastContainer');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;

    const icons = {
        success: `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>`,
        error: `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>`,
        info: `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>`
    };

    toast.innerHTML = `
        ${icons[type] || icons.info}
        <span>${message}</span>
    `;

    container.appendChild(toast);

    setTimeout(() => {
        toast.classList.add('hide');
        setTimeout(() => toast.remove(), 300);
    }, 4000);
}

// ============================================
// NAVIGATION
// ============================================
document.querySelectorAll('.settings-nav-item').forEach(item => {
    item.addEventListener('click', function(e) {
        e.preventDefault();

        // Update nav active
        document.querySelectorAll('.settings-nav-item').forEach(n => n.classList.remove('active'));
        this.classList.add('active');

        // Update panel
        const target = this.dataset.target;
        document.querySelectorAll('.settings-panel').forEach(p => p.classList.remove('active'));
        document.getElementById(`panel-${target}`).classList.add('active');

        // Update URL hash
        history.pushState(null, '', `#${target}`);
    });
});

// Check hash on load
document.addEventListener('DOMContentLoaded', function() {
    const hash = window.location.hash.replace('#', '');
    if (hash) {
        const target = document.querySelector(`.settings-nav-item[data-target="${hash}"]`);
        if (target) {
            target.click();
        }
    }
});

// ============================================
// FORM SUBMITS
// ============================================
function submitForm(formId, url, successMessage) {
    const form = document.getElementById(formId);
    if (!form) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const submitBtn = this.querySelector('.btn-primary');
        if (!submitBtn) return;

        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Menyimpan...';

        const formData = new FormData(this);

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
            } else {
                if (data.errors) {
                    let errorMsg = '';
                    Object.values(data.errors).forEach(err => {
                        errorMsg += err[0] + '\n';
                    });
                    showToast(errorMsg, 'error');
                } else {
                    showToast(data.message || 'Terjadi kesalahan', 'error');
                }
            }
        })
        .catch(error => {
            showToast('Terjadi kesalahan pada server', 'error');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = `
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                    <polyline points="17 21 17 13 7 13 7 21"/>
                    <polyline points="7 3 7 8 15 8"/>
                </svg>
                Simpan Perubahan
            `;
        });
    });
}

// Init forms
document.addEventListener('DOMContentLoaded', function() {
    submitForm('generalForm', '{{ route('admin.settings.update-general') }}', 'Pengaturan umum berhasil diperbarui!');
    submitForm('notificationForm', '{{ route('admin.settings.update-notification') }}', 'Pengaturan notifikasi berhasil diperbarui!');
    submitForm('securityForm', '{{ route('admin.settings.update-security') }}', 'Pengaturan keamanan berhasil diperbarui!');
    submitForm('systemForm', '{{ route('admin.settings.update-system') }}', 'Pengaturan sistem berhasil diperbarui!');
});

// ============================================
// RESET SETTINGS
// ============================================
function resetSettings() {
    if (!confirm('⚠️ Apakah Anda yakin ingin mereset semua pengaturan ke default?\n\nSemua pengaturan akan kembali ke nilai awal.')) {
        return;
    }

    if (!confirm('Konfirmasi ulang: Reset semua pengaturan?')) {
        return;
    }

    fetch('{{ route('admin.settings.reset') }}', {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            setTimeout(() => window.location.reload(), 500);
        } else {
            showToast(data.message || 'Gagal reset pengaturan', 'error');
        }
    })
    .catch(error => {
        showToast('Terjadi kesalahan pada server', 'error');
    });
}
</script>
@endpush