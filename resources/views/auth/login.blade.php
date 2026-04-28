<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — DOKTERA</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #0F172A;
            overflow: hidden;
        }

        /* Animated background */
        .bg {
            position: fixed;
            inset: 0;
            z-index: 0;
        }
        .bg-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.15;
            animation: float 8s ease-in-out infinite;
        }
        .blob1 { width:500px;height:500px;background:#4F46E5;top:-150px;left:-100px;animation-delay:0s; }
        .blob2 { width:400px;height:400px;background:#F59E0B;bottom:-100px;right:-100px;animation-delay:3s; }
        .blob3 { width:300px;height:300px;background:#10B981;top:50%;left:50%;animation-delay:1.5s; }
        @keyframes float {
            0%,100% { transform: translate(0,0) scale(1); }
            50%      { transform: translate(20px,-20px) scale(1.05); }
        }

        .bg-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
            background-size: 48px 48px;
        }

        /* Left panel */
        .left {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px 70px;
            position: relative;
            z-index: 1;
        }

        .pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(79,70,229,0.2);
            border: 1px solid rgba(99,102,241,0.4);
            color: #A5B4FC;
            padding: 7px 16px;
            border-radius: 30px;
            font-size: 11.5px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 28px;
            width: fit-content;
        }
        .pill-dot {
            width: 6px; height: 6px;
            background: #6366F1;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%,100% { opacity:1;transform:scale(1); }
            50%      { opacity:0.4;transform:scale(0.7); }
        }

        .hero-title {
            font-size: 54px;
            font-weight: 800;
            color: white;
            line-height: 1.05;
            margin-bottom: 18px;
            letter-spacing: -1px;
        }
        .hero-title .accent {
            background: linear-gradient(135deg, #818CF8, #6366F1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero-title .accent2 {
            background: linear-gradient(135deg, #FCD34D, #F59E0B);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-sub {
            font-size: 15px;
            color: rgba(255,255,255,0.5);
            line-height: 1.75;
            max-width: 400px;
            margin-bottom: 44px;
        }

        .feature-list { display: flex; flex-direction: column; gap: 12px; }
        .feat {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255,255,255,0.65);
            font-size: 13.5px;
            font-weight: 500;
        }
        .feat-icon {
            width: 36px; height: 36px;
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }
        .feat-icon.i1 { background: rgba(79,70,229,0.2); color: #818CF8; }
        .feat-icon.i2 { background: rgba(245,158,11,0.2); color: #FCD34D; }
        .feat-icon.i3 { background: rgba(16,185,129,0.2); color: #34D399; }
        .feat-icon.i4 { background: rgba(59,130,246,0.2); color: #60A5FA; }

        /* Right panel */
        .right {
            width: 460px;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 52px 48px;
            position: relative;
            z-index: 1;
        }
        .right::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 4px;
            background: linear-gradient(90deg, #4F46E5, #818CF8, #F59E0B);
        }

        .login-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 32px;
        }
        .login-logo-icon {
            width: 46px; height: 46px;
            background: linear-gradient(135deg, #4F46E5, #6366F1);
            border-radius: 13px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; color: white;
            box-shadow: 0 6px 20px rgba(79,70,229,0.4);
        }
        .login-logo-name { font-size: 20px; font-weight: 800; color: #1E293B; }
        .login-logo-sub  { font-size: 11px; color: #94A3B8; font-weight: 500; }

        .login-title {
            font-size: 26px;
            font-weight: 800;
            color: #1E293B;
            margin-bottom: 6px;
            letter-spacing: -0.3px;
        }
        .login-sub { font-size: 14px; color: #94A3B8; margin-bottom: 32px; }

        .err-box {
            background: #FEF2F2;
            border: 1px solid #FECACA;
            color: #991B1B;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .fgroup { margin-bottom: 18px; }
        .flabel {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: #64748B;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 7px;
        }
        .finput-wrap { position: relative; }
        .finput-icon {
            position: absolute;
            left: 14px; top: 50%;
            transform: translateY(-50%);
            color: #CBD5E1;
            font-size: 14px;
            pointer-events: none;
            transition: color 0.2s;
        }
        .finput {
            width: 100%;
            padding: 12px 14px 12px 42px;
            border: 1.5px solid #E2E8F0;
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1E293B;
            background: #FAFAFE;
            transition: all 0.2s;
        }
        .finput:focus {
            outline: none;
            border-color: #4F46E5;
            background: white;
            box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
        }
        .finput:focus + .finput-icon { color: #4F46E5; }
        .is-invalid { border-color: #EF4444 !important; }

        .remember-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
        }
        .remember-row input { accent-color: #4F46E5; width: 15px; height: 15px; }
        .remember-row label { font-size: 13.5px; color: #64748B; }

        .btn-login {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #4F46E5, #6366F1);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            transition: all 0.2s;
            box-shadow: 0 6px 20px rgba(79,70,229,0.4);
            letter-spacing: 0.2px;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(79,70,229,0.5);
        }

        .login-footer {
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid #F1F5F9;
            text-align: center;
        }
        .login-footer p { font-size: 12.5px; color: #CBD5E1; }
        .login-footer strong { color: #94A3B8; }

        @media (max-width: 900px) {
            .left { display: none; }
            .right { width: 100%; }
        }
    </style>
</head>
<body>

<div class="bg">
    <div class="bg-blob blob1"></div>
    <div class="bg-blob blob2"></div>
    <div class="bg-blob blob3"></div>
    <div class="bg-grid"></div>
</div>

<div class="left">
    <div class="pill">
        <span class="pill-dot"></span>
        Sistem Aktif
    </div>
    <h1 class="hero-title">
        Dokumen<br>
        <span class="accent">Tertata</span><br>
        <span class="accent2">Rapi.</span>
    </h1>
    <p class="hero-sub">
        Kelola seluruh arsip kantor secara digital. 
        Temukan lokasi fisik dokumen kapan saja dengan mudah dan cepat.
    </p>
    <div class="feature-list">
        <div class="feat">
            <div class="feat-icon i1"><i class="fas fa-magnifying-glass"></i></div>
            Pencarian dokumen instan & akurat
        </div>
        <div class="feat">
            <div class="feat-icon i2"><i class="fas fa-cabinet-filing"></i></div>
            Klasifikasi lemari & map ordner
        </div>
        <div class="feat">
            <div class="feat-icon i3"><i class="fas fa-cloud-arrow-up"></i></div>
            Upload & download file digital
        </div>
        <div class="feat">
            <div class="feat-icon i4"><i class="fas fa-map-location-dot"></i></div>
            Pelacakan lokasi fisik dokumen
        </div>
    </div>
</div>

<div class="right">
    <div class="login-logo">
        <div class="login-logo-icon"><i class="fas fa-layer-group"></i></div>
        <div>
            <div class="login-logo-name">DOKTERA</div>
            <div class="login-logo-sub">Sistem Informasi Dokumen</div>
        </div>
    </div>

    <h2 class="login-title">Selamat Datang 👋</h2>
    <p class="login-sub">Masuk ke akun Anda untuk melanjutkan</p>

    @if($errors->any())
    <div class="err-box">
        <i class="fas fa-circle-exclamation"></i>
        {{ $errors->first() }}
    </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="fgroup">
            <label class="flabel">Email</label>
            <div class="finput-wrap">
                <input type="email" name="email" class="finput {{ $errors->has('email') ? 'is-invalid' : '' }}"
                       placeholder="nama@instansi.go.id"
                       value="{{ old('email') }}" required autofocus>
                <i class="fas fa-envelope finput-icon"></i>
            </div>
        </div>

        <div class="fgroup">
            <label class="flabel">Password</label>
            <div class="finput-wrap">
                <input type="password" name="password" class="finput"
                       placeholder="••••••••" required>
                <i class="fas fa-lock finput-icon"></i>
            </div>
        </div>

        <div class="remember-row">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember">Ingat sesi saya</label>
        </div>

        <button type="submit" class="btn-login">
            <i class="fas fa-right-to-bracket"></i>
            Masuk ke Sistem
        </button>
    </form>

    <div class="login-footer">
        <p>Lupa akses? Hubungi <strong>Administrator</strong></p>
        <p style="margin-top:6px;">DOKTERA &copy; {{ date('Y') }}</p>
    </div>
</div>

</body>
</html>
