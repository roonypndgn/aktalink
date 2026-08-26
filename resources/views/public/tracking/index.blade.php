<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking Permohonan - AKTALINK</title>

    {{-- Google Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        /* ============================================
           ROOT VARIABLES
        ============================================ */
        :root {
            --primary: #07573c;
            --primary-dark: #043d2a;
            --primary-light: #0d8a5a;
            --primary-gradient: linear-gradient(135deg, #07573c, #0d8a5a);
            --primary-gradient-soft: linear-gradient(135deg, rgba(7,87,60,0.05), rgba(13,138,90,0.05));
            --accent: #f4b32a;
            --accent-gradient: linear-gradient(135deg, #f4b32a, #f59e0b);
            --body-bg: #f5f8f6;
            --white: #ffffff;
            --text: #1a2e28;
            --text-muted: #6c8a7e;
            --text-light: #94a8a0;
            --border: #e2e8e5;
            --shadow-sm: 0 2px 12px rgba(7, 87, 60, 0.06);
            --shadow-md: 0 8px 32px rgba(7, 87, 60, 0.10);
            --shadow-lg: 0 20px 60px rgba(7, 87, 60, 0.15);
            --shadow-xl: 0 30px 80px rgba(7, 87, 60, 0.20);
            --radius: 20px;
            --radius-sm: 12px;
            --transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Plus Jakarta Sans", sans-serif;
            background: var(--body-bg);
            min-height: 100vh;
            color: var(--text);
            line-height: 1.6;
            display: flex;
            flex-direction: column;
        }

        /* ============================================
           NAVBAR
        ============================================ */
        .navbar {
            background: var(--white);
            padding: 12px 0;
            border-bottom: 1px solid rgba(0,0,0,0.04);
            box-shadow: 0 1px 4px rgba(0,0,0,0.02);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .navbar-container {
            max-width: 1120px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text);
            text-decoration: none;
        }

        .navbar-brand .logo {
            width: 44px;
            height: 44px;
            object-fit: contain;
        }

        .navbar-brand .brand-text {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: 0.04em;
            color: var(--text);
        }

        .navbar-brand .brand-text span {
            color: var(--primary);
        }

        .navbar-brand .brand-sub {
            font-size: 9px;
            font-weight: 600;
            color: var(--text-muted);
            display: block;
            margin-top: -2px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-login-nav {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 24px;
            background: var(--white);
            color: var(--primary);
            border: 1.5px solid var(--primary);
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition);
            text-decoration: none;
            font-family: inherit;
        }

        .btn-login-nav:hover {
            background: var(--primary);
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(7, 87, 60, 0.2);
        }

        .btn-login-nav svg {
            width: 18px;
            height: 18px;
        }

        /* ============================================
           HERO SECTION
        ============================================ */
        .hero-section {
            background: var(--primary-gradient);
            padding: 60px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255,255,255,0.06) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255,255,255,0.04) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero-container {
            max-width: 1120px;
            margin: 0 auto;
            padding: 0 24px;
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .hero-left .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            background: rgba(255,255,255,0.12);
            border-radius: 20px;
            color: rgba(255,255,255,0.9);
            font-size: 12px;
            font-weight: 500;
            margin-bottom: 16px;
        }

        .hero-left .hero-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #34d399;
            animation: pulse-dot 2s ease-in-out infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(0.8); }
        }

        .hero-left h1 {
            font-size: 44px;
            font-weight: 800;
            color: white;
            line-height: 1.2;
            margin-bottom: 12px;
        }

        .hero-left h1 .highlight {
            color: var(--accent);
            position: relative;
        }

        .hero-left h1 .highlight::after {
            content: '';
            position: absolute;
            bottom: 4px;
            left: 0;
            right: 0;
            height: 6px;
            background: rgba(244, 179, 42, 0.3);
            border-radius: 4px;
        }

        .hero-left p {
            font-size: 18px;
            color: rgba(255,255,255,0.8);
            max-width: 480px;
            margin-bottom: 32px;
            line-height: 1.8;
        }

        .hero-stats {
            display: flex;
            gap: 40px;
        }

        .hero-stats .stat-item .stat-number {
            font-size: 28px;
            font-weight: 800;
            color: white;
        }

        .hero-stats .stat-item .stat-label {
            font-size: 13px;
            color: rgba(255,255,255,0.6);
        }

        .hero-right {
            display: flex;
            justify-content: center;
        }

        .hero-right .hero-illustration {
            width: 100%;
            max-width: 400px;
            height: auto;
            background: rgba(255,255,255,0.06);
            border-radius: 24px;
            padding: 40px;
            border: 1px solid rgba(255,255,255,0.08);
            backdrop-filter: blur(10px);
            text-align: center;
        }

        .hero-right .hero-illustration .illustration-icon {
            font-size: 80px;
            margin-bottom: 16px;
            display: block;
        }

        .hero-right .hero-illustration h3 {
            color: white;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .hero-right .hero-illustration p {
            color: rgba(255,255,255,0.6);
            font-size: 14px;
        }

        .hero-right .hero-illustration .illustration-features {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-top: 16px;
            text-align: left;
        }

        .hero-right .hero-illustration .illustration-features .feat {
            display: flex;
            align-items: center;
            gap: 8px;
            color: rgba(255,255,255,0.7);
            font-size: 13px;
        }

        .hero-right .hero-illustration .illustration-features .feat svg {
            color: var(--accent);
            flex-shrink: 0;
        }

        /* ============================================
           TRACKING SECTION
        ============================================ */
        .tracking-section {
            padding: 60px 0 80px;
            background: var(--body-bg);
        }

        .tracking-container {
            max-width: 1120px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .tracking-section-header {
            text-align: center;
            margin-bottom: 48px;
        }

        .tracking-section-header .section-badge {
            display: inline-block;
            padding: 4px 16px;
            background: #d1fae5;
            color: #065f46;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .tracking-section-header h2 {
            font-size: 32px;
            font-weight: 800;
            color: var(--text);
        }

        .tracking-section-header h2 span {
            color: var(--primary);
        }

        .tracking-section-header p {
            color: var(--text-muted);
            font-size: 16px;
            max-width: 480px;
            margin: 4px auto 0;
        }

        /* ============================================
           SEARCH BOX - ENHANCED
        ============================================ */
        .search-box-wrapper {
            max-width: 640px;
            margin: 0 auto;
            background: var(--white);
            border-radius: var(--radius);
            padding: 40px 48px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border);
            position: relative;
            overflow: hidden;
        }

        .search-box-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
        }

        .search-box-wrapper .search-icon-big {
            text-align: center;
            margin-bottom: 20px;
        }

        .search-box-wrapper .search-icon-big span {
            display: inline-block;
            font-size: 48px;
            background: var(--primary-gradient-soft);
            padding: 16px;
            border-radius: 50%;
        }

        .search-box-wrapper h3 {
            text-align: center;
            font-size: 20px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 4px;
        }

        .search-box-wrapper .sub {
            text-align: center;
            font-size: 14px;
            color: var(--text-muted);
            margin-bottom: 24px;
        }

        .search-form {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .search-form .input-group {
            position: relative;
        }

        .search-form .input-group .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #b0c4bc;
            pointer-events: none;
            transition: color var(--transition);
        }

        .search-form .input-group input {
            width: 100%;
            padding: 16px 18px 16px 50px;
            border: 2px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 15px;
            font-weight: 500;
            color: var(--text);
            background: #fafcfb;
            transition: all var(--transition);
            font-family: inherit;
        }

        .search-form .input-group input:focus {
            outline: none;
            border-color: var(--primary);
            background: var(--white);
            box-shadow: 0 0 0 4px rgba(7, 87, 60, 0.08);
        }

        .search-form .input-group input:focus ~ .input-icon {
            color: var(--primary);
        }

        .search-form .input-group input::placeholder {
            color: #b0c4bc;
            font-weight: 400;
        }

        .search-form .input-hint {
            font-size: 12px;
            color: var(--text-light);
            text-align: left;
            padding-left: 4px;
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .search-form .input-hint strong {
            color: var(--primary);
            font-weight: 700;
        }

        .search-form .input-hint .hint-badge {
            display: inline-block;
            padding: 1px 10px;
            background: #d1fae5;
            color: #065f46;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
        }

        .btn-search-hero {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 16px 32px;
            background: var(--primary-gradient);
            color: white;
            border: none;
            border-radius: var(--radius-sm);
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all var(--transition);
            font-family: inherit;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .btn-search-hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, transparent, rgba(255,255,255,0.1));
            opacity: 0;
            transition: opacity var(--transition);
        }

        .btn-search-hero:hover::after {
            opacity: 1;
        }

        .btn-search-hero:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(7, 87, 60, 0.35);
        }

        .btn-search-hero:active {
            transform: translateY(0);
        }

        .btn-search-hero:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        /* ============================================
           ERROR MESSAGE
        ============================================ */
        .error-message {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 14px 18px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 13px;
            margin-top: 16px;
            animation: shake 0.4s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-8px); }
            75% { transform: translateX(8px); }
        }

        .error-message svg {
            flex-shrink: 0;
            margin-top: 1px;
        }

        /* ============================================
           RESULT SECTION
        ============================================ */
        .result-section {
            margin-top: 32px;
            animation: fadeSlideUp 0.5s ease;
        }

        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .result-section .result-divider {
            border: none;
            border-top: 2px dashed var(--border);
            margin: 0 0 20px;
        }

        .result-section .result-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .result-section .result-header .icon-wrap {
            width: 40px;
            height: 40px;
            background: var(--primary-gradient-soft);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .result-section .result-header h3 {
            font-size: 16px;
            font-weight: 700;
            color: var(--text);
        }

        .result-section .result-header h3 span {
            color: var(--primary);
        }

        .result-section .result-header .count {
            font-size: 12px;
            color: var(--text-muted);
            font-weight: 500;
            background: #f0f5f2;
            padding: 2px 12px;
            border-radius: 20px;
        }

        /* Pemohon Info */
        .pemohon-info-mini {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 16px 20px;
            background: linear-gradient(135deg, #f8faf9, #f0f4f2);
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            margin-bottom: 16px;
            transition: all var(--transition);
        }

        .pemohon-info-mini:hover {
            border-color: var(--primary);
            box-shadow: var(--shadow-sm);
        }

        .pemohon-info-mini .avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--primary-gradient);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .pemohon-info-mini .info .name {
            font-weight: 700;
            font-size: 15px;
            color: var(--text);
        }

        .pemohon-info-mini .info .nik {
            font-size: 12px;
            color: var(--text-muted);
        }

        .pemohon-info-mini .badge-count {
            margin-left: auto;
            padding: 4px 14px;
            background: var(--primary-gradient);
            color: white;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        /* List Permohonan */
        .permohonan-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .permohonan-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 18px;
            background: #fafcfb;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            cursor: pointer;
            transition: all var(--transition);
            gap: 12px;
            flex-wrap: wrap;
            position: relative;
        }

        .permohonan-item::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: var(--radius-sm);
            border: 2px solid transparent;
            transition: border-color var(--transition);
            pointer-events: none;
        }

        .permohonan-item:hover {
            border-color: var(--primary);
            background: var(--white);
            transform: translateX(4px);
            box-shadow: 0 4px 20px rgba(7, 87, 60, 0.08);
        }

        .permohonan-item:hover::after {
            border-color: var(--primary);
        }

        .permohonan-item .left {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .permohonan-item .left .number {
            font-weight: 700;
            color: var(--primary);
            font-size: 13px;
            white-space: nowrap;
            font-family: monospace;
            letter-spacing: 0.5px;
        }

        .permohonan-item .left .layanan {
            font-size: 12px;
            color: var(--text-muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 140px;
        }

        .permohonan-item .right {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .permohonan-item .right .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .permohonan-item .right .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
            animation: pulse-dot 2s ease-in-out infinite;
        }

        .permohonan-item .right .date {
            font-size: 11px;
            color: var(--text-light);
            font-weight: 500;
        }

        .permohonan-item .right .arrow {
            color: #b0c4bc;
            transition: all var(--transition);
            font-size: 14px;
            display: flex;
            align-items: center;
        }

        .permohonan-item:hover .right .arrow {
            color: var(--primary);
            transform: translateX(4px);
        }

        /* ============================================
           MODAL
        ============================================ */
        .modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 1000;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(12px);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-container {
            width: 100%;
            max-width: 580px;
            max-height: 90vh;
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow-xl);
            overflow: hidden;
            animation: modalIn 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes modalIn {
            from {
                opacity: 0;
                transform: scale(0.92) translateY(30px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .modal-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 18px 24px;
            border-bottom: 1px solid var(--border);
            background: #fafcfb;
        }

        .modal-header .icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            flex-shrink: 0;
            font-size: 18px;
        }

        .modal-header .title {
            flex: 1;
            font-size: 16px;
            font-weight: 700;
            color: var(--text);
        }

        .modal-header .close-btn {
            width: 38px;
            height: 38px;
            border: none;
            border-radius: 50%;
            background: transparent;
            color: #8a9a94;
            cursor: pointer;
            transition: all var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-header .close-btn:hover {
            background: #f0f5f2;
            color: var(--text);
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 24px;
            overflow-y: auto;
            max-height: calc(90vh - 80px);
        }

        .modal-body .loading {
            text-align: center;
            padding: 32px 20px;
        }

        .modal-body .loading .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f0f2f1;
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin: 0 auto 12px;
        }

        .modal-body .loading p {
            color: var(--text-muted);
            font-size: 13px;
        }

        /* Modal Content */
        .modal-status-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 18px;
            border-radius: var(--radius-sm);
            background: #f8faf9;
            margin-bottom: 18px;
            border-left: 4px solid var(--primary);
            flex-wrap: wrap;
            gap: 8px;
        }

        .modal-status-bar .left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .modal-status-bar .left .label {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .modal-status-bar .left .status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 15px;
            font-weight: 700;
        }

        .modal-status-bar .left .status .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            animation: pulse-dot 2s ease-in-out infinite;
        }

        .modal-status-bar .right {
            font-size: 12px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .modal-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 18px;
        }

        .modal-card-mini {
            background: #fafcfb;
            border-radius: var(--radius-sm);
            padding: 14px 16px;
            border: 1px solid var(--border);
            transition: all var(--transition);
        }

        .modal-card-mini:hover {
            border-color: var(--primary);
        }

        .modal-card-mini .card-title {
            font-size: 10px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 8px;
            padding-bottom: 6px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .modal-card-mini .row {
            display: flex;
            justify-content: space-between;
            padding: 3px 0;
            font-size: 13px;
        }

        .modal-card-mini .row .label {
            color: var(--text-muted);
            font-weight: 500;
        }

        .modal-card-mini .row .value {
            font-weight: 600;
            text-align: right;
            color: var(--text);
        }

        .modal-timeline-mini {
            background: #fafcfb;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .modal-timeline-mini .tl-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            background: var(--white);
            border-bottom: 1px solid var(--border);
        }

        .modal-timeline-mini .tl-header .tl-title {
            font-size: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--text);
        }

        .modal-timeline-mini .tl-header .tl-count {
            font-size: 10px;
            color: var(--text-muted);
            background: #f0f5f2;
            padding: 2px 10px;
            border-radius: 12px;
            font-weight: 600;
        }

        .modal-timeline-mini .tl-list {
            padding: 12px 16px;
            max-height: 220px;
            overflow-y: auto;
        }

        .modal-timeline-mini .tl-list::-webkit-scrollbar {
            width: 4px;
        }

        .modal-timeline-mini .tl-list::-webkit-scrollbar-thumb {
            background: #dce2e0;
            border-radius: 4px;
        }

        .modal-timeline-mini .tl-item {
            position: relative;
            padding-left: 28px;
            padding-bottom: 12px;
        }

        .modal-timeline-mini .tl-item:last-child {
            padding-bottom: 0;
        }

        .modal-timeline-mini .tl-item .dot {
            position: absolute;
            left: 2px;
            top: 4px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            border: 2px solid var(--white);
            box-shadow: 0 0 0 2px var(--border);
        }

        .modal-timeline-mini .tl-item .dot.active {
            box-shadow: 0 0 0 4px rgba(7, 87, 60, 0.15);
        }

        .modal-timeline-mini .tl-item .line {
            position: absolute;
            left: 6px;
            top: 16px;
            bottom: 0;
            width: 2px;
            background: var(--border);
        }

        .modal-timeline-mini .tl-item .content .status {
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .modal-timeline-mini .tl-item .content .status .badge {
            font-size: 9px;
            font-weight: 600;
            color: #059669;
            background: #d1fae5;
            padding: 1px 10px;
            border-radius: 12px;
        }

        .modal-timeline-mini .tl-item .content .meta {
            font-size: 11px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 2px;
        }

        .modal-timeline-mini .tl-item .content .note {
            margin-top: 4px;
            padding: 6px 10px;
            background: var(--white);
            border-radius: 6px;
            font-size: 12px;
            color: var(--text-muted);
            border: 1px solid var(--border);
        }

        /* ============================================
           FOOTER
        ============================================ */
        .footer {
            background: var(--white);
            border-top: 1px solid var(--border);
            padding: 20px 0;
            margin-top: auto;
        }

        .footer-container {
            max-width: 1120px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .footer-container p {
            font-size: 13px;
            color: var(--text-light);
        }

        .footer-container .footer-links {
            display: flex;
            gap: 20px;
        }

        .footer-container .footer-links a {
            color: var(--text-light);
            text-decoration: none;
            font-size: 13px;
            transition: color var(--transition);
        }

        .footer-container .footer-links a:hover {
            color: var(--primary);
        }

        /* ============================================
           RESPONSIVE
        ============================================ */
        @media (max-width: 968px) {
            .hero-container {
                grid-template-columns: 1fr;
                gap: 40px;
                text-align: center;
            }

            .hero-left h1 {
                font-size: 36px;
            }

            .hero-left p {
                margin: 0 auto 24px;
            }

            .hero-stats {
                justify-content: center;
            }

            .hero-right .hero-illustration {
                max-width: 100%;
            }

            .search-box-wrapper {
                padding: 32px 24px;
            }
        }

        @media (max-width: 640px) {
            .hero-section {
                padding: 40px 0 60px;
            }

            .hero-left h1 {
                font-size: 28px;
            }

            .hero-left p {
                font-size: 16px;
            }

            .hero-stats {
                gap: 24px;
                flex-wrap: wrap;
                justify-content: center;
            }

            .hero-stats .stat-item .stat-number {
                font-size: 22px;
            }

            .navbar-container {
                flex-direction: column;
                gap: 12px;
                text-align: center;
            }

            .navbar-actions {
                width: 100%;
                justify-content: center;
            }

            .btn-login-nav {
                width: 100%;
                justify-content: center;
            }

            .search-box-wrapper {
                padding: 24px 16px;
            }

            .search-box-wrapper h3 {
                font-size: 18px;
            }

            .modal-grid-2 {
                grid-template-columns: 1fr;
            }

            .modal-container {
                margin: 10px;
                max-height: 95vh;
                border-radius: 16px;
            }

            .permohonan-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .permohonan-item .right {
                width: 100%;
                justify-content: space-between;
            }

            .pemohon-info-mini {
                flex-wrap: wrap;
                padding: 14px 16px;
            }

            .pemohon-info-mini .badge-count {
                margin-left: 0;
            }

            .footer-container {
                flex-direction: column;
                text-align: center;
            }

            .modal-status-bar {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media (max-width: 400px) {
            .hero-left h1 {
                font-size: 24px;
            }

            .search-form .input-group input {
                font-size: 14px;
                padding: 14px 14px 14px 44px;
            }

            .btn-search-hero {
                font-size: 14px;
                padding: 14px 20px;
            }

            .modal-body {
                padding: 16px;
            }

            .modal-card-mini {
                padding: 10px 12px;
            }
        }
    </style>
</head>

<body>

    {{-- ============================================
        NAVBAR
    ============================================ --}}
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ url('/tracking') }}" class="navbar-brand">
                <img src="{{ asset('images/aktalink-logo.png') }}" alt="AKTALINK" class="logo">
                <div>
                    <div class="brand-text">AKTA<span>LINK</span></div>
                    <span class="brand-sub">DISDUKCAPIL KOTA MEDAN</span>
                </div>
            </a>
            <div class="navbar-actions">
                <a href="{{ route('login') }}" class="btn-login-nav">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                        <polyline points="10 17 15 12 10 7"/>
                        <line x1="15" y1="12" x2="3" y2="12"/>
                    </svg>
                    Login Petugas
                </a>
            </div>
        </div>
    </nav>

    {{-- ============================================
        HERO SECTION
    ============================================ --}}
    <section class="hero-section">
        <div class="hero-container">
            <div class="hero-left">
                <div class="hero-badge">
                    <span class="dot"></span>
                    Layanan Tracking 24 Jam
                </div>
                <h1>
                    Lacak <span class="highlight">Permohonan</span><br>
                    Anda dengan Mudah
                </h1>
                <p>
                    Cek status permohonan Anda secara real-time hanya dengan memasukkan
                    NIK yang terdaftar. Proses cepat, transparan, dan terpercaya.
                </p>
                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Permohonan Diproses</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">98%</div>
                        <div class="stat-label">Tingkat Kepuasan</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Layanan Aktif</div>
                    </div>
                </div>
            </div>
            <div class="hero-right">
                <div class="hero-illustration">
                    <span class="illustration-icon"></span>
                    <h3>Tracking Permohonan</h3>
                    <p>Status terkini permohonan Anda</p>
                    <div class="illustration-features">
                        <div class="feat">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            Update status real-time
                        </div>
                        <div class="feat">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            Riwayat status lengkap
                        </div>
                        <div class="feat">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            Aman dan terpercaya
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================
        TRACKING SECTION
    ============================================ --}}
    <section class="tracking-section">
        <div class="tracking-container">

            <div class="tracking-section-header">
                <span class="section-badge">🔍 Cek Sekarang</span>
                <h2>Lacak <span>Permohonan</span> Anda</h2>
                <p>Masukkan NIK Anda untuk melihat status permohonan secara real-time</p>
            </div>

            <div class="search-box-wrapper">
                <div class="search-icon-big">
                    <span>🔍</span>
                </div>
                <h3>Cari Permohonan</h3>
                <p class="sub">Masukkan NIK untuk melihat status terbaru permohonan Anda</p>

                <form method="GET" action="{{ url('/tracking') }}" class="search-form" id="trackingForm">
                    <div class="input-group">
                        <span class="input-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"/>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                            </svg>
                        </span>
                        <input
                            type="text"
                            id="searchValue"
                            name="search_value"
                            placeholder="Masukkan 16 digit NIK"
                            value="{{ old('search_value', $searchValue ?? '') }}"
                            maxlength="16"
                            required
                            pattern="[0-9]{16}"
                            title="Masukkan 16 digit NIK"
                            autofocus
                        >
                    </div>
                    <div class="input-hint">
                        💡 Masukkan <strong>16 digit NIK</strong> yang terdaftar pada permohonan Anda
                        <span class="hint-badge">Contoh: 1201010203010001</span>
                    </div>
                    <button type="submit" class="btn-search-hero" id="btnSearch">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        Lacak Sekarang
                    </button>
                </form>

                {{-- ERROR --}}
                @if(isset($error) && $error)
                <div class="error-message">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <div>
                        <strong>Data tidak ditemukan</strong><br>
                        {{ $error }}
                    </div>
                </div>
                @endif

                {{-- RESULT --}}
                @if(isset($result) && $result)
                <div class="result-section">
                    <hr class="result-divider">

                    <div class="result-header">
                        <h3>Data <span>{{ $result['pemohon']->nama_lengkap }}</span></h3>
                        <span class="count">{{ $result['permohonans']->count() }} permohonan</span>
                    </div>

                    {{-- Pemohon Info --}}
                    <div class="pemohon-info-mini">
                        <div class="avatar">{{ Str::substr($result['pemohon']->nama_lengkap, 0, 2) }}</div>
                        <div class="info">
                            <div class="name">{{ $result['pemohon']->nama_lengkap }}</div>
                            <div class="nik">NIK: {{ $result['pemohon']->nik }}</div>
                        </div>
                        <span class="badge-count">{{ $result['permohonans']->count() }}</span>
                    </div>

                    {{-- List Permohonan --}}
                    <div class="permohonan-list">
                        @foreach($result['permohonans'] as $permohonan)
                        <div class="permohonan-item" onclick="showPublicDetail({{ $permohonan->id }}, '{{ $result['pemohon']->nik }}')">
                            <div class="left">
                                <span class="number">{{ $permohonan->nomor_permohonan }}</span>
                                <span class="layanan">{{ $permohonan->jenisLayanan->nama_layanan }}</span>
                            </div>
                            <div class="right">
                                <span class="status-badge" style="background: {{ $permohonan->statusPermohonan->warna ?? '#6c757d' }}20; color: {{ $permohonan->statusPermohonan->warna ?? '#6c757d' }}">
                                    <span class="status-dot" style="background: {{ $permohonan->statusPermohonan->warna ?? '#6c757d' }}"></span>
                                    {{ $permohonan->statusPermohonan->nama_status }}
                                </span>
                                <span class="date">{{ $permohonan->created_at->setTimezone('Asia/Jakarta')->format('d M Y') }}</span>
                                <span class="arrow">→</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

        </div>
    </section>

    {{-- ============================================
        MODAL
    ============================================ --}}
    <div class="modal-overlay" id="publicModal">
        <div class="modal-container">
            <div class="modal-header">
                <div class="icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                </div>
                <span class="title">Detail Permohonan</span>
                <button class="close-btn" onclick="closePublicModal()">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body" id="publicModalBody">
                <div class="loading">
                    <div class="spinner"></div>
                    <p>Memuat data...</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================
        FOOTER
    ============================================ --}}
    <footer class="footer">
        <div class="footer-container">
            <p>&copy; {{ date('Y') }} AKTALINK - DISDUKCAPIL Kota Medan</p>
            <div class="footer-links">
                <a href="{{ url('/tracking') }}">Tracking</a>
                <a href="#">Kebijakan Privasi</a>
                <a href="#">Kontak</a>
            </div>
        </div>
    </footer>

    {{-- ============================================
        SCRIPTS
    ============================================ --}}
    <script>
        // ============================================
        // INIT LUCIDE ICONS
        // ============================================
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            // Auto focus input jika ada nilai
            const searchInput = document.getElementById('searchValue');
            if (searchInput && searchInput.value) {
                searchInput.focus();
                searchInput.setSelectionRange(searchInput.value.length, searchInput.value.length);
            }
        });

        // ============================================
        // VALIDASI INPUT
        // ============================================
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchValue');

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    this.value = this.value.replace(/\D/g, '');
                });

                searchInput.addEventListener('blur', function() {
                    this.value = this.value.trim();
                });
            }
        });

        // ============================================
        // MODAL FUNCTIONS
        // ============================================
        function openPublicModal() {
            document.getElementById('publicModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closePublicModal() {
            document.getElementById('publicModal').classList.remove('active');
            document.body.style.overflow = '';
        }

        document.getElementById('publicModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePublicModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePublicModal();
            }
        });

        // ============================================
        // SHOW DETAIL
        // ============================================
        function showPublicDetail(id, nik) {
            const body = document.getElementById('publicModalBody');

            body.innerHTML = `
                <div class="loading">
                    <div class="spinner"></div>
                    <p>Memuat data...</p>
                </div>
            `;

            openPublicModal();

            fetch(`{{ url('/tracking/detail') }}?id=${id}&nik=${nik}`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const d = data.data;
                    const p = d.permohonan;
                    const timeline = d.timeline;

                    let html = `
                        <div class="modal-status-bar" style="border-left-color: ${p.status_permohonan.warna};">
                            <div class="left">
                                <span class="label">Status</span>
                                <span class="status" style="color: ${p.status_permohonan.warna};">
                                    <span class="dot" style="background: ${p.status_permohonan.warna};"></span>
                                    ${p.status_permohonan.nama_status}
                                </span>
                            </div>
                            <div class="right">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                                ${new Date(p.updated_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })}
                            </div>
                        </div>

                        <div class="modal-grid-2">
                            <div class="modal-card-mini">
                                <div class="card-title">Permohonan</div>
                                <div class="row"><span class="label">Nomor</span><span class="value"><strong>${p.nomor_permohonan}</strong></span></div>
                                <div class="row"><span class="label">Layanan</span><span class="value">${p.jenis_layanan.nama_layanan}</span></div>
                                <div class="row"><span class="label">Tanggal</span><span class="value">${new Date(p.tanggal_permohonan).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })}</span></div>
                            </div>
                            <div class="modal-card-mini">
                                <div class="card-title">Pemohon</div>
                                <div class="row"><span class="label">Nama</span><span class="value"><strong>${p.pemohon.nama_lengkap}</strong></span></div>
                                <div class="row"><span class="label">NIK</span><span class="value">${p.pemohon.nik}</span></div>
                                <div class="row"><span class="label">Telepon</span><span class="value">${p.pemohon.no_telepon || '-'}</span></div>
                            </div>
                        </div>

                        <div class="modal-timeline-mini">
                            <div class="tl-header">
                                <span class="tl-title">Riwayat Status</span>
                                <span class="tl-count">${timeline.length}</span>
                            </div>
                            <div class="tl-list">
                    `;

                    timeline.forEach((item, index) => {
                        const isFirst = index === 0;
                        html += `
                            <div class="tl-item">
                                <div class="dot ${isFirst ? 'active' : ''}" style="background: ${item.warna}; ${isFirst ? `box-shadow: 0 0 0 4px ${item.warna}20;` : ''}"></div>
                                ${!isFirst ? `<div class="line"></div>` : ''}
                                <div class="content">
                                    <div class="status" style="color: ${item.warna}">
                                        ${item.status}
                                        ${isFirst ? '<span class="badge">● Saat Ini</span>' : ''}
                                    </div>
                                    <div class="meta">
                                        <span>${item.changed_by}</span>
                                        <span>•</span>
                                        <span>${item.changed_at}</span>
                                    </div>
                                    ${item.keterangan ? `<div class="note">${item.keterangan}</div>` : ''}
                                </div>
                            </div>
                        `;
                    });

                    html += `
                            </div>
                        </div>
                    `;

                    body.innerHTML = html;
                } else {
                    body.innerHTML = `
                        <div class="empty-state">
                            <div class="icon">⚠️</div>
                            <h4>Data Tidak Ditemukan</h4>
                            <p>${data.message || 'Permohonan tidak ditemukan'}</p>
                        </div>
                    `;
                }
            })
            .catch(err => {
                console.error(err);
                body.innerHTML = `
                    <div class="empty-state">
                        <div class="icon">⚠️</div>
                        <h4>Terjadi Kesalahan</h4>
                        <p>Gagal memuat data. Silakan coba lagi.</p>
                    </div>
                `;
            });
        }

        console.log('✅ Public Tracking loaded successfully');
    </script>

</body>
</html>