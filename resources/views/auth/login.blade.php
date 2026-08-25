<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Masuk - AKTALINK</title>
<link rel="icon" href="{{ asset('images/aktalink-logo.png') }}">
<style>
*{margin:0;padding:0;box-sizing:border-box}
:root{
    --primary:#064e3b;
    --primary-dark:#043d2e;
    --primary-light:#0b6b52;
    --accent:#e7b24a;
    --text:#17352e;
    --muted:#71817c;
    --border:#e4eae7;
    --white:#fff;
}
html,body{min-height:100%;font-family:Inter,Arial,sans-serif}
body{background:#f5f7f6;color:var(--text)}
.login-page{min-height:100vh;display:grid;grid-template-columns:1fr 1fr}

/* ================= LEFT ================= */
.login-brand{
    position:relative;
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    overflow:hidden;
    padding:48px;
    color:#fff;
    background:linear-gradient(145deg,#043d2e 0%,#07533f 52%,#0b6b52 100%);
}
.login-brand::before{
    content:"";
    position:absolute;
    width:580px;
    height:580px;
    border:1px solid rgba(255,255,255,.08);
    border-radius:50%;
    top:-330px;
    left:-260px;
    box-shadow:0 0 0 70px rgba(255,255,255,.025),0 0 0 140px rgba(255,255,255,.018);
}
.login-brand::after{
    content:"";
    position:absolute;
    width:450px;
    height:450px;
    border:1px solid rgba(255,255,255,.08);
    border-radius:50%;
    right:-250px;
    bottom:-280px;
    box-shadow:0 0 0 70px rgba(255,255,255,.025),0 0 0 140px rgba(255,255,255,.018);
}
.brand-grid{
    position:absolute;
    inset:0;
    opacity:.035;
    background-image:
        linear-gradient(rgba(255,255,255,1) 1px,transparent 1px),
        linear-gradient(90deg,rgba(255,255,255,1) 1px,transparent 1px);
    background-size:36px 36px;
}
.brand-top{
    position:absolute;
    z-index:2;
    top:38px;
    left:48px;
    display:flex;
    align-items:center;
    gap:12px;
}
.brand-top-logo{
    width:42px;
    height:42px;
    object-fit:contain;
}
.brand-top-name{
    font-size:18px;
    font-weight:800;
    letter-spacing:1px;
}
.brand-top-name span{color:var(--accent)}
.brand-content{
    position:relative;
    z-index:2;
    width:100%;
    max-width:480px;
    text-align:center;
    display:flex;
    flex-direction:column;
    align-items:center;
}
.brand-logo-wrap{
    width:118px;
    height:118px;
    display:flex;
    align-items:center;
    justify-content:center;
    border:1px solid rgba(255,255,255,.15);
    border-radius:30px;
    background:rgba(255,255,255,.07);
    backdrop-filter:blur(10px);
    margin-bottom:28px;
    box-shadow:0 18px 45px rgba(0,0,0,.12);
}
.brand-logo{
    width:82px;
    max-height:82px;
    object-fit:contain;
}
.brand-content h1{
    font-size:46px;
    line-height:1;
    font-weight:850;
    letter-spacing:1px;
}
.brand-content h1 span{color:var(--accent)}
.brand-tagline{
    margin-top:14px;
    font-size:14px;
    font-weight:500;
    letter-spacing:1.5px;
    text-transform:uppercase;
    color:rgba(255,255,255,.65);
}
.brand-divider{
    width:64px;
    height:3px;
    margin:26px 0;
    border-radius:10px;
    background:var(--accent);
}
.brand-description{
    max-width:430px;
    font-size:15px;
    line-height:1.8;
    color:rgba(255,255,255,.72);
}
.brand-features{
    width:100%;
    max-width:400px;
    margin-top:38px;
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:10px;
}
.brand-feature{
    padding:16px 8px;
    border:1px solid rgba(255,255,255,.1);
    border-radius:15px;
    background:rgba(255,255,255,.055);
    backdrop-filter:blur(8px);
    transition:.25s ease;
}
.brand-feature:hover{
    transform:translateY(-3px);
    background:rgba(255,255,255,.09);
}
.feature-icon{
    width:36px;
    height:36px;
    margin:0 auto 10px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:10px;
    color:#fff;
    background:rgba(231,178,74,.16);
}
.feature-icon svg{
    width:19px;
    height:19px;
    stroke:var(--accent);
}
.brand-feature span{
    display:block;
    font-size:11px;
    line-height:1.4;
    color:rgba(255,255,255,.78);
}
.brand-bottom{
    position:absolute;
    z-index:2;
    left:48px;
    right:48px;
    bottom:34px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    color:rgba(255,255,255,.45);
    font-size:11px;
}
.brand-bottom-line{
    width:55px;
    height:1px;
    background:rgba(255,255,255,.25);
}

/* ================= RIGHT ================= */
.login-form-area{
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:40px 24px;
    background:#fff;
}
.login-form{width:100%;max-width:430px}
.mobile-logo{display:none;text-align:center;margin-bottom:32px}
.mobile-logo img{width:95px;height:auto;object-fit:contain}
.form-header{margin-bottom:32px}
.form-header h2{
    font-size:32px;
    font-weight:750;
    color:var(--text);
    margin-bottom:9px;
}
.form-header p{
    font-size:15px;
    color:var(--muted);
    line-height:1.6;
}
.alert{
    padding:14px 16px;
    border-radius:10px;
    margin-bottom:22px;
    font-size:14px;
    line-height:1.5;
}
.alert-success{
    color:#166534;
    background:#f0fdf4;
    border:1px solid #bbf7d0;
}
.form-group{margin-bottom:20px}
.form-group label{
    display:block;
    font-size:14px;
    font-weight:600;
    margin-bottom:8px;
    color:var(--text);
}
.input-wrap{position:relative}
.input-icon{
    position:absolute;
    width:20px;
    height:20px;
    left:16px;
    top:50%;
    transform:translateY(-50%);
    stroke:#82918c;
    pointer-events:none;
}
.form-control{
    width:100%;
    height:54px;
    border:1px solid var(--border);
    border-radius:11px;
    padding:0 48px;
    outline:none;
    font-size:15px;
    color:var(--text);
    transition:.2s ease;
    background:#fff;
}
.form-control:focus{
    border-color:var(--primary-light);
    box-shadow:0 0 0 4px rgba(11,107,82,.10);
}
.form-control.is-invalid{border-color:#dc2626}
.input-error{
    margin-top:7px;
    font-size:13px;
    color:#dc2626;
}
.password-toggle{
    position:absolute;
    right:14px;
    top:50%;
    transform:translateY(-50%);
    width:28px;
    height:28px;
    border:0;
    background:transparent;
    cursor:pointer;
    color:#71817c;
    display:flex;
    align-items:center;
    justify-content:center;
}
.password-toggle svg{
    width:20px;
    height:20px;
    stroke:currentColor;
}
.form-options{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:15px;
    margin:4px 0 26px;
}
.remember{
    display:flex;
    align-items:center;
    gap:8px;
    cursor:pointer;
    color:#60716b;
    font-size:14px;
}
.remember input{
    width:16px;
    height:16px;
    accent-color:var(--primary);
    cursor:pointer;
}
.btn-login{
    width:100%;
    height:54px;
    border:0;
    border-radius:11px;
    background:var(--primary);
    color:#fff;
    font-size:15px;
    font-weight:700;
    cursor:pointer;
    transition:.2s ease;
    display:flex;
    justify-content:center;
    align-items:center;
    gap:10px;
}
.btn-login:hover{
    background:var(--primary-dark);
    transform:translateY(-1px);
}
.btn-login:active{transform:translateY(0)}
.btn-login svg{width:19px;height:19px}
.login-note{
    text-align:center;
    margin-top:28px;
    font-size:13px;
    color:#9aa6a2;
}

/* ================= RESPONSIVE ================= */
@media(max-width:900px){
    .login-page{grid-template-columns:1fr}
    .login-brand{display:none}
    .login-form-area{min-height:100vh}
    .mobile-logo{display:block}
}
@media(max-width:500px){
    .login-form-area{padding:32px 20px}
    .form-header h2{font-size:28px}
    .form-options{
        flex-direction:column;
        align-items:flex-start;
    }
}
</style>
</head>
<body>

<div class="login-page">

    {{-- BAGIAN KIRI --}}
    <section class="login-brand">
        <div class="brand-grid"></div>

        <div class="brand-top">
            <img src="{{ asset('images/aktalink-logo.png') }}" alt="AKTALINK" class="brand-top-logo">
            <div class="brand-top-name">AKTA<span>LINK</span></div>
        </div>

        <div class="brand-content">

            <div class="brand-logo-wrap">
                <img src="{{ asset('images/aktalink-logo.png') }}" alt="Logo AKTALINK" class="brand-logo">
            </div>

            <div class="brand-tagline">
                Terhubung • Terpantau • Terarah
            </div>

            <div class="brand-divider"></div>

            <p class="brand-description">
                Sistem informasi internal untuk mendukung pengelolaan,
                distribusi, pemeriksaan, dan monitoring permohonan
                pada Bagian Akta.
            </p>

            <div class="brand-features">

                <div class="brand-feature">
                    <div class="feature-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375H5.25A2.25 2.25 0 0 0 3 10.5v7.125a2.25 2.25 0 0 0 2.25 2.25h10.875a3.375 3.375 0 0 0 3.375-3.375Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 10.5V6.375a2.25 2.25 0 0 1 2.25-2.25h8.25a2.25 2.25 0 0 1 2.25 2.25V8.25"/>
                        </svg>
                    </div>
                    <span>Pencatatan<br>Permohonan</span>
                </div>

                <div class="brand-feature">
                    <div class="feature-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7.5 3.75h9A2.25 2.25 0 0 1 18.75 6v12A2.25 2.25 0 0 1 16.5 20.25h-9A2.25 2.25 0 0 1 5.25 18V6A2.25 2.25 0 0 1 7.5 3.75Z"/>
                            <path stroke-linecap="round" d="M8.25 9h7.5M8.25 12h7.5M8.25 15h4.5"/>
                        </svg>
                    </div>
                    <span>Distribusi<br>Berkas</span>
                </div>

                <div class="brand-feature">
                    <div class="feature-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6l4 2"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                    </div>
                    <span>Monitoring<br>Status</span>
                </div>

            </div>

        </div>

        <div class="brand-bottom">
            <span>Bagian Akta • Disdukcapil Kota Medan</span>
            <div class="brand-bottom-line"></div>
        </div>
    </section>

    {{-- BAGIAN KANAN --}}
    <section class="login-form-area">
        <div class="login-form">

            <div class="mobile-logo">
                <img src="{{ asset('images/aktalink-logo.png') }}" alt="Logo AKTALINK">
            </div>

            <div class="form-header">
                <h2>Selamat Datang</h2>
                <p>Silakan masuk untuk mengakses sistem AKTALINK.</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('login.process') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="username">Username</label>

                    <div class="input-wrap">
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.118a7.5 7.5 0 0 1 15 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.5-1.632Z"/>
                        </svg>

                        <input
                            type="text"
                            id="username"
                            name="username"
                            class="form-control @error('username') is-invalid @enderror"
                            value="{{ old('username') }}"
                            placeholder="Masukkan username"
                            autocomplete="username"
                            autofocus
                        >
                    </div>

                    @error('username')
                        <div class="input-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>

                    <div class="input-wrap">
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-3 0h15A2.25 2.25 0 0 1 21.75 12.75v6A2.25 2.25 0 0 1 19.5 21h-15a2.25 2.25 0 0 1-2.25-2.25v-6A2.25 2.25 0 0 1 4.5 10.5Z"/>
                        </svg>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                        >

                        <button type="button" class="password-toggle" id="togglePassword">
                            <svg id="eyeOpen" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 12S5.25 5.25 12 5.25 21.75 12 21.75 12 18.75 18.75 12 18.75 2.25 12 2.25 12Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 15.75A3.75 3.75 0 1 0 12 8.25a3.75 3.75 0 0 0 0 7.5Z"/>
                            </svg>

                            <svg id="eyeClosed" fill="none" viewBox="0 0 24 24" stroke-width="1.8" style="display:none">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m3 3 18 18M10.584 10.587A2.25 2.25 0 0 0 13.416 13.4M9.88 4.24A9.87 9.87 0 0 1 12 4c6.75 0 9.75 8 9.75 8a18.47 18.47 0 0 1-3.31 4.72M6.61 6.61C3.82 8.56 2.25 12 2.25 12S5.25 20 12 20c1.04 0 1.99-.19 2.85-.51"/>
                            </svg>
                        </button>
                    </div>

                    @error('password')
                        <div class="input-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-options">
                    <label class="remember">
                        <input
                            type="checkbox"
                            name="remember"
                            value="1"
                            {{ old('remember') ? 'checked' : '' }}
                        >
                        <span>Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="btn-login">
                    <span>Masuk ke Sistem</span>
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                    </svg>
                </button>
            </form>

            <p class="login-note">
                AKTALINK — Sistem Informasi Bagian Akta
            </p>

        </div>
    </section>

</div>

<script>
const togglePassword=document.getElementById('togglePassword');
const password=document.getElementById('password');
const eyeOpen=document.getElementById('eyeOpen');
const eyeClosed=document.getElementById('eyeClosed');

togglePassword.addEventListener('click',function(){
    const isPassword=password.type==='password';
    password.type=isPassword?'text':'password';
    eyeOpen.style.display=isPassword?'none':'block';
    eyeClosed.style.display=isPassword?'block':'none';
});
</script>

</body>
</html>