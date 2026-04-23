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

        .login-card {
            background-color: var(--card-bg);
            width: 90%;
            max-width: 450px;
            padding: 50px 40px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            text-align: center;
            backdrop-filter: blur(8px); 
        }

        .company-logo-img {
            max-width: 160px; 
            height: auto;
            margin-bottom: 10px;
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
        }

        .login-desc {
            font-size: 13px;
            color: var(--medium-gray);
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
            margin-bottom: 10px;
            display: block;
        }

        /* Desain Khusus 4 Kotak OTP */
        .otp-container {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 30px;
        }

        .otp-box {
            width: 100%;
            height: 55px;
            text-align: center;
            font-size: 24px;
            font-weight: 600;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            background-color: #FFFFFF;
            transition: 0.3s;
            color: var(--dark-gray);
        }

        .otp-box:focus {
            outline: none;
            border-color: var(--light-blue);
            box-shadow: 0 0 0 3px rgba(63, 182, 241, 0.1);
        }

        .btn-login {
            width: 100%;
            padding: 18px;
            background-color: var(--primary-blue);
            color: #FFFFFF;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-login:hover {
            background-color: #06407B;
        }

        .resend-timer {
            margin-top: 20px;
            font-size: 13px;
            color: var(--medium-gray);
            display: block;
        }

        @media (max-width: 480px) {
            .login-card { padding: 40px 25px; border-radius: 15px; }
            .otp-box { height: 50px; font-size: 20px; }
        }
    </style>
</head>
<body>

    <main class="login-card">
        <img src="{{ asset('img/logo.svg') }}" alt="Logo Sanzaya" class="company-logo-img">
        <span class="company-name">PT. SANZAYA MEDIKA PRATAMA</span>
        <h1 class="product-title">Satu Sanzaya</h1>
        <p class="login-desc">Masukkan kode OTP yang dikirim di email anda</p>

        <form action="#" method="POST" class="login-form">
            @csrf
            <label class="label-otp">KODE OTP</label>
            <div class="otp-container">
                <input type="text" name="otp[]" class="otp-box" maxlength="1" required autofocus>
                <input type="text" name="otp[]" class="otp-box" maxlength="1" required>
                <input type="text" name="otp[]" class="otp-box" maxlength="1" required>
                <input type="text" name="otp[]" class="otp-box" maxlength="1" required>
            </div>

            <button type="submit" class="btn-login">Kirim OTP</button>
        </form>

        <span class="resend-timer">kirim ulang? <span id="timer">120</span> detik</span>
    </main>

    <script>
        const inputs = document.querySelectorAll('.otp-box');
        inputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if(e.target.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });
            input.addEventListener('keydown', (e) => {
                if(e.key === 'Backspace' && e.target.value.length === 0 && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });
    </script>
</body>
</html>