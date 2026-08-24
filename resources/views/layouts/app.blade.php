<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'AKTALINK')
    </title>

    {{-- Google Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>


    <style>
        /* =========================================================
           ROOT
        ========================================================= */

        :root {
            --sidebar-width: 270px;
            --sidebar-collapse-width: 82px;
            --header-height: 76px;

            --primary: #07573c;
            --primary-dark: #043d2a;
            --primary-deep: #032f22;
            --primary-light: #0d7a52;

            --accent: #f4b32a;
            --accent-light: #ffd56d;

            --body-bg: #f5f7f6;
            --white: #ffffff;

            --text: #1d2b27;
            --text-muted: #788580;
            --border: #e2e8e5;

            --sidebar-text: rgba(255, 255, 255, 0.75);
            --sidebar-muted: rgba(255, 255, 255, 0.45);

            --shadow-sm:
                0 4px 15px rgba(8, 35, 26, 0.05);

            --shadow-md:
                0 10px 30px rgba(8, 35, 26, 0.08);

            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 22px;

            --transition:
                0.25s cubic-bezier(0.4,
                    0,
                    0.2,
                    1);
        }


        /* =========================================================
           RESET
        ========================================================= */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        html {
            scroll-behavior: smooth;
        }


        body {
            min-height: 100vh;

            font-family:
                "Plus Jakarta Sans",
                sans-serif;

            color: var(--text);

            background:
                var(--body-bg);

            -webkit-font-smoothing:
                antialiased;
        }


        body.sidebar-open {
            overflow: hidden;
        }


        button,
        input {
            font-family: inherit;
        }


        button {
            border: none;
        }


        a {
            text-decoration: none;
            color: inherit;
        }


        /* =========================================================
           APP
        ========================================================= */

        .app {
            min-height: 100vh;
        }


        /* =========================================================
           SIDEBAR
        ========================================================= */

        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;

            position: fixed;
            z-index: 100;

            top: 0;
            left: 0;

            display: flex;
            flex-direction: column;

            overflow-x: hidden;
            overflow-y: auto;

            background:
                radial-gradient(circle at 0% 100%,
                    rgba(18, 115, 75, 0.5),
                    transparent 30%),
                linear-gradient(180deg,
                    var(--primary-deep),
                    var(--primary-dark));

            transition:
                width var(--transition),
                transform var(--transition);

            box-shadow:
                10px 0 35px rgba(0, 0, 0, 0.05);
        }


        /* =========================================================
           SIDEBAR DECORATION
        ========================================================= */

        .sidebar-decoration {
            position: absolute;

            pointer-events: none;

            opacity: 0.7;
        }


        .sidebar-decoration.top {
            width: 230px;
            height: 230px;

            top: -120px;
            left: -110px;

            border-radius: 50%;

            border:
                1px solid rgba(255, 255, 255, 0.08);

            box-shadow:
                0 0 0 30px rgba(255, 255, 255, 0.025),
                0 0 0 60px rgba(255, 255, 255, 0.018),
                0 0 0 90px rgba(255, 255, 255, 0.012);
        }


        .sidebar-decoration.bottom {
            width: 250px;
            height: 250px;

            bottom: -150px;
            right: -150px;

            border-radius: 50%;

            border:
                1px solid rgba(244, 179, 42, 0.12);
        }


        /* =========================================================
           SIDEBAR HEADER
        ========================================================= */

        .sidebar-header {
            min-height: 112px;

            position: relative;
            z-index: 2;

            display: flex;
            align-items: center;

            padding:
                25px 24px;

            border-bottom:
                1px solid rgba(255, 255, 255, 0.07);
        }


        .brand {
            width: 100%;

            display: flex;
            align-items: center;

            gap: 14px;

            overflow: hidden;
        }


        .brand-logo {
            width: 46px;
            height: 46px;

            object-fit: contain;

            flex-shrink: 0;
        }


        .brand-text {
            min-width: 0;

            transition:
                opacity var(--transition),
                transform var(--transition);
        }


        .brand-name {
            color: white;

            font-size: 1.2rem;

            font-weight: 800;

            letter-spacing: 0.08em;
        }


        .brand-name span {
            color: var(--accent);
        }


        .brand-subtitle {
            margin-top: 3px;

            color:
                rgba(255, 255, 255, 0.45);

            font-size: 0.58rem;

            font-weight: 600;

            letter-spacing: 0.14em;

            white-space: nowrap;
        }


        /* =========================================================
           NAVIGATION
        ========================================================= */

        .sidebar-content {
            position: relative;
            z-index: 2;

            flex: 1;

            padding:
                26px 14px;
        }


        .nav-section {
            margin-bottom: 30px;
        }


        .nav-section-title {
            display: block;

            margin:
                0 14px 11px;

            color:
                var(--sidebar-muted);

            font-size: 0.63rem;

            font-weight: 700;

            letter-spacing: 0.12em;

            text-transform: uppercase;

            white-space: nowrap;

            transition:
                opacity var(--transition);
        }


        .nav-list {
            list-style: none;
        }


        .nav-item {
            margin-bottom: 5px;
        }


        .nav-link {
            width: 100%;
            min-height: 50px;

            position: relative;

            display: flex;
            align-items: center;

            gap: 14px;

            padding:
                0 14px;

            border-radius: 12px;

            color:
                var(--sidebar-text);

            font-size: 0.88rem;

            font-weight: 500;

            white-space: nowrap;

            transition:
                background var(--transition),
                color var(--transition);
        }


        .nav-link:hover {
            color: white;

            background:
                rgba(255, 255, 255, 0.07);
        }


        .nav-link.active {
            color:
                var(--primary-dark);

            font-weight: 700;

            background:
                rgba(255, 255, 255, 0.96);

            box-shadow:
                0 8px 25px rgba(0, 0, 0, 0.12);
        }


        .nav-icon {
            width: 21px;
            height: 21px;

            flex-shrink: 0;
        }


        .nav-text {
            overflow: hidden;
            text-overflow: ellipsis;

            transition:
                opacity var(--transition);
        }


        .nav-arrow {
            width: 16px;
            height: 16px;

            margin-left: auto;

            transition:
                opacity var(--transition);
        }


        /* =========================================================
           SIDEBAR FOOTER
        ========================================================= */

        .sidebar-footer {
            position: relative;
            z-index: 2;

            padding:
                14px;

            border-top:
                1px solid rgba(255, 255, 255, 0.07);
        }


        .user-mini {
            width: 100%;

            display: flex;
            align-items: center;

            gap: 12px;

            padding: 10px;

            border-radius: 14px;

            color: white;

            cursor: pointer;

            background:
                rgba(255, 255, 255, 0.055);

            transition:
                background var(--transition);
        }


        .user-mini:hover {
            background:
                rgba(255, 255, 255, 0.1);
        }


        .user-avatar {
            width: 42px;
            height: 42px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            border-radius: 50%;

            color:
                var(--primary-dark);

            background:
                linear-gradient(135deg,
                    #ffffff,
                    #dfe9e4);
        }


        .user-avatar svg {
            width: 22px;
            height: 22px;
        }


        .user-mini-info {
            min-width: 0;

            flex: 1;

            transition:
                opacity var(--transition);
        }


        .user-mini-name {
            overflow: hidden;

            text-overflow: ellipsis;

            color:
                rgba(255, 255, 255, 0.92);

            font-size: 0.82rem;

            font-weight: 700;

            white-space: nowrap;
        }


        .user-mini-role {
            margin-top: 3px;

            color:
                rgba(255, 255, 255, 0.46);

            font-size: 0.68rem;

            white-space: nowrap;
        }


        /* =========================================================
           MAIN WRAPPER
        ========================================================= */

        .main-wrapper {
            min-height: 100vh;

            margin-left:
                var(--sidebar-width);

            transition:
                margin-left var(--transition);
        }


        /* =========================================================
           HEADER
        ========================================================= */

        .topbar {
            width: calc(100% - var(--sidebar-width));

            height:
                var(--header-height);

            position: fixed;

            z-index: 90;

            top: 0;
            right: 0;

            display: flex;
            align-items: center;

            padding:
                0 clamp(20px, 3vw, 40px);

            background:
                rgba(255, 255, 255, 0.90);

            backdrop-filter:
                blur(16px);

            border-bottom:
                1px solid rgba(220, 228, 224, 0.85);

            transition:
                width var(--transition);
        }


        .topbar-left {
            display: flex;
            align-items: center;

            gap: 16px;

            flex: 1;

            min-width: 0;
        }


        .sidebar-toggle {
            width: 44px;
            height: 44px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            border-radius: 12px;

            cursor: pointer;

            color:
                #385047;

            background:
                transparent;

            transition:
                background var(--transition);
        }


        .sidebar-toggle:hover {
            background:
                #edf3ef;
        }


        .sidebar-toggle svg {
            width: 24px;
            height: 24px;
        }


        .breadcrumb {
            min-width: 0;
        }


        .breadcrumb-title {
            overflow: hidden;

            text-overflow: ellipsis;

            color:
                var(--text);

            font-size: 1rem;

            font-weight: 700;

            white-space: nowrap;
        }


        .breadcrumb-text {
            margin-top: 3px;

            overflow: hidden;

            text-overflow: ellipsis;

            color:
                var(--text-muted);

            font-size: 0.72rem;

            white-space: nowrap;
        }


        /* =========================================================
           TOPBAR RIGHT
        ========================================================= */

        .topbar-right {
            display: flex;
            align-items: center;

            gap: 10px;

            margin-left: 20px;
        }


        .topbar-button {
            width: 42px;
            height: 42px;

            position: relative;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            border-radius: 12px;

            cursor: pointer;

            color:
                #4f615a;

            background:
                transparent;

            transition:
                background var(--transition),
                color var(--transition);
        }


        .topbar-button:hover {
            color:
                var(--primary);

            background:
                #edf4f0;
        }


        .topbar-button svg {
            width: 21px;
            height: 21px;
        }


        .notification-badge {
            width: 17px;
            height: 17px;

            position: absolute;

            top: 5px;
            right: 5px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            color: white;

            background:
                var(--primary);

            border:
                2px solid white;

            font-size: 0.55rem;

            font-weight: 700;
        }


        .profile-wrapper {
            position: relative;
        }


        .profile-button {
            min-height: 46px;

            display: flex;
            align-items: center;

            gap: 10px;

            padding:
                4px 8px 4px 5px;

            border-radius: 14px;

            cursor: pointer;

            color:
                var(--text);

            background:
                transparent;

            transition:
                background var(--transition);
        }


        .profile-button:hover {
            background:
                #f0f5f2;
        }


        .profile-avatar {
            width: 37px;
            height: 37px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            border-radius: 50%;

            color:
                var(--primary-dark);

            background:
                linear-gradient(135deg,
                    #e6f1eb,
                    #c7ddcf);
        }


        .profile-avatar svg {
            width: 20px;
            height: 20px;
        }


        .profile-info {
            text-align: left;
        }


        .profile-name {
            color:
                var(--text);

            font-size: 0.75rem;

            font-weight: 700;
        }


        .profile-role {
            margin-top: 2px;

            color:
                var(--text-muted);

            font-size: 0.63rem;
        }


        .profile-chevron {
            width: 16px;
            height: 16px;

            color:
                #8a9691;

            transition:
                transform var(--transition);
        }


        /* =========================================================
           PROFILE DROPDOWN
        ========================================================= */

        .profile-menu {
            width: 230px;

            position: absolute;

            z-index: 120;

            top: calc(100% + 10px);
            right: 0;

            padding: 8px;

            visibility: hidden;

            opacity: 0;

            transform:
                translateY(-8px);

            border:
                1px solid var(--border);

            border-radius:
                16px;

            background:
                white;

            box-shadow:
                var(--shadow-md);

            transition:
                opacity var(--transition),
                transform var(--transition),
                visibility var(--transition);
        }


        .profile-menu.show {
            visibility: visible;

            opacity: 1;

            transform:
                translateY(0);
        }


        .profile-wrapper.active .profile-chevron {
            transform:
                rotate(180deg);
        }


        .profile-menu-header {
            padding:
                12px;

            border-bottom:
                1px solid #edf0ee;
        }


        .profile-menu-name {
            font-size: 0.8rem;

            font-weight: 700;
        }


        .profile-menu-email {
            margin-top: 4px;

            overflow: hidden;

            text-overflow: ellipsis;

            color:
                var(--text-muted);

            font-size: 0.67rem;

            white-space: nowrap;
        }


        .profile-menu-list {
            list-style: none;

            padding-top: 7px;
        }


        .profile-menu-link {
            min-height: 40px;

            display: flex;
            align-items: center;

            gap: 10px;

            padding:
                0 10px;

            border-radius: 9px;

            color:
                #50605a;

            font-size: 0.76rem;

            font-weight: 600;
        }


        .profile-menu-link:hover {
            color:
                var(--primary);

            background:
                #eff5f1;
        }


        .profile-menu-link svg {
            width: 17px;
            height: 17px;
        }


        .profile-menu-divider {
            height: 1px;

            margin:
                7px 0;

            background:
                #edf0ee;
        }


        .profile-menu-link.logout {
            color:
                #b74c4c;
        }


        .profile-menu-link.logout:hover {
            background:
                #fff3f3;
        }


        /* =========================================================
           CONTENT
        ========================================================= */

        .app-content {
            min-height: 100vh;

            padding-top:
                var(--header-height);
        }


        .content-container {
            width: 100%;
            max-width: 1600px;

            margin:
                0 auto;

            padding:
                clamp(20px, 3vw, 36px);
        }


        /* =========================================================
           CONTENT HEADER
        ========================================================= */

        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;

            gap: 20px;

            margin-bottom:
                clamp(24px, 3vw, 36px);
        }


        .page-header-content {
            min-width: 0;
        }


        .page-title {
            color:
                var(--text);

            font-size:
                clamp(1.4rem, 2vw, 1.85rem);

            font-weight: 800;

            letter-spacing:
                -0.03em;
        }


        .page-description {
            max-width: 680px;

            margin-top: 8px;

            color:
                var(--text-muted);

            font-size:
                0.86rem;

            line-height:
                1.7;
        }


        .page-actions {
            display: flex;
            align-items: center;

            gap: 10px;

            flex-shrink: 0;
        }


        /* =========================================================
           EMPTY CONTENT AREA
        ========================================================= */

        .page-content {
            width: 100%;
        }


        /* =========================================================
           MOBILE OVERLAY
        ========================================================= */

        .sidebar-overlay {
            position: fixed;

            z-index: 95;

            inset: 0;

            visibility: hidden;

            opacity: 0;

            background:
                rgba(2, 25, 17, 0.45);

            backdrop-filter:
                blur(3px);

            transition:
                opacity var(--transition),
                visibility var(--transition);
        }


        .sidebar-overlay.show {
            visibility: visible;

            opacity: 1;
        }


        /* =========================================================
           SCROLLBAR
        ========================================================= */

        .sidebar::-webkit-scrollbar {
            width: 4px;
        }


        .sidebar::-webkit-scrollbar-thumb {
            border-radius: 20px;

            background:
                rgba(255, 255, 255, 0.18);
        }


        /* =========================================================
           COLLAPSED DESKTOP SIDEBAR
        ========================================================= */

        body.sidebar-collapsed .sidebar {
            width:
                var(--sidebar-collapse-width);
        }


        body.sidebar-collapsed .main-wrapper {
            margin-left:
                var(--sidebar-collapse-width);
        }


        body.sidebar-collapsed .topbar {
            width:
                calc(100% - var(--sidebar-collapse-width));
        }


        body.sidebar-collapsed .sidebar-header {
            justify-content: center;

            padding:
                25px 0;
        }


        body.sidebar-collapsed .brand {
            justify-content: center;
        }


        body.sidebar-collapsed .brand-text,
        body.sidebar-collapsed .nav-section-title,
        body.sidebar-collapsed .nav-text,
        body.sidebar-collapsed .nav-arrow,
        body.sidebar-collapsed .user-mini-info {
            display: none;
        }


        body.sidebar-collapsed .nav-link {
            justify-content: center;

            padding:
                0;
        }


        body.sidebar-collapsed .sidebar-content {
            padding:
                26px 12px;
        }


        body.sidebar-collapsed .user-mini {
            justify-content: center;

            padding:
                10px 0;

            background:
                transparent;
        }


        /* =========================================================
           TABLET
        ========================================================= */

        @media (max-width: 1100px) {

            :root {
                --sidebar-width: 235px;
            }


            .profile-info {
                display: none;
            }


            .profile-button {
                padding:
                    4px;
            }

        }


        /* =========================================================
           MOBILE
        ========================================================= */

        @media (max-width: 820px) {

            :root {
                --sidebar-width: 280px;
                --header-height: 70px;
            }


            .sidebar {
                transform:
                    translateX(-100%);

                box-shadow:
                    15px 0 40px rgba(0, 0, 0, 0.20);
            }


            body.sidebar-open .sidebar {
                transform:
                    translateX(0);
            }


            .main-wrapper {
                margin-left: 0 !important;
            }


            .topbar {
                width: 100% !important;
            }


            body.sidebar-collapsed .sidebar {
                width:
                    var(--sidebar-width);
            }


            body.sidebar-collapsed .brand-text,
            body.sidebar-collapsed .nav-section-title,
            body.sidebar-collapsed .nav-text,
            body.sidebar-collapsed .nav-arrow,
            body.sidebar-collapsed .user-mini-info {
                display: initial;
            }


            body.sidebar-collapsed .nav-link {
                justify-content: flex-start;

                padding:
                    0 14px;
            }


            body.sidebar-collapsed .sidebar-content {
                padding:
                    26px 14px;
            }


            body.sidebar-collapsed .user-mini {
                justify-content: flex-start;

                padding:
                    10px;

                background:
                    rgba(255, 255, 255, 0.055);
            }


            .topbar {
                padding:
                    0 15px;
            }


            .breadcrumb-text {
                display: none;
            }


            .page-header {
                margin-bottom:
                    25px;
            }

        }


        /* =========================================================
           SMALL MOBILE
        ========================================================= */

        @media (max-width: 520px) {

            .content-container {
                padding:
                    20px 15px;
            }


            .topbar-right {
                gap:
                    2px;

                margin-left:
                    10px;
            }


            .topbar-button {
                width: 40px;
                height: 40px;
            }


            .profile-chevron {
                display: none;
            }


            .profile-button {
                padding:
                    2px;
            }


            .page-header {
                flex-direction: column;
            }


            .page-actions {
                width: 100%;
            }


            .profile-menu {
                width:
                    min(260px,
                        calc(100vw - 28px));

                position: fixed;

                top: 68px;
                right: 14px;
            }

        }


        /* =========================================================
           ACCESSIBILITY
        ========================================================= */

        button:focus-visible,
        a:focus-visible {
            outline:
                3px solid rgba(244, 179, 42, 0.65);

            outline-offset:
                3px;
        }


        /* =========================================================
           REDUCED MOTION
        ========================================================= */

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                transition-duration:
                    0.01ms !important;

                animation-duration:
                    0.01ms !important;
            }

        }
    </style>

    @stack('styles')

