@extends('layouts.app')

@section('title', 'Profil Saya - AKTALINK')
@section('page-title', 'Profil Saya')
@section('page-description', 'Kelola informasi profil dan keamanan akun Anda')

@section('page-actions')
    <button type="button" class="btn-outline" onclick="window.location.reload()">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="23 4 23 10 17 10"/>
            <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
        </svg>
        Refresh
    </button>
@endsection

@section('content')

<div class="profile-container">
    {{-- Sidebar Profil --}}
    <div class="profile-sidebar">
        <div class="profile-card">
            <div class="profile-avatar-wrapper">
                <div class="profile-avatar-large" id="profileAvatar">
                    @if($user->photo)
                        <img src="{{ asset('storage/photos/' . $user->photo) }}" alt="{{ $user->name }}" id="avatarImage">
                    @else
                        <span id="avatarText">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                    @endif
                </div>
                <div class="profile-avatar-badge" style="background: {{ $user->role_color }}">
                    {{ $user->role_label }}
                </div>
            </div>
            <div class="profile-info-card">
                <h3 class="profile-name-card">{{ $user->name }}</h3>
                <p class="profile-username-card">@ {{ $user->username }}</p>
                <div class="profile-status">
                    <span class="status-badge {{ $user->is_active ? 'active' : 'inactive' }}">
                        <span class="status-dot"></span>
                        {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                    <span class="profile-joined">Bergabung: {{ $user->created_at->format('d M Y') }}</span>
                </div>
            </div>
            <div class="profile-menu-nav">
                <a href="#profile" class="profile-nav-item active" data-target="profile">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    Profil Saya
                </a>
                <a href="#password" class="profile-nav-item" data-target="password">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                    Keamanan
                </a>
            </div>
        </div>
    </div>

    {{-- Content Profil --}}
    <div class="profile-content">
        {{-- Panel Profil --}}
        <div class="profile-panel active" id="panel-profile">
            <div class="profile-header">
                <h3>Informasi Profil</h3>
                <p>Perbarui informasi profil Anda</p>
            </div>

            <form id="profileForm" class="profile-form" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="form-group full-width">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                        <span class="form-error" id="error-name"></span>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-input" value="{{ old('username', $user->username) }}" required>
                        <span class="form-error" id="error-username"></span>
                    </div>

                    <div class="form-group">
                        <label class="form-label">No. HP</label>
                        <input type="text" name="phone" class="form-input" value="{{ old('phone', $user->phone) }}">
                        <span class="form-error" id="error-phone"></span>
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">Role</label>
                        <input type="text" class="form-input" value="{{ $user->role_label }}" disabled style="background: #f0f5f2; cursor: not-allowed;">
                        <span class="form-hint">Role tidak dapat diubah</span>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary" id="profileSubmit">
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

        {{-- Panel Password --}}
        <div class="profile-panel" id="panel-password">
            <div class="profile-header">
                <h3>Keamanan Akun</h3>
                <p>Perbarui password untuk keamanan akun Anda</p>
            </div>

            <form id="passwordForm" class="profile-form">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="form-group full-width">
                        <label class="form-label">Password Saat Ini <span class="text-danger">*</span></label>
                        <div class="password-input-wrapper">
                            <input type="password" name="current_password" class="form-input" placeholder="Masukkan password saat ini" required>
                            <button type="button" class="password-toggle" onclick="togglePassword(this)">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                        <span class="form-error" id="error-current_password"></span>
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">Password Baru <span class="text-danger">*</span></label>
                        <div class="password-input-wrapper">
                            <input type="password" name="new_password" class="form-input" placeholder="Minimal 6 karakter" required>
                            <button type="button" class="password-toggle" onclick="togglePassword(this)">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                        <span class="form-hint">Minimal 6 karakter</span>
                        <span class="form-error" id="error-new_password"></span>
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                        <div class="password-input-wrapper">
                            <input type="password" name="new_password_confirmation" class="form-input" placeholder="Konfirmasi password baru" required>
                            <button type="button" class="password-toggle" onclick="togglePassword(this)">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                        <span class="form-error" id="error-new_password_confirmation"></span>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary" id="passwordSubmit">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/>
                            <polyline points="7 3 7 8 15 8"/>
                        </svg>
                        Update Password
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
   PROFILE CONTAINER
============================================ */
.profile-container {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 24px;
}

/* ============================================
   PROFILE SIDEBAR
============================================ */
.profile-sidebar {
    position: sticky;
    top: 90px;
}

.profile-card {
    background: white;
    border-radius: 16px;
    border: 1px solid #f0f2f1;
    padding: 24px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}

.profile-avatar-wrapper {
    position: relative;
    text-align: center;
    margin-bottom: 16px;
}

.profile-avatar-large {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #e8f0ed, #c5d9d0);
    color: #07573c;
    font-size: 36px;
    font-weight: 700;
    overflow: hidden;
    border: 3px solid white;
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
}

.profile-avatar-large img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile-avatar-badge {
    display: inline-block;
    padding: 3px 16px;
    border-radius: 12px;
    color: white;
    font-size: 11px;
    font-weight: 600;
    margin-top: 8px;
}

.profile-info-card {
    text-align: center;
    padding-bottom: 16px;
    border-bottom: 1px solid #f0f2f1;
    margin-bottom: 16px;
}

.profile-name-card {
    font-size: 18px;
    font-weight: 700;
    color: #1d2b27;
    margin-bottom: 4px;
}

.profile-username-card {
    font-size: 13px;
    color: #8a9a94;
    margin-bottom: 8px;
}

.profile-status {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 3px 14px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}

.status-badge.active {
    background: #d1fae5;
    color: #059669;
}

.status-badge.inactive {
    background: #fde8e8;
    color: #dc2626;
}

.status-badge .status-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: currentColor;
    display: inline-block;
}

