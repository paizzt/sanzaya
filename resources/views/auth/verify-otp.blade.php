<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - Satu Sanzaya</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #0A539B; 
            --light-blue: #3FB6F1;   
            --dark-gray: #333333;   
            --medium-gray: #777777; 
            --border-color: #DDDDDD; 
            --card-bg: rgba(255, 255, 255, 0.95); 
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

        body {
            display: flex; justify-content: center; align-items: center; min-height: 100vh;
            background-image: url("{{ asset('img/bglogin.png') }}");
            background-size: cover; background-position: center; background-repeat: no-repeat;
            background-attachment: fixed; color: var(--dark-gray);
        }

        .login-card {
            background-color: var(--card-bg); width: 90%; max-width: 450px;
            padding: 50px 40px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            text-align: center; backdrop-filter: blur(8px); 
        }

        .company-logo-img { max-width: 160px; height: auto; margin-bottom: 10px; }
        .company-name { color: var(--dark-gray); font-size: 14px; text-transform: uppercase; font-weight: 600; display: block; margin-bottom: 5px; }
        .product-title { font-size: 28px; font-weight: 700; color: var(--primary-blue); margin-bottom: 8px; }
        .login-desc { font-size: 13px; color: var(--medium-gray); margin-bottom: 30px; }

        .otp-form { text-align: left; }
        .input-label { display: block; font-size: 12px; font-weight: 600; color: var(--medium-gray); text-transform: uppercase; margin-bottom: 10px; text-align: center;}
        
        /* Desain Kotak OTP */
        .otp-container { display: flex; justify-content: center; gap: 15px; margin-bottom: 30px; }
        .otp-input {
            width: 55px; height: 55px; text-align: center; font-size: 24px; font-weight: 600;
            border: 1px solid var(--border-color); border-radius: 12px; background-color: #FFFFFF;
            color: var(--primary-blue); transition: 0.3s;
        }
        .otp-input:focus { outline: none; border-color: var(--light-blue); box-shadow: 0 0 0 3px rgba(63, 182, 241, 0.1); }
        
        /* Sembunyikan panah pada input number */
        .otp-input::-webkit-outer-spin-button, .otp-input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
        
        .btn-login {
            width: 100%; padding: 18px; background-color: var(--primary-blue); color: #FFFFFF;
            border: none; border-radius: 12px; font-size: 16px; font-weight: 600; cursor: pointer; transition: 0.3s;
        }
        .btn-login:hover { background-color: #06407B; }

        .resend-text { margin-top: 25px; font-size: 13px; color: var(--medium-gray); }
        .resend-link { color: var(--primary-blue); font-weight: 600; text-decoration: none; cursor: pointer; }
    </style>
</head>
<body>
    <main class="login-card">
        <img src="{{ asset('img/logo.svg') }}" alt="Logo Sanzaya" class="company-logo-img">
        <h1 class="product-title">Satu Sanzaya</h1>
        <p class="login-desc">Masukkan kode OTP yang dikirim di email anda</p>

        <form action="#" method="POST" class="otp-form">
            @csrf
            <span class="input-label">KODE OTP</span>
            <div class="otp-container">
                <input type="number" class="otp-input" name="otp[]" maxlength="1" required autofocus>
                <input type="number" class="otp-input" name="otp[]" maxlength="1" required>
                <input type="number" class="otp-input" name="otp[]" maxlength="1" required>
                <input type="number" class="otp-input" name="otp[]" maxlength="1" required>
            </div>
            <button type="submit" class="btn-login">Kirim OTP</button>
        </form>

        <div class="resend-text">
            kirim ulang? <span id="countdown">120</span> detik
        </div>
    </main>

    <script>
        const inputs = document.querySelectorAll('.otp-input');
        inputs.forEach((input, index) => {
            input.addEventListener('input', function() {
                if (this.value.length > 1) this.value = this.value.slice(0, 1); // Maksimal 1 digit
                if (this.value !== '' && index < inputs.length - 1) inputs[index + 1].focus();
            });
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && this.value === '' && index > 0) inputs[index - 1].focus();
            });
        });

        // Simulasi Hitung Mundur
        let timeLeft = 120;
        const countdownEl = document.getElementById('countdown');
        const timer = setInterval(() => {
            timeLeft--;
            countdownEl.textContent = timeLeft;
            if (timeLeft <= 0) {
                clearInterval(timer);
                document.querySelector('.resend-text').innerHTML = '<a href="#" class="resend-link">Kirim Ulang Sekarang</a>';
            }
        }, 1000);
    </script>
</body>
</html>