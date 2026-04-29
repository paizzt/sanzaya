<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Satu Sanzaya</title>
    
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

        /* 💳 KARTU LOGIN & ANIMASI KONTEN 💳 */
        .login-card {
            background-color: var(--card-bg);
            width: 90%;
            max-width: 450px;
            padding: 50px 40px;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(255,255,255,0.3) inset;
            text-align: center;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            
            /* Animasi Masuk saat dimuat */
            opacity: 0;
            animation: cardAppear 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes cardAppear {
            0% { opacity: 0; transform: scale(0.95) translateY(20px); filter: blur(4px); }
            100% { opacity: 1; transform: scale(1) translateY(0); filter: blur(0); }
        }

        /* Staggered Children Animation */
        .login-card > * {
            opacity: 0;
            animation: fadeUpItem 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .login-card > *:nth-child(1) { animation-delay: 0.1s; } /* Logo */
        .login-card > *:nth-child(2) { animation-delay: 0.2s; } /* Company Name */
        .login-card > *:nth-child(3) { animation-delay: 0.3s; } /* Title */
        .login-card > *:nth-child(4) { animation-delay: 0.4s; } /* Desc */
        .login-card > *:nth-child(5) { animation-delay: 0.5s; } /* Form / Error */
        .login-card > *:nth-child(6) { animation-delay: 0.6s; } /* Back link */

        @keyframes fadeUpItem {
            0% { opacity: 0; transform: translateY(15px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* --- STYLING ELEMEN --- */
        .company-logo-img {
            max-width: 160px; 
            height: auto;
            margin-bottom: 10px;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.05));
        }

        .company-name {
            color: var(--dark-gray);
            font-size: 14px;
            text-transform: uppercase;
            font-weight: 600;
            display: block;
            margin-bottom: 5px;
        }

        .product-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-blue);
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }

        .login-desc {
            font-size: 13px;
            color: var(--medium-gray);
            line-height: 1.6;
            margin-bottom: 35px;
        }

        .login-form {
            text-align: left;
        }

        .input-group {
            margin-bottom: 30px;
        }

        .input-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
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

        /* Tautan Kembali ke Login */
        .back-to-login {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 25px;
            font-size: 13px;
            color: var(--medium-gray);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s, transform 0.2s;
        }

        .back-to-login:hover {
            color: var(--primary-blue);
            transform: translateX(-3px);
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 40px 25px;
                border-radius: 20px;
            }
            .product-title {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>

    <!-- Ambient Lights -->
    <div class="ambient-blob blob-1"></div>
    <div class="ambient-blob blob-2"></div>

    <!-- 💳 MAIN CARD 💳 -->
    <main class="login-card" id="loginCard">
        
        <img src="{{ asset('img/logo.svg') }}" alt="Logo Sanzaya Medika Pratama" class="company-logo-img">
        
        <span class="company-name"></span>
        <h1 class="product-title">Satu Sanzaya</h1>
        
        <p class="login-desc">Masukkan email Anda untuk dikirimkan kode OTP</p>

        <form action="#" method="POST" class="login-form">
            @csrf

            <div class="input-group">
                <label for="email">EMAIL</label>
                <div class="input-with-icon">
                    <i class="fas fa-user input-icon-left"></i>
                    <input type="email" id="email" name="email" placeholder="nama@gmail.com" required autocomplete="email" autofocus>
                </div>
            </div>

            <button type="submit" class="btn-login" id="btnSubmit">
                Kirim OTP <i class="fas fa-paper-plane text-sm"></i>
            </button>
        </form>

        <a href="{{ route('login') }}" class="back-to-login">
            <i class="fas fa-arrow-left"></i> Kembali ke Halaman Login
        </a>

    </main>

    <script>
        // Loading state saat tombol submit ditekan
        document.querySelector('.login-form').addEventListener('submit', function() {
            const btn = document.getElementById('btnSubmit');
            btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Mengirim...';
            btn.style.opacity = '0.8';
            btn.style.pointerEvents = 'none';
        });
    </script>
</body>
</html>