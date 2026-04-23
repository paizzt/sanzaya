<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Password Baru - Satu Sanzaya</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #0A539B; --light-blue: #3FB6F1; --dark-gray: #333333;   
            --medium-gray: #777777; --border-color: #DDDDDD; --card-bg: rgba(255, 255, 255, 0.95); 
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
        .login-desc { font-size: 13px; color: var(--medium-gray); margin-bottom: 35px; }

        .login-form { text-align: left; }
        .input-group { margin-bottom: 30px; }
        .input-group label { display: block; font-size: 12px; font-weight: 600; color: var(--medium-gray); text-transform: uppercase; margin-bottom: 8px; }
        
        .input-with-icon { position: relative; display: flex; align-items: center; }
        .input-icon-right { position: absolute; right: 18px; color: #CCCCCC; font-size: 16px; cursor: pointer; transition: 0.3s; }
        .input-icon-right:hover { color: var(--medium-gray); }
        
        .input-group input {
            width: 100%; padding: 16px 50px 16px 16px; font-size: 14px;
            border: 1px solid var(--border-color); border-radius: 12px; transition: 0.3s; background-color: #FFFFFF;
        }
        .input-group input:focus { outline: none; border-color: var(--light-blue); box-shadow: 0 0 0 3px rgba(63, 182, 241, 0.1); }

        .btn-login {
            width: 100%; padding: 18px; background-color: var(--primary-blue); color: #FFFFFF;
            border: none; border-radius: 12px; font-size: 16px; font-weight: 600; cursor: pointer; transition: 0.3s;
        }
        .btn-login:hover { background-color: #06407B; }
    </style>
</head>
<body>
    <main class="login-card">
        <img src="{{ asset('img/logo.svg') }}" alt="Logo Sanzaya" class="company-logo-img">
        <h1 class="product-title">Satu Sanzaya</h1>
        <p class="login-desc">Masukkan Password baru anda</p>

        <form action="#" method="POST" class="login-form">
            @csrf
            <div class="input-group">
                <label for="password">PASSWORD BARU</label>
                <div class="input-with-icon">
                    <input type="password" id="password" name="password" required autofocus>
                    <i class="fas fa-eye input-icon-right" id="togglePassword"></i>
                </div>
            </div>
            <button type="submit" class="btn-login">Buat password</button>
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