<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Staff - Satu Sanzaya</title>
    
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

        body { font-family: 'Poppins', sans-serif; background-color: #FFFFFF; margin: 0; overflow-x: hidden; }
        .wrapper { display: flex; height: 100vh; }

        /* --- SIDEBAR --- */
        .sidebar { width: var(--sidebar-width); background-color: var(--sidebar-bg); border-right: 1px solid var(--border-color); display: flex; flex-direction: column; transition: all 0.3s ease; position: relative; z-index: 100; height: 100vh; }
        .sidebar.collapsed { width: var(--sidebar-collapsed-width); }
        .logo-area { height: 80px; display: flex; align-items: center; justify-content: center; padding: 20px; transition: 0.3s; }
        .logo-img { max-width: 140px; transition: 0.3s; }
        .sidebar.collapsed .logo-img { max-width: 40px; }
        .sidebar-menu { list-style: none; padding: 20px 10px; margin: 0; flex-grow: 1; }
        .menu-item { display: flex; align-items: center; padding: 12px 20px; color: var(--text-gray); text-decoration: none; border-radius: 10px; margin-bottom: 5px; transition: 0.2s; font-weight: 500; font-size: 14px; white-space: nowrap; overflow: hidden; }
        .menu-item:hover { background-color: var(--border-color); color: var(--text-dark); }
        .menu-item.active { background-color: var(--light-blue); color: var(--primary-blue); }
        .menu-icon { font-size: 18px; min-width: 30px; text-align: center; }
        .menu-text { margin-left: 15px; transition: opacity 0.2s; }
        .sidebar.collapsed .menu-text { opacity: 0; display: none; }
        .sidebar-footer { padding: 20px; border-top: 1px solid var(--border-color); }
        .btn-create { background-color: var(--primary-blue); color: white; border: none; width: 100%; padding: 12px; border-radius: 8px; font-weight: 500; display: flex; align-items: center; justify-content: center; gap: 10px; transition: 0.3s; }
        .btn-create:hover { background-color: #08427b; color: white; }
        .sidebar.collapsed .sidebar-footer { padding: 20px 10px; }
        .sidebar.collapsed .btn-create span { display: none; }

        /* --- MAIN CONTENT --- */
        .main-content { flex-grow: 1; display: flex; flex-direction: column; width: calc(100% - var(--sidebar-width)); transition: width 0.3s ease; }
        .sidebar.collapsed ~ .main-content { width: calc(100% - var(--sidebar-collapsed-width)); }
        .top-navbar { height: 80px; background-color: #FFFFFF; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; padding: 0 30px; }
        .nav-left { display: flex; align-items: center; gap: 20px; }
        .hamburger-btn { background: none; border: none; font-size: 24px; color: var(--text-dark); cursor: pointer; padding: 0; }
        .nav-right { display: flex; align-items: center; gap: 25px; }
        .user-profile { display: flex; align-items: center; gap: 12px; }
        .user-info { text-align: right; line-height: 1.2; }
        .user-name { font-weight: 600; font-size: 14px; color: var(--text-dark); margin: 0; }
        .user-role { font-size: 11px; color: var(--text-gray); margin: 0; text-transform: lowercase; }
        .user-avatar { font-size: 32px; color: var(--text-dark); }
        .content-area { padding: 30px; background-color: #FFFFFF; flex-grow: 1; overflow-y: auto; }

        /* --- STYLING SETTINGS --- */
        .settings-card { background: #FFFFFF; border-radius: 12px; border: 1px solid var(--border-color); padding: 30px; margin-bottom: 25px; }
        .settings-title { font-size: 18px; font-weight: 600; color: var(--text-dark); margin-bottom: 25px; border-bottom: 1px solid var(--border-color); padding-bottom: 15px; }
        
        .form-label { font-size: 13px; font-weight: 600; color: var(--text-gray); text-transform: uppercase; margin-bottom: 8px; }
        .form-control { border-radius: 8px; border: 1px solid var(--border-color); padding: 12px 15px; font-size: 14px; background-color: #FAFAFA; }
        .form-control:focus { background-color: #FFFFFF; border-color: var(--light-blue); box-shadow: 0 0 0 3px rgba(10, 83, 155, 0.1); }
        .form-control:disabled { background-color: #F0F0F0; cursor: not-allowed; }

        .btn-primary-custom { background-color: var(--primary-blue); color: white; border: none; padding: 12px 25px; border-radius: 8px; font-weight: 500; font-size: 14px; transition: 0.3s; }
        .btn-primary-custom:hover { background-color: #08427b; color: white; transform: translateY(-2px); box-shadow: 0 4px 10px rgba(10, 83, 155, 0.2); }

        /* Profil Avatar Upload */
        .avatar-upload { display: flex; align-items: center; gap: 20px; margin-bottom: 30px; }
        .avatar-preview { width: 80px; height: 80px; border-radius: 50%; background-color: var(--light-blue); display: flex; align-items: center; justify-content: center; font-size: 35px; color: var(--primary-blue); border: 2px solid var(--primary-blue); }
        .btn-outline-custom { border: 1px solid var(--border-color); background: white; color: var(--text-dark); padding: 8px 15px; border-radius: 8px; font-size: 13px; font-weight: 500; cursor: pointer; transition: 0.2s; }
        .btn-outline-custom:hover { background: #F8F9FA; border-color: #CCC; }

        /* --- RESPONSIVE --- */
        .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 99; transition: 0.3s; }
        @media (max-width: 768px) {
            .sidebar { position: fixed; left: -100%; box-shadow: 4px 0 15px rgba(0,0,0,0.1); }
            .sidebar.mobile-active { left: 0; }
            .sidebar-overlay.active { display: block; }
            .main-content, .sidebar.collapsed ~ .main-content { width: 100%; }
            .top-navbar { padding: 0 20px; }
            .content-area { padding: 20px; }
            .user-role { display: none; }
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
                <li><a href="{{ route('staff.dashboard') ?? '#' }}" class="menu-item"><i class="fas fa-border-all menu-icon"></i><span class="menu-text">Dashboard</span></a></li>
                <li><a href="#" class="menu-item"><i class="fas fa-clock-rotate-left menu-icon"></i><span class="menu-text">Riwayat Pengajuan</span></a></li>
                <li><a href="#" class="menu-item"><i class="fas fa-file-lines menu-icon"></i><span class="menu-text">Pengajuan SPPD</span></a></li>
                <li><a href="{{ route('staff.settings') ?? '#' }}" class="menu-item active"><i class="fas fa-gear menu-icon"></i><span class="menu-text">Settings</span></a></li>
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
                    <h5 class="mb-0 fw-bold ms-3">Pengaturan Profil</h5>
                </div>
                <div class="nav-right">
                    <div class="nav-icon"><i class="far fa-bell"></i><div class="badge-dot"></div></div>
                    <div class="nav-icon"><i class="far fa-circle-question"></i></div>
                    <div class="user-profile">
                        <div class="user-info">
                            <p class="user-name">{{ Auth::user()->name ?? 'Staff Name' }}</p>
                            <p class="user-role">{{ Auth::user()->role ?? 'staff' }}</p>
                        </div>
                        <i class="fas fa-user-circle user-avatar"></i>
                    </div>
                </div>
            </header>

            <main class="content-area">
                
                <div class="row">
                    <div class="col-lg-8">
                        <div class="settings-card">
                            <h4 class="settings-title"><i class="far fa-user me-2"></i> Profil Anda</h4>
                            
                            <div class="avatar-upload">
                                <div class="avatar-preview">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">{{ Auth::user()->name ?? 'Nama Pengguna' }}</h6>
                                    <p class="text-muted small mb-2">{{ Auth::user()->email ?? 'email@sanzaya.com' }}</p>
                                    <button class="btn-outline-custom">Ubah Foto</button>
                                </div>
                            </div>

                            <form action="#" method="POST">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" name="name" value="{{ Auth::user()->name ?? '' }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" value="{{ Auth::user()->email ?? '' }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">No. Handphone</label>
                                        <input type="text" class="form-control" name="phone" value="{{ Auth::user()->phone ?? '' }}" placeholder="08xxx">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Divisi / Departemen</label>
                                        <input type="text" class="form-control" value="{{ Auth::user()->division ?? 'Operasional' }}" disabled>
                                        <small class="text-muted">Hubungi HRD jika ada perubahan divisi.</small>
                                    </div>
                                    <div class="col-12 mt-4 text-end">
                                        <button type="submit" class="btn-primary-custom">Simpan Perubahan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="settings-card">
                            <h4 class="settings-title"><i class="fas fa-shield-alt me-2"></i> Keamanan</h4>
                            
                            <form action="#" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Password Lama</label>
                                    <input type="password" class="form-control" name="current_password" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password Baru</label>
                                    <input type="password" class="form-control" name="new_password" required>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control" name="new_password_confirmation" required>
                                </div>
                                <button type="submit" class="btn-primary-custom w-100">Perbarui Password</button>
                            </form>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        document.getElementById('toggleSidebar').addEventListener('click', function() {
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
    </script>
</body>
</html>