</head>


<body>


    <div class="app">


        {{-- =========================================================
       MOBILE OVERLAY
    ========================================================= --}}

        <div class="sidebar-overlay" id="sidebarOverlay"></div>



        {{-- =========================================================
       SIDEBAR
    ========================================================= --}}

        <aside class="sidebar" id="sidebar">


            {{-- Decorative elements --}}
            <div class="sidebar-decoration top"></div>
            <div class="sidebar-decoration bottom"></div>


            {{-- =====================================================
           BRAND
        ===================================================== --}}

            <div class="sidebar-header">

                <a href="#" class="brand">

                    <img src="{{ asset('images/aktalink-logo.png') }}" alt="AKTALINK" class="brand-logo">


                    <div class="brand-text">

                        <div class="brand-name">

                            AKTA<span>LINK</span>

                        </div>


                        <div class="brand-subtitle">

                            DISDUKCAPIL KOTA MEDAN

                        </div>

                    </div>

                </a>

            </div>



            {{-- =====================================================
           NAVIGATION
        ===================================================== --}}

            <div class="sidebar-content">


                {{-- MENU UTAMA --}}
                <div class="nav-section">

                    <span class="nav-section-title">
                        Menu Utama
                    </span>


                    <ul class="nav-list">


                        <li class="nav-item">

                            <a href="#" class="nav-link active">

                                <i class="nav-icon" data-lucide="layout-dashboard"></i>


                                <span class="nav-text">
                                    Dashboard
                                </span>

                            </a>

                        </li>


                        <li class="nav-item">

                            <a href="#" class="nav-link">

                                <i class="nav-icon" data-lucide="file-text"></i>


                                <span class="nav-text">
                                    Permohonan
                                </span>

                            </a>

                        </li>


                        <li class="nav-item">

                            <a href="#" class="nav-link">

                                <i class="nav-icon" data-lucide="search-check"></i>


                                <span class="nav-text">
                                    Tracking Permohonan
                                </span>

                            </a>

                        </li>


                        <li class="nav-item">

                            <a href="#" class="nav-link">

                                <i class="nav-icon" data-lucide="clipboard-list"></i>


                                <span class="nav-text">
                                    Jenis Layanan
                                </span>

                            </a>

                        </li>


                        <li class="nav-item">

                            <a href="#" class="nav-link">

                                <i class="nav-icon" data-lucide="history"></i>


                                <span class="nav-text">
                                    Riwayat Aktivitas
                                </span>

                            </a>

                        </li>


                    </ul>

                </div>



                {{-- LAPORAN --}}
                <div class="nav-section">

                    <span class="nav-section-title">
                        Laporan
                    </span>


                    <ul class="nav-list">


                        <li class="nav-item">

                            <a href="#" class="nav-link">

                                <i class="nav-icon" data-lucide="file-bar-chart"></i>


                                <span class="nav-text">
                                    Laporan
                                </span>


                                <i class="nav-arrow" data-lucide="chevron-right"></i>

                            </a>

                        </li>


                        <li class="nav-item">

                            <a href="#" class="nav-link">

                                <i class="nav-icon" data-lucide="chart-no-axes-combined"></i>


                                <span class="nav-text">
                                    Rekap & Statistik
                                </span>

                            </a>

                        </li>


                    </ul>

                </div>



                {{-- PENGATURAN --}}
                <div class="nav-section">

                    <span class="nav-section-title">
                        Pengaturan
                    </span>


                    <ul class="nav-list">


                        <li class="nav-item">

                            <a href="#" class="nav-link">

                                <i class="nav-icon" data-lucide="users-round"></i>


                                <span class="nav-text">
                                    Pengguna
                                </span>

                            </a>

                        </li>


                        <li class="nav-item">

                            <a href="#" class="nav-link">

                                <i class="nav-icon" data-lucide="settings"></i>


                                <span class="nav-text">
                                    Pengaturan
                                </span>

                            </a>

                        </li>


                    </ul>

                </div>


            </div>



            {{-- =====================================================
           SIDEBAR USER
        ===================================================== --}}

            <div class="sidebar-footer">

                <button type="button" class="user-mini">

                    <div class="user-avatar">

                        <i data-lucide="user-round"></i>

                    </div>


                    <div class="user-mini-info">

                        <div class="user-mini-name">

                            Petugas Loket

                        </div>


                        <div class="user-mini-role">

                            Bagian Akta

                        </div>

                    </div>


                    <i class="nav-arrow" data-lucide="chevron-up"></i>

                </button>

            </div>


        </aside>



        {{-- =========================================================
       MAIN
    ========================================================= --}}

        <div class="main-wrapper">


            {{-- =====================================================
           TOPBAR
        ===================================================== --}}

            <header class="topbar">


                {{-- LEFT --}}
                <div class="topbar-left">


                    <button type="button" class="sidebar-toggle" id="sidebarToggle" aria-label="Buka menu">

                        <i data-lucide="menu"></i>

                    </button>


                    <div class="breadcrumb">

                        <div class="breadcrumb-title">

                            @yield('page-title', 'Dashboard')

                        </div>


                        <div class="breadcrumb-text">

                            AKTALINK /
                            @yield('page-title', 'Dashboard')

                        </div>

                    </div>


                </div>



                {{-- RIGHT --}}
                <div class="topbar-right">


                    {{-- NOTIFICATION --}}
                    <button type="button" class="topbar-button" aria-label="Notifikasi">

                        <i data-lucide="bell"></i>


                        <span class="notification-badge">
                            3
                        </span>

                    </button>



                    {{-- PROFILE --}}
                    <div class="profile-wrapper" id="profileWrapper">


                        <button type="button" class="profile-button" id="profileButton">


                            <div class="profile-avatar">

                                <i data-lucide="user-round"></i>

                            </div>


                            <div class="profile-info">

                                <div class="profile-name">

                                    Petugas Loket

                                </div>


                                <div class="profile-role">

                                    Bagian Akta

                                </div>

                            </div>


                            <i class="profile-chevron" data-lucide="chevron-down"></i>


                        </button>



                        {{-- PROFILE DROPDOWN --}}
                        <div class="profile-menu" id="profileMenu">


                            <div class="profile-menu-header">

                                <div class="profile-menu-name">

                                    Petugas Loket

                                </div>


                                <div class="profile-menu-email">

                                    petugas@disdukcapil.go.id

                                </div>

                            </div>


                            <ul class="profile-menu-list">


                                <li>

                                    <a href="#" class="profile-menu-link">

                                        <i data-lucide="user-round"></i>

                                        Profil Saya

                                    </a>

                                </li>


                                <li>

                                    <a href="#" class="profile-menu-link">

                                        <i data-lucide="settings"></i>

                                        Pengaturan Akun

                                    </a>

                                </li>


                                <div class="profile-menu-divider"></div>


                                <li>

                                    <a href="#" class="profile-menu-link logout">

                                        <i data-lucide="log-out"></i>

                                        Keluar

                                    </a>

                                </li>


                            </ul>


                        </div>


                    </div>


                </div>


            </header>



            {{-- =====================================================
           CONTENT
        ===================================================== --}}

            <main class="app-content">


                <div class="content-container">


                    {{-- PAGE HEADER --}}

                    <div class="page-header">


                        <div class="page-header-content">


                            <h1 class="page-title">

                                @yield('page-title', 'Dashboard')

                            </h1>


                            @hasSection('page-description')
                                <p class="page-description">

                                    @yield('page-description')

                                </p>
                            @endif


                        </div>


                        @hasSection('page-actions')
                            <div class="page-actions">

                                @yield('page-actions')

                            </div>
                        @endif


                    </div>



                    {{-- =================================================
                   PAGE CONTENT

                   Isi halaman setiap modul dimasukkan di sini.
                ================================================= --}}

                    <div class="page-content">

                        @yield('content')

                    </div>


                </div>


            </main>


        </div>


    </div>



    {{-- =============================================================
   JAVASCRIPT
============================================================= --}}

    <script>
        /*
        |--------------------------------------------------------------------------
        | LOAD ICONS
        |--------------------------------------------------------------------------
        */

        lucide.createIcons();



        /*
        |--------------------------------------------------------------------------
        | ELEMENTS
        |--------------------------------------------------------------------------
        */

        const body =
            document.body;


        const sidebarToggle =
            document.getElementById(
                'sidebarToggle'
            );


        const sidebarOverlay =
            document.getElementById(
                'sidebarOverlay'
            );


        const profileWrapper =
            document.getElementById(
                'profileWrapper'
            );


        const profileButton =
            document.getElementById(
                'profileButton'
            );


        const profileMenu =
            document.getElementById(
                'profileMenu'
            );



        /*
        |--------------------------------------------------------------------------
        | SCREEN CHECK
        |--------------------------------------------------------------------------
        */

        function isMobile() {

            return window.innerWidth <= 820;

        }



        /*
        |--------------------------------------------------------------------------
        | SIDEBAR TOGGLE
        |--------------------------------------------------------------------------
        */

        sidebarToggle.addEventListener(
            'click',
            function() {


                if (isMobile()) {


                    body.classList.toggle(
                        'sidebar-open'
                    );


                    sidebarOverlay.classList.toggle(
                        'show'
                    );


                } else {


                    body.classList.toggle(
                        'sidebar-collapsed'
                    );


                }


            }
        );



        /*
        |--------------------------------------------------------------------------
        | CLOSE MOBILE SIDEBAR
        |--------------------------------------------------------------------------
        */

        sidebarOverlay.addEventListener(
            'click',
            function() {


                body.classList.remove(
                    'sidebar-open'
                );


                sidebarOverlay.classList.remove(
                    'show'
                );


            }
        );



        /*
        |--------------------------------------------------------------------------
        | RESET SIDEBAR WHEN RESIZE
        |--------------------------------------------------------------------------
        */

        window.addEventListener(
            'resize',
            function() {


                if (!isMobile()) {


                    body.classList.remove(
                        'sidebar-open'
                    );


                    sidebarOverlay.classList.remove(
                        'show'
                    );


                }


            }
        );



        /*
        |--------------------------------------------------------------------------
        | PROFILE DROPDOWN
        |--------------------------------------------------------------------------
        */

        profileButton.addEventListener(
            'click',
            function(event) {


                event.stopPropagation();


                profileMenu.classList.toggle(
                    'show'
                );


                profileWrapper.classList.toggle(
                    'active'
                );


            }
        );



        /*
        |--------------------------------------------------------------------------
        | CLOSE PROFILE WHEN CLICK OUTSIDE
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'click',
            function(event) {


                if (
                    !profileWrapper.contains(
                        event.target
                    )
                ) {


                    profileMenu.classList.remove(
                        'show'
                    );


                    profileWrapper.classList.remove(
                        'active'
                    );


                }


            }
        );



        /*
        |--------------------------------------------------------------------------
        | ESCAPE KEY
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'keydown',
            function(event) {


                if (
                    event.key === 'Escape'
                ) {


                    body.classList.remove(
                        'sidebar-open'
                    );


                    sidebarOverlay.classList.remove(
                        'show'
                    );


                    profileMenu.classList.remove(
                        'show'
                    );


                    profileWrapper.classList.remove(
                        'active'
                    );


                }


            }
        );
    </script>


    @stack('scripts')

</body>

</html>
