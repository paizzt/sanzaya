<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Satu Sanzaya</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-blue: #0A539B;
            --light-blue: #E5F0FF;
            --sidebar-bg: #FAFAFA;
            --text-dark: #333333;
            --text-gray: #888888;
            --border-color: #EAEAEA;
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 80px; 
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #FFFFFF;
            margin: 0;
            overflow-x: hidden;
        }

        .wrapper { display: flex; height: 100vh; }

        /* --- SIDEBAR --- */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            position: relative;
            z-index: 100;
            height: 100vh;
        }

        .sidebar.collapsed { width: var(--sidebar-collapsed-width); }

        .logo-area { height: 80px; display: flex; align-items: center; justify-content: center; padding: 20px; transition: 0.3s; }
        .logo-img { max-width: 140px; transition: 0.3s; }
        .sidebar.collapsed .logo-img { max-width: 40px; }

        .sidebar-menu { list-style: none; padding: 20px 10px; margin: 0; flex-grow: 1; }
        .menu-item {
            display: flex; align-items: center; padding: 12px 20px; color: var(--text-gray);
            text-decoration: none; border-radius: 10px; margin-bottom: 5px; transition: 0.2s;
            font-weight: 500; font-size: 14px; white-space: nowrap; overflow: hidden;
        }
        .menu-item:hover { background-color: var(--border-color); color: var(--text-dark); }
        .menu-item.active { background-color: var(--light-blue); color: var(--primary-blue); }
        
        .menu-icon { font-size: 18px; min-width: 30px; text-align: center; }
        .menu-text { margin-left: 15px; transition: opacity 0.2s; }
        .sidebar.collapsed .menu-text { opacity: 0; display: none; }

        .sidebar-footer { padding: 20px; border-top: 1px solid var(--border-color); }
        .btn-create {
            background-color: var(--primary-blue); color: white; border: none; width: 100%;
            padding: 12px; border-radius: 8px; font-weight: 500; display: flex; align-items: center; justify-content: center; gap: 10px; transition: 0.3s;
        }
        .btn-create:hover { background-color: #08427b; color: white; }
        .sidebar.collapsed .sidebar-footer { padding: 20px 10px; }
        .sidebar.collapsed .btn-create span { display: none; }

        /* --- MAIN CONTENT --- */
        .main-content {
            flex-grow: 1; display: flex; flex-direction: column;
            width: calc(100% - var(--sidebar-width)); transition: width 0.3s ease;
        }
        .sidebar.collapsed ~ .main-content { width: calc(100% - var(--sidebar-collapsed-width)); }

        .top-navbar {
            height: 80px; background-color: #FFFFFF; border-bottom: 1px solid var(--border-color);
            display: flex; align-items: center; justify-content: space-between; padding: 0 30px;
        }

        .nav-left { display: flex; align-items: center; gap: 20px; }
        .hamburger-btn { background: none; border: none; font-size: 24px; color: var(--text-dark); cursor: pointer; padding: 0; }
        
        .search-bar { background-color: #F5F7FA; border-radius: 8px; display: flex; align-items: center; padding: 8px 15px; width: 350px; }
        .search-bar input { border: none; background: transparent; outline: none; width: 100%; margin-left: 10px; font-size: 13px; }

        .nav-right { display: flex; align-items: center; gap: 25px; }
        .nav-icon { font-size: 20px; color: var(--text-gray); position: relative; cursor: pointer; }
        .nav-icon .badge-dot { position: absolute; top: -2px; right: -2px; width: 8px; height: 8px; background-color: #ff4757; border-radius: 50%; }

        .user-profile { display: flex; align-items: center; gap: 12px; }
        .user-info { text-align: right; line-height: 1.2; }
        .user-name { font-weight: 600; font-size: 14px; color: var(--text-dark); margin: 0; }
        .user-role { font-size: 11px; color: var(--text-gray); margin: 0; text-transform: lowercase; }
        .user-avatar { font-size: 32px; color: var(--text-dark); }

        .content-area { padding: 30px; background-color: #FFFFFF; flex-grow: 1; overflow-y: auto; }
        .welcome-banner { background-color: var(--light-blue); border-radius: 12px; padding: 25px 30px; border: 1px solid #D1E3FF; }
        .welcome-text { color: var(--primary-blue); font-size: 20px; font-weight: 600; margin: 0; }

        /* --- PENGATURAN RESPONSIF (HP & TABLET) --- */
        .sidebar-overlay {
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.5); z-index: 99; transition: 0.3s;
        }

        @media (max-width: 992px) {
            .search-bar { width: 200px; } 
        }

        @media (max-width: 768px) {
            .sidebar { position: fixed; left: -100%; box-shadow: 4px 0 15px rgba(0,0,0,0.1); }
            .sidebar.mobile-active { left: 0; }
            .sidebar-overlay.active { display: block; }
            .main-content { width: 100%; }
            .sidebar.collapsed ~ .main-content { width: 100%; }
            .search-bar { display: none; }
            .top-navbar { padding: 0 20px; }
            .content-area { padding: 20px; }
            .user-role { display: none; }
            .user-info { margin-top: 5px; }
        }
    </style>
</head>
<body>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="wrapper">
        
        <aside class="sidebar" id="sidebar">
            <div class="logo-area">
                <img src="{{ asset('img/logo.svg') }}" alt="Logo" class="logo-img">
            </div>

            <ul class="sidebar-menu">
                <li><a href="#" class="menu-item active"><i class="fas fa-border-all menu-icon"></i><span class="menu-text">Dashboard</span></a></li>
                <li><a href="{{ route('admin.riwayat.perubahan') }}" class="menu-item"><i class="fas fa-clock-rotate-left menu-icon"></i><span class="menu-text">Riwayat Perubahan</span></a></li>
                <li><a href="{{ route('admin.kelola.data') }}" class="menu-item"><i class="fas fa-users menu-icon"></i><span class="menu-text">Kelola data</span></a></li>
                <li><a href="{{ route('admin.settings') }}" class="menu-item"><i class="fas fa-gear menu-icon"></i><span class="menu-text">Settings</span></a></li>
            </ul>

            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">@csrf</form>
                <a href="#" class="menu-item" style="color: var(--text-gray);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-arrow-right-from-bracket menu-icon"></i><span class="menu-text">Keluar</span>
                </a>
                <button class="btn-create mt-3"><i class="fas fa-plus"></i><span class="menu-text">buat pengajuan</span></button>
            </div>
        </aside>

        <div class="main-content">
            <header class="top-navbar">
                <div class="nav-left">
                    <button class="hamburger-btn" id="toggleSidebar"><i class="fas fa-bars"></i></button>
                    <div class="search-bar"><i class="fas fa-search text-muted"></i><input type="text" placeholder="Search itineraries or requests..."></div>
                </div>

                <div class="nav-right">
                    <div class="nav-icon"><i class="far fa-bell"></i><div class="badge-dot"></div></div>
                    <div class="nav-icon"><i class="far fa-circle-question"></i></div>
                    <div class="user-profile">
                        <div class="user-info">
                            <p class="user-name">{{ Auth::user()->name }}</p>
                            <p class="user-role">admin</p>
                        </div>
                        <i class="fas fa-user-circle user-avatar"></i>
                    </div>
                </div>
            </header>

            <main class="content-area">
                <div class="welcome-banner">
                    <h2 class="welcome-text">Selamat datang admin</h2>
                </div>
            </main>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleSidebar');
        const overlay = document.getElementById('sidebarOverlay');

        toggleBtn.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('mobile-active');
                overlay.classList.toggle('active');
            } else {
                sidebar.classList.toggle('collapsed');
            }
        });

        overlay.addEventListener('click', function() {
            sidebar.classList.remove('mobile-active');
            overlay.classList.remove('active');
        });

        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('mobile-active');
                overlay.classList.remove('active');
            }
        });
    </script>
</body>
</html>