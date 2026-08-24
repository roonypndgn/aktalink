<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | AKTALINK</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        /* =====================================================
           ROOT
        ===================================================== */

        :root {
            --primary: #07573c;
            --primary-dark: #043d2a;
            --primary-deep: #032f22;
            --primary-light: #0d7a52;

            --accent: #f4b32a;
            --accent-light: #ffd56d;

            --text: #1e2d28;
            --muted: #73807c;
            --border: #dce3e0;

            --bg: #f5f7f6;
            --white: #ffffff;

            --shadow-lg: 0 25px 70px rgba(8, 40, 29, 0.14);
            --shadow-md: 0 12px 35px rgba(8, 40, 29, 0.10);
            --shadow-sm: 0 6px 20px rgba(8, 40, 29, 0.06);

            --radius-lg: 28px;
            --radius-md: 18px;
            --radius-sm: 12px;
        }


        /* =====================================================
           RESET
        ===================================================== */

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
                var(--bg);

            -webkit-font-smoothing:
                antialiased;
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
        }


        /* =====================================================
           MAIN PAGE
        ===================================================== */

        .login-page {
            width: 100%;
            min-height: 100vh;

            display: grid;

            grid-template-columns:
                minmax(440px, 42%) minmax(0, 58%);

            overflow: hidden;
        }


        /* =====================================================
           LEFT PANEL
        ===================================================== */

        .branding-panel {
            min-height: 100vh;

            position: relative;

            overflow: hidden;

            display: flex;
            flex-direction: column;
            justify-content: center;

            padding:
                clamp(48px, 7vw, 90px) clamp(35px, 6vw, 90px);

            background:
                radial-gradient(circle at 20% 50%,
                    rgba(41, 150, 99, 0.35),
                    transparent 32%),
                radial-gradient(circle at 80% 75%,
                    rgba(15, 117, 74, 0.45),
                    transparent 35%),
                linear-gradient(145deg,
                    var(--primary-deep) 0%,
                    var(--primary-dark) 40%,
                    var(--primary) 100%);
        }


        /* =====================================================
           ABSTRACT BACKGROUND CIRCLES
        ===================================================== */

        .orb {
            position: absolute;

            border-radius: 50%;

            pointer-events: none;
        }


        .orb-one {
            width: 380px;
            height: 380px;

            top: -230px;
            left: -220px;

            border:
                1px solid rgba(150, 230, 190, 0.16);

            box-shadow:
                0 0 0 35px rgba(150, 230, 190, 0.035),
                0 0 0 70px rgba(150, 230, 190, 0.025),
                0 0 0 105px rgba(150, 230, 190, 0.015);
        }


        .orb-two {
            width: 300px;
            height: 300px;

            bottom: -190px;
            right: -170px;

            border:
                1px solid rgba(255, 255, 255, 0.10);

            box-shadow:
                0 0 0 25px rgba(255, 255, 255, 0.025),
                0 0 0 50px rgba(255, 255, 255, 0.018);
        }


        /* =====================================================
           DOTS
        ===================================================== */

        .dots {
            position: absolute;

            display: grid;

            grid-template-columns:
                repeat(3, 4px);

            gap: 17px;

            opacity: 0.7;
        }


        .dots span {
            width: 4px;
            height: 4px;

            border-radius: 50%;

            background:
                rgba(255, 255, 255, 0.85);
        }


        .dots-left {
            top: 23%;
            left: 38px;
        }


        .dots-bottom {
            right: 50px;
            bottom: 55px;
        }


        /* =====================================================
           BRAND CONTENT
        ===================================================== */

        .branding-content {
            width: 100%;
            max-width: 540px;

            position: relative;
            z-index: 2;
        }


        .brand-logo-wrapper {
            margin-bottom: 44px;
        }


        .brand-logo {
            width: min(100%, 300px);
            height: auto;

            display: block;

            object-fit: contain;
            object-position: left center;
        }


        .brand-subtitle {
            margin-top: 4px;

            font-size: 0.82rem;

            font-weight: 600;

            letter-spacing: 0.36em;

            color:
                rgba(255, 255, 255, 0.74);
        }


        /* =====================================================
           TAGLINE
        ===================================================== */

        .tagline {
            margin-bottom: 48px;
        }


        .tagline h1 {
            max-width: 450px;

            color: var(--white);

            font-size:
                clamp(1.9rem, 3vw, 2.65rem);

            line-height: 1.38;

            font-weight: 500;

            letter-spacing: -0.025em;
        }


        .tagline h1 strong {
            font-weight: 800;
        }


        .tagline-line {
            width: 100px;
            height: 2px;

            margin-top: 22px;

            position: relative;

            background:
                rgba(244, 179, 42, 0.85);
        }


        .tagline-line::after {
            content: "";

            position: absolute;

            width: 8px;
            height: 8px;

            top: 50%;
            right: -2px;

            transform:
                translateY(-50%);

            border-radius: 50%;

            background:
                var(--accent);
        }


        /* =====================================================
           PROCESS FLOW
        ===================================================== */

        .process-card {
            width: 100%;

            padding:
                22px 24px;

            position: relative;

            border:
                1px solid rgba(255, 255, 255, 0.11);

            border-radius: 20px;

            background:
                linear-gradient(135deg,
                    rgba(255, 255, 255, 0.10),
                    rgba(255, 255, 255, 0.035));

            backdrop-filter:
                blur(12px);

            box-shadow:
                0 15px 35px rgba(0, 0, 0, 0.08);
        }


        .process-label {
            margin-bottom: 22px;

            font-size: 0.72rem;

            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: 0.14em;

            color:
                rgba(255, 255, 255, 0.65);
        }


        .process-flow {
            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            position: relative;
        }


        .process-flow::before {
            content: "";

            position: absolute;

            top: 22px;
            left: 12%;
            right: 12%;

            height: 1px;

            background:
                linear-gradient(90deg,
                    rgba(255, 255, 255, 0.16),
                    rgba(244, 179, 42, 0.70),
                    rgba(255, 255, 255, 0.16));
        }


        .process-step {
            position: relative;

            z-index: 2;

            display: flex;
            flex-direction: column;
            align-items: center;

            gap: 10px;

            text-align: center;
        }


        .process-icon {
            width: 45px;
            height: 45px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            color:
                rgba(255, 255, 255, 0.92);

            background:
                #0b6748;

            border:
                1px solid rgba(255, 255, 255, 0.16);

            box-shadow:
                0 6px 18px rgba(0, 0, 0, 0.12);
        }


        .process-step.active .process-icon {
            color: #694900;

            background:
                var(--accent);

            border-color:
                var(--accent);
        }


        .process-icon svg {
            width: 19px;
            height: 19px;
        }


        .process-step span {
            color:
                rgba(255, 255, 255, 0.82);

            font-size:
                clamp(0.62rem, 1vw, 0.74rem);

            font-weight: 600;
        }


        /* =====================================================
           RIGHT PANEL
        ===================================================== */

        .login-panel {
            min-height: 100vh;

            position: relative;

            display: flex;
            flex-direction: column;

            align-items: center;
            justify-content: center;

            padding:
                60px clamp(30px, 7vw, 120px);

            background:
                radial-gradient(circle at 70% 15%,
                    rgba(231, 237, 240, 0.9),
                    transparent 24%),
                radial-gradient(circle at 15% 80%,
                    rgba(237, 241, 239, 0.8),
                    transparent 26%),
                #f7f9f8;
        }


        /* =====================================================
           LOGIN CARD
        ===================================================== */

        .login-card {
            width: 100%;
            max-width: 540px;

            position: relative;
            z-index: 3;

            padding:
                clamp(34px, 4vw, 52px);

            border:
                1px solid rgba(214, 222, 218, 0.85);

            border-radius:
                var(--radius-lg);

            background:
                rgba(255, 255, 255, 0.86);

            backdrop-filter:
                blur(15px);

            box-shadow:
                var(--shadow-lg);
        }


        /* =====================================================
           LOGIN HEADER
        ===================================================== */

        .login-header {
            margin-bottom: 34px;

            text-align: center;
        }


        .login-header-icon {
            width: 72px;
            height: 72px;

            margin:
                0 auto 18px;

            display: flex;
            align-items: center;
            justify-content: center;

            color:
                var(--primary);

            border-radius: 50%;

            background:
                linear-gradient(145deg,
                    #ffffff,
                    #edf2ef);

            border:
                1px solid #dfe6e2;

            box-shadow:
                var(--shadow-sm);
        }


        .login-header-icon svg {
            width: 30px;
            height: 30px;
        }


        .login-header h2 {
            font-size:
                clamp(1.8rem, 3vw, 2.25rem);

            font-weight: 700;

            letter-spacing: -0.03em;

            color:
                var(--text);
        }


        .login-header p {
            margin-top: 8px;

            color:
                var(--muted);

            font-size: 0.94rem;
        }


        /* =====================================================
           FORM
        ===================================================== */

        .form-group {
            margin-bottom: 21px;
        }


        .form-label {
            display: block;

            margin-bottom: 9px;

            font-size: 0.85rem;

            font-weight: 600;

            color:
                #34423d;
        }


        .input-wrapper {
            position: relative;
        }


        .input-icon {
            position: absolute;

            top: 50%;
            left: 18px;

            width: 20px;
            height: 20px;

            transform:
                translateY(-50%);

            color:
                #6f7e79;

            pointer-events: none;
        }


        .form-control {
            width: 100%;
            height: 58px;

            padding:
                0 55px;

            border:
                1px solid var(--border);

            border-radius:
                14px;

            outline: none;

            color:
                var(--text);

            font-size: 0.93rem;

            background:
                rgba(255, 255, 255, 0.85);

            transition:
                border-color .2s ease,
                box-shadow .2s ease,
                background .2s ease;
        }


        .form-control::placeholder {
            color:
                #9aa5a1;
        }


        .form-control:hover {
            border-color:
                #bcc9c4;
        }


        .form-control:focus {
            border-color:
                rgba(7, 87, 60, 0.70);

            background:
                var(--white);

            box-shadow:
                0 0 0 4px rgba(7, 87, 60, 0.08);
        }


        .password-toggle {
            width: 44px;
            height: 44px;

            position: absolute;

            top: 50%;
            right: 7px;

            transform:
                translateY(-50%);

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 10px;

            color:
                #687670;

            background:
                transparent;

            cursor: pointer;

            transition:
                background .2s ease,
                color .2s ease;
        }


        .password-toggle:hover {
            color:
                var(--primary);

            background:
                rgba(7, 87, 60, 0.06);
        }


        .password-toggle svg {
            width: 20px;
            height: 20px;
        }


        /* =====================================================
           LOGIN OPTIONS
        ===================================================== */

        .login-options {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;

            margin:
                4px 0 25px;
        }


        .remember-me {
            display: inline-flex;
            align-items: center;

            gap: 10px;

            color:
                #5c6964;

            font-size: 0.86rem;

            cursor: pointer;

            user-select: none;
        }


        .remember-me input {
            position: absolute;

            opacity: 0;

            pointer-events: none;
        }


        .custom-checkbox {
            width: 21px;
            height: 21px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            border:
                1.5px solid #c5ceca;

            border-radius: 6px;

            background:
                var(--white);

            transition: .2s ease;
        }


        .custom-checkbox svg {
            width: 14px;
            height: 14px;

            opacity: 0;

            transform:
                scale(.6);

            color: white;

            transition: .2s ease;
        }


        .remember-me input:checked+.custom-checkbox {
            border-color:
                var(--primary);

            background:
                var(--primary);
        }


        .remember-me input:checked+.custom-checkbox svg {
            opacity: 1;

            transform:
                scale(1);
        }


        .forgot-password {
            color:
                var(--primary);

            font-size: 0.86rem;

            font-weight: 600;

            white-space: nowrap;
        }


        .forgot-password:hover {
            text-decoration:
                underline;
        }


        /* =====================================================
           LOGIN BUTTON
        ===================================================== */

        .btn-login {
            width: 100%;
            height: 58px;

            position: relative;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius:
                14px;

            cursor: pointer;

            color:
                var(--white);

            background:
                linear-gradient(135deg,
                    var(--primary-light),
                    var(--primary-dark));

            box-shadow:
                0 12px 24px rgba(7, 87, 60, 0.18);

            font-size: 0.98rem;

            font-weight: 700;

            transition:
                transform .2s ease,
                box-shadow .2s ease;
        }


        .btn-login:hover {
            transform:
                translateY(-2px);

            box-shadow:
                0 15px 30px rgba(7, 87, 60, 0.25);
        }


        .btn-login:active {
            transform:
                translateY(0);
        }


        .btn-login svg {
            position: absolute;

            right: 20px;

            width: 22px;
            height: 22px;
        }


        /* =====================================================
           DIVIDER
        ===================================================== */

        .divider {
            display: flex;
            align-items: center;

            gap: 15px;

            margin:
                28px 0;
        }


        .divider::before,
        .divider::after {
            content: "";

            flex: 1;

            height: 1px;

            background:
                #e2e7e4;
        }


        .divider span {
            color:
                #7d8985;

            font-size:
                0.82rem;
        }


        /* =====================================================
           INTERNAL LOGIN
        ===================================================== */

        .btn-internal {
            width: 100%;
            min-height: 58px;

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 14px;

            padding:
                12px 18px;

            border:
                1px solid rgba(7, 87, 60, 0.75);

            border-radius:
                14px;

            cursor: pointer;

            color:
                #345047;

            background:
                rgba(255, 255, 255, 0.72);

            font-size:
                0.92rem;

            font-weight: 700;

            transition:
                background .2s ease,
                transform .2s ease,
                box-shadow .2s ease;
        }


        .btn-internal:hover {
            background:
                #f3f8f5;

            transform:
                translateY(-1px);

            box-shadow:
                0 7px 20px rgba(7, 87, 60, 0.08);
        }


        .internal-icon {
            width: 34px;
            height: 34px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            color:
                var(--primary);
        }


        .internal-icon svg {
            width: 29px;
            height: 29px;
        }


        /* =====================================================
           FOOTER
        ===================================================== */

        .copyright {
            position: absolute;

            bottom: 28px;
            left: 50%;

            transform:
                translateX(-50%);

            width: 100%;

            padding:
                0 20px;

            text-align: center;

            color:
                #7a8581;

            font-size:
                0.78rem;

            line-height:
                1.7;
        }


        /* =====================================================
           RIGHT DECORATIONS
        ===================================================== */

        .right-decoration {
            position: absolute;

            pointer-events: none;
        }


        .right-decoration.top {
            top: -130px;
            right: -130px;

            width: 320px;
            height: 320px;

            border-radius: 50%;

            border:
                1px solid rgba(7, 87, 60, 0.06);

            box-shadow:
                0 0 0 25px rgba(7, 87, 60, 0.025),
                0 0 0 50px rgba(7, 87, 60, 0.018);
        }


        .right-decoration.bottom {
            width: 170px;
            height: 170px;

            right: 30px;
            bottom: -65px;

            border-radius: 50%;

            border:
                1px solid rgba(7, 87, 60, 0.08);

            box-shadow:
                0 0 0 14px rgba(7, 87, 60, 0.025),
                0 0 0 28px rgba(7, 87, 60, 0.015);
        }


        /* =====================================================
           TABLET
        ===================================================== */

        @media (max-width: 1100px) {

            .login-page {
                grid-template-columns:
                    45% 55%;
            }


            .branding-panel {
                padding:
                    50px 40px;
            }


            .login-panel {
                padding:
                    50px 40px 90px;
            }


            .process-flow {
                grid-template-columns:
                    repeat(2, 1fr);

                gap: 24px;
            }


            .process-flow::before {
                display: none;
            }


            .process-card {
                padding:
                    20px;
            }

        }


        /* =====================================================
           MOBILE / TABLET PORTRAIT
        ===================================================== */

        @media (max-width: 820px) {

            body {
                background:
                    var(--primary-dark);
            }


            .login-page {
                display: block;
            }


            .branding-panel {
                min-height: auto;

                padding:
                    48px 28px 42px;

                text-align: center;
            }


            .branding-content {
                max-width:
                    580px;

                margin:
                    0 auto;
            }


            .brand-logo {
                width: 230px;

                margin:
                    0 auto;
            }


            .brand-logo-wrapper {
                margin-bottom: 28px;
            }


            .brand-subtitle {
                letter-spacing:
                    0.22em;

                font-size:
                    0.7rem;
            }


            .tagline {
                margin-bottom: 32px;
            }


            .tagline h1 {
                margin:
                    0 auto;

                font-size:
                    clamp(1.55rem, 6vw, 2rem);
            }


            .tagline-line {
                margin:
                    18px auto 0;
            }


            .process-card {
                max-width:
                    580px;

                margin:
                    0 auto;

                text-align: left;
            }


            .login-panel {
                min-height: auto;

                padding:
                    38px 22px 100px;

                background:
                    #f7f9f8;
            }


            .login-card {
                max-width:
                    600px;

                padding:
                    34px 26px;

                border-radius:
                    24px;
            }


            .copyright {
                position: absolute;
            }

        }


        /* =====================================================
           SMALL MOBILE
        ===================================================== */

        @media (max-width: 520px) {

            .branding-panel {
                padding:
                    40px 20px 35px;
            }


            .dots-left {
                top: 20px;
                left: 20px;
            }


            .dots-bottom {
                display: none;
            }


            .brand-logo {
                width: 200px;
            }


            .process-card {
                padding:
                    20px 14px;
            }


            .process-flow {
                gap:
                    18px 10px;
            }


            .process-icon {
                width: 42px;
                height: 42px;
            }


            .login-panel {
                padding:
                    26px 14px 95px;
            }


            .login-card {
                padding:
                    30px 20px;
            }


            .login-header {
                margin-bottom:
                    27px;
            }


            .login-header-icon {
                width: 62px;
                height: 62px;
            }


            .form-control {
                height:
                    54px;
            }


            .login-options {
                flex-wrap:
                    wrap;

                row-gap:
                    15px;
            }


            .forgot-password {
                width: 100%;

                text-align:
                    right;
            }


            .btn-login,
            .btn-internal {
                min-height:
                    54px;

                height:
                    54px;
            }


            .btn-internal {
                font-size:
                    0.82rem;
            }


            .copyright {
                bottom:
                    22px;
            }

        }


        /* =====================================================
           ACCESSIBILITY
        ===================================================== */

        .form-control:focus-visible,
        .btn-login:focus-visible,
        .btn-internal:focus-visible,
        .password-toggle:focus-visible,
        .forgot-password:focus-visible {
            outline:
                3px solid rgba(244, 179, 42, 0.55);

            outline-offset:
                3px;
        }


        /* =====================================================
           REDUCED MOTION
        ===================================================== */

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                scroll-behavior:
                    auto !important;

                transition-duration:
                    0.01ms !important;

                animation-duration:
                    0.01ms !important;
            }

        }
    </style>