.profile-joined {
    font-size: 12px;
    color: #8a9a94;
}

/* ============================================
   PROFILE NAV MENU
============================================ */
.profile-menu-nav {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.profile-nav-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 14px;
    border-radius: 10px;
    color: #4a5a54;
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
    transition: all 0.2s ease;
    cursor: pointer;
}

.profile-nav-item:hover {
    background: #f0f5f2;
    color: #1d2b27;
}

.profile-nav-item.active {
    background: #07573c;
    color: white;
}

.profile-nav-item.active svg {
    stroke: white;
}

.profile-nav-item svg {
    flex-shrink: 0;
}

/* ============================================
   PROFILE CONTENT
============================================ */
.profile-content {
    background: white;
    border-radius: 16px;
    border: 1px solid #f0f2f1;
    padding: 28px 32px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}

.profile-panel {
    display: none;
}

.profile-panel.active {
    display: block;
}

.profile-header {
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 1px solid #f0f2f1;
}

.profile-header h3 {
    font-size: 18px;
    font-weight: 700;
    color: #1d2b27;
    margin-bottom: 4px;
}

.profile-header p {
    font-size: 13px;
    color: #8a9a94;
}

/* ============================================
   PROFILE FORM
============================================ */
.profile-form .form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.profile-form .form-group {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.profile-form .form-group.full-width {
    grid-column: 1 / -1;
}

.profile-form .form-label {
    font-size: 13px;
    font-weight: 600;
    color: #1d2b27;
}

.profile-form .form-input {
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

.profile-form .form-input:focus {
    outline: none;
    border-color: #07573c;
    background: white;
    box-shadow: 0 0 0 4px rgba(7, 87, 60, 0.08);
}

.profile-form .form-input:disabled {
    background: #f0f5f2;
    cursor: not-allowed;
}

.profile-form .form-hint {
    font-size: 11px;
    color: #8a9a94;
}

.profile-form .form-error {
    font-size: 12px;
    color: #dc2626;
    display: none;
}

.profile-form .form-error.show {
    display: block;
}

.text-danger { color: #dc2626; }

/* ============================================
   PHOTO UPLOAD
============================================ */
.photo-upload {
    display: flex;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
}

.photo-preview {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    overflow: hidden;
    border: 2px solid #e9ecef;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8faf9;
}

.photo-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.photo-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #b0c4bc;
    font-size: 11px;
}

.photo-placeholder svg {
    color: #b0c4bc;
}

.photo-actions {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.btn-photo-upload {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    background: #07573c;
    color: white;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn-photo-upload:hover {
    background: #043d2a;
    transform: translateY(-1px);
}

.btn-photo-upload input[type="file"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
}

.btn-photo-delete {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    background: transparent;
    color: #dc2626;
    border: 1px solid #fde8e8;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-photo-delete:hover {
    background: #fde8e8;
}

/* ============================================
   PASSWORD INPUT
============================================ */
.password-input-wrapper {
    position: relative;
}

.password-input-wrapper .form-input {
    padding-right: 44px;
}

.password-toggle {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #8a9a94;
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 4px;
}

.password-toggle:hover {
    color: #4a5a54;
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

.btn-outline {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 9px 16px;
    background: transparent;
    color: #4a5a54;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 600;
    font-family: inherit;
    cursor: pointer;
    transition: all 0.3s ease;
    gap: 6px;
}

.btn-outline:hover {
    background: #f0f5f2;
    border-color: #c5ceca;
}

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
    .profile-container {
        grid-template-columns: 1fr;
    }
    .profile-sidebar {
        position: relative;
        top: 0;
    }
    .profile-card {
        padding: 20px;
    }
    .profile-content {
        padding: 20px;
    }
    .profile-form .form-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .profile-content {
        padding: 16px;
    }
    .profile-avatar-large {
        width: 80px;
        height: 80px;
        font-size: 28px;
    }
    .photo-upload {
        flex-direction: column;
        align-items: flex-start;
    }
    .photo-actions {
        width: 100%;
    }
    .btn-photo-upload,
    .btn-photo-delete {
        flex: 1;
        justify-content: center;
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
document.querySelectorAll('.profile-nav-item').forEach(item => {
    item.addEventListener('click', function(e) {
        e.preventDefault();

        document.querySelectorAll('.profile-nav-item').forEach(n => n.classList.remove('active'));
        this.classList.add('active');

        const target = this.dataset.target;
        document.querySelectorAll('.profile-panel').forEach(p => p.classList.remove('active'));
        document.getElementById(`panel-${target}`).classList.add('active');
    });
});

// ============================================
// PASSWORD TOGGLE
// ============================================
function togglePassword(btn) {
    const wrapper = btn.closest('.password-input-wrapper');
    const input = wrapper.querySelector('.form-input');

    if (input.type === 'password') {
        input.type = 'text';
        btn.innerHTML = `
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                <line x1="1" y1="1" x2="23" y2="23"/>
            </svg>
        `;
    } else {
        input.type = 'password';
        btn.innerHTML = `
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>
            </svg>
        `;
    }
}

// ============================================
// PHOTO PREVIEW
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    const photoInput = document.getElementById('photoInput');
    if (photoInput) {
        photoInput.addEventListener('change', function(e) {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const preview = document.getElementById('photoPreview');
                    const placeholder = document.getElementById('previewPlaceholder');

                    if (placeholder) {
                        placeholder.innerHTML = `
                            <img src="${event.target.result}" alt="Preview" style="width:100%;height:100%;object-fit:cover;">
                        `;
                    } else {
                        preview.innerHTML = `
                            <img src="${event.target.result}" alt="Preview" style="width:100%;height:100%;object-fit:cover;">
                        `;
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }
});

// ============================================
// PROFILE FORM SUBMIT
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    const profileForm = document.getElementById('profileForm');
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = document.getElementById('profileSubmit');
            if (!submitBtn) return;

            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Menyimpan...';

            const formData = new FormData(this);

            fetch('{{ route('admin.profile.update') }}', {
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

                    // Update avatar di sidebar
                    const avatarText = document.getElementById('avatarText');
                    const avatarImage = document.getElementById('avatarImage');

                    if (data.data.photo) {
                        if (avatarImage) {
                            avatarImage.src = '{{ asset('storage/photos/') }}/' + data.data.photo;
                        }
                        if (avatarText) {
                            avatarText.style.display = 'none';
                        }
                    } else {
                        if (avatarText) {
                            avatarText.style.display = 'flex';
                        }
                    }

                    // Update nama di sidebar
                    document.querySelector('.profile-name-card').textContent = data.data.name;

                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    if (data.errors) {
                        Object.keys(data.errors).forEach(key => {
                            const errorEl = document.getElementById(`error-${key}`);
                            if (errorEl) {
                                errorEl.textContent = data.errors[key][0];
                                errorEl.classList.add('show');
                            }
                        });
                        showToast('Silakan perbaiki form yang salah', 'error');
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
});

// ============================================
// PASSWORD FORM SUBMIT
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    const passwordForm = document.getElementById('passwordForm');
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = document.getElementById('passwordSubmit');
            if (!submitBtn) return;

            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Memproses...';

            const formData = new FormData(this);

            fetch('{{ route('admin.profile.update-password') }}', {
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
                    passwordForm.reset();
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    if (data.errors) {
                        Object.keys(data.errors).forEach(key => {
                            const errorEl = document.getElementById(`error-${key}`);
                            if (errorEl) {
                                errorEl.textContent = data.errors[key][0];
                                errorEl.classList.add('show');
                            }
                        });
                        showToast('Silakan perbaiki form yang salah', 'error');
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
                    Update Password
                `;
            });
        });
    }
});

// ============================================
// DELETE PHOTO
// ============================================
function deletePhoto() {
    if (!confirm('Apakah Anda yakin ingin menghapus foto profil?')) return;

    fetch('{{ route('admin.profile.delete-photo') }}', {
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
            showToast(data.message || 'Gagal menghapus foto', 'error');
        }
    })
    .catch(error => {
        showToast('Terjadi kesalahan pada server', 'error');
    });
}
</script>
@endpush