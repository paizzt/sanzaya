<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - Satu Sanzaya</title>
    
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
            overflow: hidden;
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

        /* 💳 KARTU OTP & ANIMASI KONTEN 💳 */
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
        .login-card > *:nth-child(5) { animation-delay: 0.5s; } /* Form */
        .login-card > *:nth-child(6) { animation-delay: 0.6s; } /* Timer */

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
            margin-bottom: 30px;
        }

        .login-form {
            text-align: left;
        }

        .label-otp {
            font-size: 12px;
            font-weight: 600;
            color: var(--medium-gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
            margin-left: 4px;
            display: block;
            text-align: center;
        }

        /* --- DESAIN PREMIUM 4 KOTAK OTP --- */
        .otp-container {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 35px;
        }

        .otp-box {
            width: 60px;
            height: 65px;
            text-align: center;
            font-size: 26px;
            font-weight: 700;
            color: var(--primary-blue);
            border: 1.5px solid var(--border-color);
            border-radius: 14px;
            background-color: rgba(255, 255, 255, 0.8);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 4px rgba(0,0,0,0.02) inset;
        }

        .otp-box:focus {
            outline: none;
            border-color: var(--light-blue);
            background-color: #FFFFFF;
            box-shadow: 0 0 0 4px rgba(63, 182, 241, 0.15);
            transform: translateY(-2px);
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

        /* --- TIMER --- */
        .resend-timer {
            margin-top: 25px;
            font-size: 13px;
            color: var(--medium-gray);
            display: block;
        }

        .resend-timer span {
            font-weight: 600;
            color: var(--dark-gray);
            font-variant-numeric: tabular-nums;
        }

        .resend-link {
            color: var(--primary-blue);
            font-weight: 600;
            text-decoration: none;
            display: none; /* Disembunyikan sampai timer habis */
            transition: 0.2s;
            cursor: pointer;
        }

        .resend-link:hover {
            color: #06407B;
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 40px 25px;
                border-radius: 20px;
            }
            .product-title {
                font-size: 24px;
            }
            .otp-box { 
                width: 50px;
                height: 55px; 
                font-size: 22px; 
            }
        }
    </style>
</head>
<body>

    <!-- Ambient Lights -->
    <div class="ambient-blob blob-1"></div>
    <div class="ambient-blob blob-2"></div>

    <main class="login-card">
        
        <img src="{{ asset('img/logo.svg') }}" alt="Logo Sanzaya" class="company-logo-img">
        
        <span class="company-name">PT. SANZAYA MEDIKA PRATAMA</span>
        <h1 class="product-title">Satu Sanzaya</h1>
        
        <p class="login-desc">Masukkan kode OTP 4 digit yang telah dikirim ke alamat email Anda.</p>

        <form action="#" method="POST" class="login-form">
            @csrf
            
            <label class="label-otp">KODE OTP</label>
            <div class="otp-container">
                <input type="text" name="otp[]" class="otp-box" maxlength="1" pattern="[0-9]*" inputmode="numeric" required autofocus>
                <input type="text" name="otp[]" class="otp-box" maxlength="1" pattern="[0-9]*" inputmode="numeric" required>
                <input type="text" name="otp[]" class="otp-box" maxlength="1" pattern="[0-9]*" inputmode="numeric" required>
                <input type="text" name="otp[]" class="otp-box" maxlength="1" pattern="[0-9]*" inputmode="numeric" required>
            </div>

            <button type="submit" class="btn-login" id="btnSubmit">
                Verifikasi OTP <i class="fas fa-shield-alt text-sm"></i>
            </button>
        </form>

        <div class="resend-timer" id="timerContainer">
            Belum menerima kode? Kirim ulang dalam <span id="timer">120</span> detik
        </div>
        <a class="resend-link" id="resendLink" onclick="resetTimer()">
            <i class="fas fa-redo-alt me-1"></i> Kirim Ulang Kode OTP
        </a>

    </main>

    <script>
        // --- LOGIKA KOTAK OTP YANG MULUS ---
        const inputs = document.querySelectorAll('.otp-box');
        
        inputs.forEach((input, index) => {
            // Membatasi hanya angka
            input.addEventListener('input', (e) => {
                e.target.value = e.target.value.replace(/[^0-9]/g, '');
                
                // Pindah ke kotak berikutnya jika diisi
                if(e.target.value !== '' && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });
            
            // Pindah ke kotak sebelumnya jika backspace ditekan dan kotak kosong
            input.addEventListener('keydown', (e) => {
                if(e.key === 'Backspace' && e.target.value === '' && index > 0) {
                    inputs[index - 1].focus();
                }
            });

            // Fitur Paste (Tempel) otomatis mengisi 4 kotak
            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pastedData = e.clipboardData.getData('text').replace(/[^0-9]/g, '').slice(0, inputs.length);
                if (pastedData) {
                    pastedData.split('').forEach((char, i) => {
                        if (inputs[i]) {
                            inputs[i].value = char;
                            if (i < inputs.length - 1) inputs[i + 1].focus();
                        }
                    });
                }
            });
        });

        // --- LOGIKA LOADING SUBMIT ---
        document.querySelector('.login-form').addEventListener('submit', function() {
            const btn = document.getElementById('btnSubmit');
            btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Memverifikasi...';
            btn.style.opacity = '0.8';
            btn.style.pointerEvents = 'none';
        });

        // --- LOGIKA COUNTDOWN TIMER ---
        let timeLeft = 120; // 2 Menit
        let timerId;
        const timerDisplay = document.getElementById('timer');
        const timerContainer = document.getElementById('timerContainer');
        const resendLink = document.getElementById('resendLink');

        function startTimer() {
            timerId = setInterval(() => {
                timeLeft--;
                timerDisplay.textContent = timeLeft;
                
                if (timeLeft <= 0) {
                    clearInterval(timerId);
                    timerContainer.style.display = 'none';
                    resendLink.style.display = 'inline-block';
                }
            }, 1000);
        }

        // Fungsi untuk reset timer jika menekan tombol Kirim Ulang
        window.resetTimer = function() {
            timeLeft = 120;
            timerDisplay.textContent = timeLeft;
            timerContainer.style.display = 'block';
            resendLink.style.display = 'none';
            clearInterval(timerId);
            startTimer();
            // Disini Anda bisa tambahkan logika AJAX untuk hit ulang API OTP
        };

        // Mulai timer saat halaman selesai dimuat
        startTimer();
    </script>
</body>
</html>