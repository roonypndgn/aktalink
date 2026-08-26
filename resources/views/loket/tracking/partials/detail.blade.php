<div class="result-single">
    <div class="result-header">
        <h3>Hasil Tracking</h3>
    </div>

    <div class="tracking-card">
        {{-- Left Column --}}
        <div class="card">
            <div class="card-title">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#07573c" stroke-width="2">
                    <rect x="2" y="7" width="20" height="14" rx="2"/>
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                </svg>
                Informasi Permohonan
            </div>
            <div class="info-row">
                <span class="label">Nomor Permohonan</span>
                <span class="value">{{ $permohonan->nomor_permohonan }}</span>
            </div>
            <div class="info-row">
                <span class="label">Jenis Layanan</span>
                <span class="value">{{ $permohonan->jenisLayanan->nama_layanan }}</span>
            </div>
            <div class="info-row">
                <span class="label">Tanggal Permohonan</span>
                <span class="value">{{ $permohonan->tanggal_permohonan->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }}</span>
            </div>
            <div class="info-row">
                <span class="label">Prioritas</span>
                <span class="value">
                    <span class="priority-badge priority-{{ $permohonan->prioritas }}">
                        {{ $permohonan->label_prioritas }}
                    </span>
                </span>
            </div>
            @if($permohonan->catatan_loket)
            <div class="info-row">
                <span class="label">Catatan Loket</span>
                <span class="value">{{ $permohonan->catatan_loket }}</span>
            </div>
            @endif
        </div>

        {{-- Right Column --}}
        <div class="card">
            <div class="card-title">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#07573c" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                Data Pemohon
            </div>
            <div class="info-row">
                <span class="label">Nama Lengkap</span>
                <span class="value">{{ $permohonan->pemohon->nama_lengkap }}</span>
            </div>
            <div class="info-row">
                <span class="label">NIK</span>
                <span class="value">{{ $permohonan->pemohon->nik }}</span>
            </div>
            <div class="info-row">
                <span class="label">Tempat, Tanggal Lahir</span>
                <span class="value">{{ $permohonan->pemohon->tempat_lahir ?? '-' }}, {{ $permohonan->pemohon->tanggal_lahir ? $permohonan->pemohon->tanggal_lahir->setTimezone('Asia/Jakarta')->format('d M Y') : '-' }}</span>
            </div>
            <div class="info-row">
                <span class="label">Jenis Kelamin</span>
                <span class="value">{{ $permohonan->pemohon->jenis_kelamin == 'L' ? 'Laki-laki' : ($permohonan->pemohon->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</span>
            </div>
            <div class="info-row">
                <span class="label">No. Telepon</span>
                <span class="value">{{ $permohonan->pemohon->no_telepon ?? '-' }}</span>
            </div>
        </div>
    </div>

    {{-- ============================================
        TIMELINE - REDESIGNED
    ============================================ --}}
    <div class="timeline-wrapper">
        <div class="timeline-header-section">
            <div class="timeline-header-left">
                <div class="timeline-header-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#07573c" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <h4>Riwayat Status</h4>
            </div>
            <div class="timeline-header-right">
                <span class="timeline-count">{{ $permohonan->riwayatStatus->count() }} perubahan</span>
            </div>
        </div>

        <div class="timeline-modern">
            @foreach($permohonan->riwayatStatus as $index => $riwayat)
            @php
                $isFirst = $loop->first;
                $isLast = $loop->last;
                $warna = $riwayat->statusBaru->warna ?? '#6c757d';
            @endphp
            <div class="timeline-item-modern {{ $isFirst ? 'active' : '' }} {{ $isLast ? 'last' : '' }}">
                {{-- Garis penghubung --}}
                @if(!$isLast)
                <div class="timeline-line" style="border-left-color: {{ $warna }}40;"></div>
                @endif

                {{-- Dot --}}
                <div class="timeline-dot-modern" style="background: {{ $warna }};
                            box-shadow: 0 0 0 4px {{ $warna }}20, 0 0 0 8px {{ $warna }}10;">
                    @if($isFirst)
                    <div class="timeline-dot-pulse" style="background: {{ $warna }};"></div>
                    @endif
                </div>

                {{-- Content --}}
                <div class="timeline-content-modern">
                    <div class="timeline-card">
                        <div class="timeline-card-header">
                            <div class="timeline-status-modern" style="color: {{ $warna }}">
                                <span class="status-name">{{ $riwayat->statusBaru->nama_status }}</span>
                                @if($isFirst)
                                <span class="status-badge-current">● Status Saat Ini</span>
                                @endif
                            </div>
                            <div class="timeline-time-modern">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                                {{ $riwayat->changed_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }}
                            </div>
                        </div>

                        <div class="timeline-card-body">
                            <div class="timeline-user-modern">
                                <div class="user-avatar-small" style="background: {{ $warna }}20; color: {{ $warna }}">
                                    {{ Str::substr($riwayat->changedBy->name ?? 'S', 0, 2) }}
                                </div>
                                <span class="user-name">{{ $riwayat->changedBy->name ?? 'Sistem' }}</span>
                                @if($riwayat->statusLama)
                                <span class="status-change">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="17 8 12 3 7 8"/>
                                        <line x1="12" y1="3" x2="12" y2="15"/>
                                    </svg>
                                    dari <span style="color: {{ $riwayat->statusLama->warna ?? '#6c757d' }}">{{ $riwayat->statusLama->nama_status }}</span>
                                </span>
                                @endif
                            </div>
                            @if($riwayat->keterangan)
                            <div class="timeline-note-modern">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                </svg>
                                {{ $riwayat->keterangan }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Footer Timeline --}}
        <div class="timeline-footer">
            <div class="timeline-footer-item">
                <span class="dot-indicator" style="background: {{ $permohonan->statusPermohonan->warna ?? '#6c757d' }};"></span>
                <span>Status Saat Ini: <strong>{{ $permohonan->statusPermohonan->nama_status }}</strong></span>
            </div>
            <div class="timeline-footer-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
                <span>Terakhir diperbarui: <strong>{{ $permohonan->updated_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }}</strong></span>
            </div>
        </div>
    </div>

    {{-- Dokumen --}}
    @if($permohonan->dokumen->count() > 0)
    <div class="dokumen-wrapper">
        <div class="dokumen-header-section">
            <div class="dokumen-header-left">
                <div class="dokumen-header-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#07573c" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="17 8 12 3 7 8"/>
                        <line x1="12" y1="3" x2="12" y2="15"/>
                    </svg>
                </div>
                <h4>Dokumen Terupload</h4>
            </div>
            <div class="dokumen-header-right">
                <span class="dokumen-count">{{ $permohonan->dokumen->count() }} file</span>
            </div>
        </div>
        <div class="dokumen-grid-modern">
            @foreach($permohonan->dokumen as $dokumen)
            @php
                $ext = pathinfo($dokumen->file_name, PATHINFO_EXTENSION);
                $icon = match(strtolower($ext)) {
                    'pdf' => '📄',
                    'jpg', 'jpeg', 'png' => '🖼️',
                    'doc', 'docx' => '📝',
                    'xls', 'xlsx' => '📊',
                    default => '📎'
                };
                $bgColor = match(strtolower($ext)) {
                    'pdf' => '#fde8e8',
                    'jpg', 'jpeg', 'png' => '#dbeafe',
                    'doc', 'docx' => '#d1fae5',
                    'xls', 'xlsx' => '#fef3c7',
                    default => '#f3f4f6'
                };
            @endphp
            <a href="{{ $dokumen->file_url }}" target="_blank" class="dokumen-item-modern" style="--bg-color: {{ $bgColor }};">
                <div class="dokumen-icon-wrap" style="background: {{ $bgColor }};">
                    <span class="dokumen-icon-big">{{ $icon }}</span>
                </div>
                <div class="dokumen-info-wrap">
                    <div class="dokumen-name">{{ $dokumen->nama_dokumen }}</div>
                    <div class="dokumen-size">{{ $dokumen->file_size_formatted }}</div>
                </div>
                <div class="dokumen-action-wrap">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#07573c" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>