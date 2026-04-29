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
            --primary-blue: #0A539B; 
            --light-blue: #3FB6F1;   
            --dark-gray: #333333;   
            --medium-gray: #777777; 
            --border-color: #DDDDDD; 
            --card-bg: rgba(255, 255, 255, 0.92); 
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

        /* 💳 KARTU OTP & ANIMASI STAGGERED 💳 */
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
            
            /* Card Entrance Animation */
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
        .login-card > *:nth-child(2) { animation-delay: 0.2s; } /* Title */
        .login-card > *:nth-child(3) { animation-delay: 0.3s; } /* Desc */
        .login-card > *:nth-child(4) { animation-delay: 0.4s; } /* Form */
        .login-card > *:nth-child(5) { animation-delay: 0.5s; } /* Resend text */

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
            margin-bottom: 30px; 
            line-height: 1.6;
        }

        .otp-form { text-align: left; }
        .input-label { 
            display: block; 
            font-size: 12px; 
            font-weight: 600; 
            color: var(--medium-gray); 
            text-transform: uppercase; 
            margin-bottom: 12px; 
            text-align: center;
            letter-spacing: 0.5px;
        }
        
        /* Desain Kotak OTP Premium */
        .otp-container { 
            display: flex; 
            justify-content: center; 
            gap: 15px; 
            margin-bottom: 30px; 
        }
        .otp-input {
            width: 55px; 
            height: 60px; 
            text-align: center; 
            font-size: 26px; 
            font-weight: 700;
            border: 1.5px solid var(--border-color); 
            border-radius: 14px; 
            background-color: rgba(255, 255, 255, 0.8);
            color: var(--primary-blue); 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 4px rgba(0,0,0,0.02) inset;
        }
        .otp-input:focus { 
            outline: none; 
            border-color: var(--light-blue); 
            background-color: #FFFFFF;
            box-shadow: 0 0 0 4px rgba(63, 182, 241, 0.15); 
            transform: translateY(-2px);
        }
        
        /* Sembunyikan panah pada input number */
        .otp-input::-webkit-outer-spin-button, 
        .otp-input::-webkit-inner-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
        }
        
        /* Tombol Utama Premium */
        .btn-login {
            width: 100%; 
            padding: 18px; 
            background-color: var(--primary-blue); 
            color: #FFFFFF;
            border: none; 
            border-radius: 14px; 
            font-size: 16px; 
            font-weight: 600; 
            cursor: pointer; 
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 10px 20px -5px rgba(10, 83, 155, 0.4);
            letter-spacing: 0.5px;
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

        .resend-text { 
            margin-top: 25px; 
            font-size: 13px; 
            color: var(--medium-gray); 
        }
        .resend-text span {
            font-weight: 600;
            color: var(--dark-gray);
            font-variant-numeric: tabular-nums;
        }
        .resend-link { 
            color: var(--primary-blue); 
            font-weight: 600; 
            text-decoration: none; 
            cursor: pointer; 
            transition: 0.2s;
        }
        .resend-link:hover {
            color: #06407B;
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .login-card { padding: 40px 25px; border-radius: 20px; }
            .otp-input { width: 50px; height: 55px; font-size: 22px; }
            .product-title { font-size: 24px; }
        }
    </style>
</head>
<body>

    <!-- Ambient Lights -->
    <div class="ambient-blob blob-1"></div>
    <div class="ambient-blob blob-2"></div>

    <main class="login-card">
        <img src="{{ asset('img/logo.svg') }}" alt="Logo Sanzaya" class="company-logo-img">
        <h1 class="product-title">Satu Sanzaya</h1>
        <p class="login-desc">Masukkan kode OTP yang dikirim di email anda</p>

        <form action="#" method="POST" class="otp-form" id="otpForm">
            @csrf
            <span class="input-label">KODE OTP</span>
            <div class="otp-container">
                <input type="number" class="otp-input" name="otp[]" maxlength="1" required autofocus>
                <input type="number" class="otp-input" name="otp[]" maxlength="1" required>
                <input type="number" class="otp-input" name="otp[]" maxlength="1" required>
                <input type="number" class="otp-input" name="otp[]" maxlength="1" required>
            </div>
            <button type="submit" class="btn-login" id="btnSubmit">Kirim OTP</button>
        </form>

        <div class="resend-text" id="resendContainer">
            kirim ulang? <span id="countdown">120</span> detik
        </div>
    </main>

    <script>
        // Logika Perpindahan dan Batasan Input OTP
        const inputs = document.querySelectorAll('.otp-input');
        inputs.forEach((input, index) => {
            input.addEventListener('input', function(e) {
                // Pastikan hanya bisa diisi 1 angka
                if (this.value.length > 1) this.value = this.value.slice(0, 1); 
                
                // Pindah otomatis ke kotak selanjutnya
                if (this.value !== '' && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });
            
            input.addEventListener('keydown', function(e) {
                // Pindah ke kotak sebelumnya jika backspace ditekan saat kotak kosong
                if (e.key === 'Backspace' && this.value === '' && index > 0) {
                    inputs[index - 1].focus();
                }
            });

            // Fitur Paste (Copy-Paste kode langsung masuk ke 4 kotak)
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

        // Simulasi Hitung Mundur (Countdown)
        let timeLeft = 120;
        let timerId;
        const countdownEl = document.getElementById('countdown');
        const resendContainer = document.getElementById('resendContainer');

        function startTimer() {
            timerId = setInterval(() => {
                timeLeft--;
                countdownEl.textContent = timeLeft;
                if (timeLeft <= 0) {
                    clearInterval(timerId);
                    resendContainer.innerHTML = '<a href="#" class="resend-link" onclick="resetTimer()"><i class="fas fa-redo-alt me-1"></i> Kirim Ulang Sekarang</a>';
                }
            }, 1000);
        }

        // Fungsi Reset Timer jika di-klik kirim ulang
        window.resetTimer = function(e) {
            if(e) e.preventDefault();
            timeLeft = 120;
            resendContainer.innerHTML = 'kirim ulang? <span id="countdown">120</span> detik';
            clearInterval(timerId);
            startTimer();
            // *Disini Anda dapat menambahkan logika pemanggilan AJAX untuk resend OTP*
        }

        startTimer();

        // Efek Loading Saat Form Disubmit
        document.getElementById('otpForm').addEventListener('submit', function() {
            const btn = document.getElementById('btnSubmit');
            btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Memverifikasi...';
            btn.style.opacity = '0.8';
            btn.style.pointerEvents = 'none';
        });
    </script>
</body>
</html>