</head>

<body>


    <div class="login-page">


        {{-- =====================================================
       LEFT: BRANDING
    ===================================================== --}}

        <section class="branding-panel" aria-label="Informasi AKTALINK">


            {{-- ABSTRACT ORNAMENT --}}
            <div class="orb orb-one"></div>

            <div class="orb orb-two"></div>


            {{-- DOTS --}}
            <div class="dots dots-left">

                @for ($i = 0; $i < 12; $i++)
                    <span></span>
                @endfor

            </div>


            <div class="dots dots-bottom">

                @for ($i = 0; $i < 12; $i++)
                    <span></span>
                @endfor

            </div>


            {{-- MAIN CONTENT --}}
            <div class="branding-content">


                {{-- LOGO --}}
                <div class="brand-logo-wrapper">

                    <img src="{{ asset('images/aktalink-logo.png') }}" alt="AKTALINK" class="brand-logo">


                    <div class="brand-subtitle">

                        DISDUKCAPIL KOTA MEDAN

                    </div>

                </div>


                {{-- TAGLINE --}}
                <div class="tagline">

                    <h1>

                        Terhubung dalam proses,
                        <br>

                        <strong>
                            transparan dalam status.
                        </strong>

                    </h1>


                    <div class="tagline-line"></div>

                </div>


                {{-- PROCESS --}}
                <div class="process-card">


                    <div class="process-label">

                        Alur Permohonan

                    </div>


                    <div class="process-flow">


                        {{-- STEP 1 --}}
                        <div class="process-step">


                            <div class="process-icon">

                                <i data-lucide="file-text"></i>

                            </div>


                            <span>
                                Permohonan
                            </span>


                        </div>


                        {{-- STEP 2 --}}
                        <div class="process-step">


                            <div class="process-icon">

                                <i data-lucide="badge-check"></i>

                            </div>


                            <span>
                                Verifikasi
                            </span>


                        </div>


                        {{-- STEP 3 --}}
                        <div class="process-step">


                            <div class="process-icon">

                                <i data-lucide="loader-circle"></i>

                            </div>


                            <span>
                                Diproses
                            </span>


                        </div>


                        {{-- STEP 4 --}}
                        <div class="process-step active">


                            <div class="process-icon">

                                <i data-lucide="check"></i>

                            </div>


                            <span>
                                Selesai
                            </span>


                        </div>


                    </div>


                </div>


            </div>


        </section>



        {{-- =====================================================
       RIGHT: LOGIN
    ===================================================== --}}

        <main class="login-panel">


            {{-- DECORATION --}}
            <div class="right-decoration top" aria-hidden="true"></div>


            <div class="right-decoration bottom" aria-hidden="true"></div>


            {{-- LOGIN CARD --}}
            <section class="login-card" aria-labelledby="login-title">


                {{-- HEADER --}}
                <div class="login-header">


                    <div class="login-header-icon">

                        <i data-lucide="user-round"></i>

                    </div>


                    <h2 id="login-title">

                        Login

                    </h2>


                    <p>

                        Masuk untuk melanjutkan ke AKTALINK

                    </p>


                </div>



                {{-- FORM --}}
                <form action="#" method="POST" id="loginForm">

                    @csrf


                    {{-- USERNAME --}}
                    <div class="form-group">


                        <label for="username" class="form-label">

                            Username

                        </label>


                        <div class="input-wrapper">


                            <i class="input-icon" data-lucide="user-round"></i>


                            <input type="text" id="username" name="username" class="form-control"
                                placeholder="Masukkan username" autocomplete="username" required>


                        </div>


                    </div>



                    {{-- PASSWORD --}}
                    <div class="form-group">


                        <label for="password" class="form-label">

                            Password

                        </label>


                        <div class="input-wrapper">


                            <i class="input-icon" data-lucide="lock-keyhole"></i>


                            <input type="password" id="password" name="password" class="form-control"
                                placeholder="Masukkan password" autocomplete="current-password" required>


                            <button type="button" class="password-toggle" id="togglePassword"
                                aria-label="Tampilkan password" aria-pressed="false">

                                <i id="passwordIcon" data-lucide="eye"></i>

                            </button>


                        </div>


                    </div>



                    {{-- OPTIONS --}}
                    <div class="login-options">


                        <label class="remember-me">


                            <input type="checkbox" name="remember" id="remember">


                            <span class="custom-checkbox">

                                <i data-lucide="check"></i>

                            </span>


                            <span>

                                Ingat saya

                            </span>


                        </label>


                        <a href="#" class="forgot-password">

                            Lupa password?

                        </a>


                    </div>



                    {{-- LOGIN BUTTON --}}
                    <button type="submit" class="btn-login">

                        <span>
                            Masuk
                        </span>


                        <i data-lucide="arrow-right"></i>

                    </button>

                </form>


            </section>



            {{-- COPYRIGHT --}}
            <footer class="copyright">

                © {{ date('Y') }} Disdukcapil Kota Medan.
                <br>
                Semua Hak Dilindungi.

            </footer>


        </main>


    </div>



    <script>
        /*
        |--------------------------------------------------------------------------
        | LOAD LUCIDE ICONS
        |--------------------------------------------------------------------------
        */

        lucide.createIcons();



        /*
        |--------------------------------------------------------------------------
        | SHOW / HIDE PASSWORD
        |--------------------------------------------------------------------------
        */

        const password =
            document.getElementById('password');


        const togglePassword =
            document.getElementById('togglePassword');


        const passwordIcon =
            document.getElementById('passwordIcon');


        togglePassword.addEventListener(
            'click',
            function() {

                const isPassword =
                    password.type === 'password';


                password.type =
                    isPassword ?
                    'text' :
                    'password';


                passwordIcon.setAttribute(
                    'data-lucide',
                    isPassword ?
                    'eye-off' :
                    'eye'
                );


                togglePassword.setAttribute(
                    'aria-label',
                    isPassword ?
                    'Sembunyikan password' :
                    'Tampilkan password'
                );


                togglePassword.setAttribute(
                    'aria-pressed',
                    isPassword ?
                    'true' :
                    'false'
                );


                lucide.createIcons();

            }
        );
    </script>


</body>

</html>
