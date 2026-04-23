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
            margin-bottom: 8px;
        }

        .input-with-icon {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon-left {
            position: absolute;
            left: 18px;
            color: #CCCCCC;
            font-size: 16px;
        }

        .input-group input {
            width: 100%;
            padding: 16px 16px 16px 50px; 
            font-size: 14px;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            transition: 0.3s;
            background-color: #FFFFFF;
        }

        .input-group input:focus {
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
            transition: 0.3s, transform 0.2s;
            box-shadow: 0 5px 15px rgba(10, 83, 155, 0.2);
        }

        .btn-login:hover {
            background-color: #06407B;
            box-shadow: 0 7px 20px rgba(10, 83, 155, 0.3);
        }

        .btn-login:active {
            transform: translateY(1px);
        }

        /* Tautan Kembali ke Login */
        .back-to-login {
            display: inline-block;
            margin-top: 25px;
            font-size: 13px;
            color: var(--medium-gray);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .back-to-login:hover {
            color: var(--primary-blue);
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 40px 25px;
                border-radius: 15px;
            }
            .product-title {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>

    <main class="login-card">
        
        <img src="{{ asset('img/logo.svg') }}" alt="Logo Sanzaya Medika Pratama" class="company-logo-img">
        
        <span class="company-name">PT. SANZAYA MEDIKA PRATAMA</span>
        <h1 class="product-title">Satu Sanzaya</h1>
        
        <p class="login-desc">Masukkan email Anda untuk dikirimkan kode OTP</p>

        <form action="#" method="POST" class="login-form">
            @csrf

            <div class="input-group">
                <label for="email">EMAIL</label>
                <div class="input-with-icon">
                    <i class="fas fa-user input-icon-left"></i>
                    <input type="email" id="email" name="email" placeholder="nama@gmail.com" required autofocus>
                </div>
            </div>

            <button type="submit" class="btn-login">Kirim OTP</button>
        </form>

        <a href="{{ route('login') }}" class="back-to-login">
            <i class="fas fa-arrow-left"></i> Kembali ke Halaman Login
        </a>

    </main>

</body>
</html>