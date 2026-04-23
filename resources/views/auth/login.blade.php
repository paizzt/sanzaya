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
            --card-bg: rgba(255, 255, 255, 0.95); /* Warna Latar Kartu dengan Transparansi */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif; /* Terapkan Poppins ke semua elemen */
        }

        /* 👇 PERUBAHAN DI SINI: Memanggil latar belakang bglogin.png 👇 */
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
            backdrop-filter: blur(8px); /* Efek blur modern di belakang form */
        }

        /* 👇 PERUBAHAN DI SINI: Pengaturan untuk Logo Gambar 👇 */
        .company-logo-img {
            max-width: 200px; /* Sesuaikan ukuran logo */
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
            margin-bottom: 12px;
        }

        .login-desc {
            font-size: 13px;
            color: var(--medium-gray);
            line-height: 1.6;
            margin-bottom: 30px;
        }

        /* Penggunaan strong untuk penekanan bersih, tanpa emotikon */
        .login-desc strong {
            color: var(--primary-blue);
            font-weight: 600;
        }

        /* Pesan Error Laravel yang Modern */
        .alert-error {
            background-color: #fee2e2;
            color: #dc2626;
            padding: 12px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
            text-align: left;
            border: 1px solid #fca5a5;
        }

        .login-form {
            text-align: left;
        }

        .input-group {
            margin-bottom: 20px;
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

        /* Ikon Mata (Fungsionalitas Toggle Password) */
        .input-icon-right {
            position: absolute;
            right: 18px;
            color: #CCCCCC;
            font-size: 16px;
            cursor: pointer;
            transition: color 0.3s;
        }

        .input-icon-right:hover {
            color: var(--medium-gray);
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
        }

        .remember-me input {
            margin-right: 8px;
            accent-color: var(--primary-blue); /* Warna kotak centang */
        }

        .forgot-password {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 600;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        /* Tombol Utama yang Modern */
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
            transition: 0.3s, transform 0.2s, box-shadow 0.3s;
            box-shadow: 0 5px 15px rgba(10, 83, 155, 0.2);
        }

        .btn-login:hover {
            background-color: #06407B;
            box-shadow: 0 7px 20px rgba(10, 83, 155, 0.3);
        }

        .btn-login:active {
            transform: translateY(1px);
        }

        /* Penyesuaian Responsif untuk Layar HP */
        @media (max-width: 480px) {
            .login-card {
                padding: 40px 25px;
                border-radius: 15px;
            }
            .company-logo-img {
                max-width: 130px;
            }
            .product-title {
                font-size: 24px;
            }
            .login-desc {
                font-size: 12px;
                margin-bottom: 25px;
            }
        }
    </style>
</head>
<body>

    <main class="login-card">
        
        <img src="{{ asset('img/logo.svg') }}" alt="Logo Sanzaya Medika Pratama" class="company-logo-img">
        
        <h1 class="product-title">Satu Sanzaya</h1>
        <p class="login-desc">Masukan email dan password yang telah di berikan untuk mengetahuinya silahkan hubungi <strong>HR</strong></p>

        @if ($errors->any())
            <div class="alert-error">
                Email atau password yang Anda masukkan salah.
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="login-form">
            @csrf

            <div class="input-group">
                <label for="email">EMAIL</label>
                <div class="input-with-icon">
                    <i class="fas fa-user input-icon-left"></i>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@gmail.com" required autofocus>
                </div>
            </div>

            <div class="input-group">
                <label for="password">PASSWORD</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock input-icon-left"></i>
                    <input type="password" id="password" name="password" placeholder="********" required>
                    <i class="fas fa-eye input-icon-right" id="togglePassword"></i>
                </div>
            </div>

            <div class="form-options">
                <label class="remember-me">
                    <input type="checkbox" name="remember"> Ingat Saya
                </label>
                <a href="{{ url('/forgot-password') }}" class="forgot-password">Lupa Password?</a>
            </div>

            <button type="submit" class="btn-login">Masuk</button>
        </form>
    </main>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>