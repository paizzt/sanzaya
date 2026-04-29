<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Satu Sanzaya - PT. SANZAYA MEDIKA PRATAMA</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --primary-blue: #0A539B; /* Biru Tua Tombol Utama */
            --light-blue: #3FB6F1;   /* Biru Muda Aksen Logo */
            --dark-gray: #333333;   /* Warna Teks Utama */
            --medium-gray: #777777; /* Warna Teks Petunjuk */
            --border-color: #DDDDDD; /* Warna Garis Batas Form */
            --card-bg: rgba(255, 255, 255, 0.92); /* Warna Latar Kartu dengan Transparansi */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-image: url("{{ asset('img/bglogin.png') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: var(--dark-gray);
            overflow: hidden; /* Prevent scrolling during animation */
        }

        /* 🌟 AMBIENT ANIMATED BACKGROUND 🌟 */
        .ambient-blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(100px);
            z-index: -1;
            opacity: 0.6;
            animation: floatBlob 12s infinite alternate cubic-bezier(0.45, 0.05, 0.55, 0.95);
            pointer-events: none;
        }
        .blob-1 { 
            top: -10%; left: -10%; 
            width: 60vw; height: 60vw; 
            background: rgba(10, 83, 155, 0.4); 
        }
        .blob-2 { 
            bottom: -10%; right: -10%; 
            width: 50vw; height: 50vw; 
            background: rgba(63, 182, 241, 0.3); 
            animation-delay: -5s; 
        }

        @keyframes floatBlob {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(5vw, 5vw) scale(1.1); }
        }

        /* 🎬 INTRO SPLASH SCREEN (Cinematic Entrance) 🎬 */
        .intro-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            display: flex;
            justify-content: center;
            align-items: center;
            transition: opacity 1s cubic-bezier(0.16, 1, 0.3, 1), transform 1s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .intro-logo {
            max-width: 250px;
            opacity: 0;
            /* Spring Animation - Dari samping kiri, memantul di tengah */
            animation: logoFlyIn 1.5s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        @keyframes logoFlyIn {
            0% { 
                transform: translateX(-80vw) scale(0.7) rotate(-15deg); 
                opacity: 0; 
                filter: blur(20px); 
            }
            100% { 
                transform: translateX(0) scale(1) rotate(0deg); 
                opacity: 1; 
                filter: blur(0) drop-shadow(0 15px 35px rgba(10, 83, 155, 0.4)); 
            }
        }

        /* Transisi Kamera Zoom Out */
        .intro-overlay.fade-out {
            opacity: 0;
            pointer-events: none;
            transform: scale(1.1);
        }
        .intro-overlay.fade-out .intro-logo {
            transform: scale(1.8) translateY(-20px);
            filter: blur(15px);
            opacity: 0;
            transition: all 1s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* 💳 KARTU LOGIN & ANIMASI KONTEN (Stripe/Vercel Vibe) 💳 */
        .login-card {
            background-color: var(--card-bg);
            width: 90%;
            max-width: 450px;
            padding: 50px 40px;
            border-radius: 24px; /* Sedikit lebih membulat untuk kesan modern */
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(255,255,255,0.3) inset;
            text-align: center;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            
            /* State awal sebelum animasi */
            opacity: 0;
            transform: scale(0.92) translateY(30px);
            filter: blur(8px);
        }

        /* Animasi masuk kartu login */
        .login-card.animate-in {
            animation: cardAppear 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes cardAppear {
            0% { opacity: 0; transform: scale(0.92) translateY(30px); filter: blur(8px); }
            100% { opacity: 1; transform: scale(1) translateY(0); filter: blur(0); }
        }

        /* Staggered Children Animation (Elemen muncul berurutan) */
        .login-card.animate-in > * {
            opacity: 0;
            animation: fadeUpItem 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .login-card.animate-in > *:nth-child(1) { animation-delay: 0.1s; } /* Logo */
        .login-card.animate-in > *:nth-child(2) { animation-delay: 0.2s; } /* Judul */
        .login-card.animate-in > *:nth-child(3) { animation-delay: 0.3s; } /* Deskripsi */
        .login-card.animate-in > *:nth-child(4) { animation-delay: 0.4s; } /* Form / Error */
        .login-card.animate-in > *:nth-child(5) { animation-delay: 0.5s; } /* Submit */

        @keyframes fadeUpItem {
            0% { opacity: 0; transform: translateY(15px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* --- STYLING ELEMEN (Sesuai Desain Asli) --- */
        .company-logo-img {
            max-width: 180px;
            height: auto;
            margin-bottom: 15px;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.05));
        }

        .product-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-blue);
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .login-desc {
            font-size: 13px;
            color: var(--medium-gray);
            line-height: 1.6;
            margin-bottom: 35px;
        }

        .login-desc strong {
            color: var(--primary-blue);
            font-weight: 600;
        }

        .alert-error {
            background-color: #fef2f2;
            color: #dc2626;
            padding: 14px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 25px;
            text-align: left;
            border: 1px solid #fecaca;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .login-form {
            text-align: left;
        }

        .input-group {
            margin-bottom: 22px;
        }

        .input-group label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            color: var(--medium-gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            margin-left: 4px;
        }

        .input-with-icon {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon-left {
            position: absolute;
            left: 18px;
            color: #94a3b8;
            font-size: 16px;
            transition: color 0.3s ease;
        }

        .input-icon-right {
            position: absolute;
            right: 18px;
            color: #94a3b8;
            font-size: 16px;
            cursor: pointer;
            transition: color 0.3s ease, transform 0.2s;
        }

        .input-icon-right:hover {
            color: var(--primary-blue);
            transform: scale(1.1);
        }

        .input-group input {
            width: 100%;
            padding: 16px 16px 16px 50px; 
            font-size: 14px;
            font-weight: 500;
            color: var(--dark-gray);
            border: 1.5px solid var(--border-color);
            border-radius: 14px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background-color: rgba(255, 255, 255, 0.8);
        }

        /* Micro-interaction: Focus state modern */
        .input-group input:focus {
            outline: none;
            border-color: var(--light-blue);
            background-color: #FFFFFF;
            box-shadow: 0 0 0 4px rgba(63, 182, 241, 0.15);
        }

        .input-group input:focus + .input-icon-left,
        .input-with-icon:focus-within .input-icon-left {
            color: var(--primary-blue);
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            font-size: 13px;
        }

        .remember-me {
            color: var(--medium-gray);
            cursor: pointer;
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .remember-me input {
            margin-right: 8px;
            width: 16px;
            height: 16px;
            accent-color: var(--primary-blue);
            cursor: pointer;
        }

        .forgot-password {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .forgot-password:hover {
            color: #06407B;
            text-decoration: underline;
        }

        /* 🚀 Tombol Utama Premium 🚀 */
        .btn-login {
            width: 100%;
            padding: 18px;
            background-color: var(--primary-blue);
            color: #FFFFFF;
            border: none;
            border-radius: 14px;
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 0.5px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 10px 20px -5px rgba(10, 83, 155, 0.4);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .btn-login:hover {
            background-color: #06407B;
            transform: translateY(-2px);
            box-shadow: 0 15px 25px -5px rgba(10, 83, 155, 0.5);
        }

        .btn-login:active {
            transform: translateY(1px) scale(0.98);
        }

        /* Efek Kilap (Shine) pada tombol saat dihover */
        .btn-login::after {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 50%; height: 100%;
            background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.2) 50%, rgba(255,255,255,0) 100%);
            transform: skewX(-20deg);
            transition: all 0.6s ease;
        }
        .btn-login:hover::after {
            left: 150%;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 40px 25px;
                border-radius: 20px;
            }
            .company-logo-img { max-width: 140px; }
            .product-title { font-size: 24px; }
            .login-desc { font-size: 12px; margin-bottom: 25px; }
            .intro-logo { max-width: 180px; }
        }
    </style>
</head>
<body>

    <!-- Ambient Lights -->
    <div class="ambient-blob blob-1"></div>
    <div class="ambient-blob blob-2"></div>

    <!-- 🎬 INTRO SPLASH SCREEN 🎬 -->
    <div id="introSplash" class="intro-overlay">
        <img src="{{ asset('img/logo.svg') }}" class="intro-logo" alt="Sanzaya Logo">
    </div>

    <!-- 💳 MAIN LOGIN CARD 💳 -->
    <main class="login-card" id="loginCard">
        
        <img src="{{ asset('img/logo.svg') }}" alt="Logo Sanzaya Medika Pratama" class="company-logo-img">
        
        <h1 class="product-title">Satu Sanzaya</h1>
        <p class="login-desc">Masukan email dan password yang telah di berikan, untuk mengetahuinya silahkan hubungi <strong>HR</strong></p>

        @if ($errors->any())
            <div class="alert-error">
                <i class="fas fa-exclamation-circle text-lg"></i>
                <span>Email atau password yang Anda masukkan salah.</span>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="login-form">
            @csrf

            <div class="input-group">
                <label for="email">EMAIL PERUSAHAAN</label>
                <div class="input-with-icon">
                    <i class="fas fa-user input-icon-left"></i>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@gmail.com" required autocomplete="email">
                </div>
            </div>

            <div class="input-group">
                <label for="password">KATA SANDI</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock input-icon-left"></i>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                    <i class="fas fa-eye input-icon-right" id="togglePassword"></i>
                </div>
            </div>

            <div class="form-options">
                <label class="remember-me">
                    <input type="checkbox" name="remember"> Ingat Saya
                </label>
                <a href="{{ url('/forgot-password') }}" class="forgot-password">Lupa Password?</a>
            </div>

            <button type="submit" class="btn-login" id="btnSubmit">
                Masuk <i class="fas fa-arrow-right text-sm"></i>
            </button>
        </form>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Animasi Timeline Cinematic
            setTimeout(() => {
                const intro = document.getElementById('introSplash');
                const card = document.getElementById('loginCard');
                
                // 1. Kamera Zoom Out (Splash screen menghilang)
                intro.classList.add('fade-out');
                
                // 2. Kartu Login muncul membesar
                setTimeout(() => {
                    card.classList.add('animate-in');
                    // Mengembalikan fungsi scroll setelah animasi selesai
                    document.body.style.overflow = 'auto';
                }, 300); 

                // Hapus elemen intro dari DOM untuk meringankan memori
                setTimeout(() => {
                    intro.remove();
                }, 1500);
                
            }, 1600); // Intro logo bermain selama 1.6 detik sebelum zoom out
        });

        // Fungsionalitas Toggle Mata Password
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
            
            // Efek klik ikon mata
            this.style.transform = 'scale(0.9)';
            setTimeout(() => this.style.transform = 'scale(1.1)', 100);
        });

        // Loading state saat tombol submit ditekan
        document.querySelector('.login-form').addEventListener('submit', function() {
            const btn = document.getElementById('btnSubmit');
            btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Memproses...';
            btn.style.opacity = '0.8';
            btn.style.pointerEvents = 'none';
        });
    </script>
</body>
</html>