<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pengaturan Akun Finance - Satu Sanzaya</title>
    
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

        body { font-family: 'Poppins', sans-serif; background-color: #F8F9FA; margin: 0; overflow-x: hidden; }
        .wrapper { display: flex; height: 100vh; }

        /* --- SIDEBAR KONSISTEN --- */
        .sidebar { width: var(--sidebar-width); background-color: var(--sidebar-bg); border-right: 1px solid var(--border-color); display: flex; flex-direction: column; transition: all 0.3s ease; position: relative; z-index: 100; height: 100vh; }
        .sidebar.collapsed { width: var(--sidebar-collapsed-width); }
        .logo-area { height: 80px; display: flex; align-items: center; justify-content: center; padding: 20px; transition: 0.3s; }
        .logo-img { max-width: 140px; transition: 0.3s; }
        .sidebar.collapsed .logo-img { max-width: 40px; }
        .sidebar-menu { list-style: none; padding: 20px 10px; margin: 0; flex-grow: 1; }
        .menu-item { display: flex; align-items: center; padding: 12px 20px; color: var(--text-gray); text-decoration: none; border-radius: 10px; margin-bottom: 5px; transition: 0.2s; font-weight: 500; font-size: 14px; white-space: nowrap; overflow: hidden; }
        .menu-item:hover { background-color: var(--border-color); color: var(--text-dark); }
        .menu-item.active { background-color: var(--light-blue); color: var(--primary-blue); font-weight: 600;}
        .menu-icon { font-size: 18px; min-width: 30px; text-align: center; }
        .menu-text { margin-left: 15px; transition: opacity 0.2s; }
        .sidebar.collapsed .menu-text { opacity: 0; display: none; }
        .sidebar-footer { padding: 20px; border-top: 1px solid var(--border-color); }

        /* --- MAIN CONTENT & NAVBAR --- */
        .main-content { flex-grow: 1; display: flex; flex-direction: column; width: calc(100% - var(--sidebar-width)); transition: width 0.3s ease; }
        .sidebar.collapsed ~ .main-content { width: calc(100% - var(--sidebar-collapsed-width)); }
        .top-navbar { height: 80px; background-color: #FFFFFF; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; padding: 0 30px; }
        .nav-left { display: flex; align-items: center; gap: 20px; }
        .hamburger-btn { background: none; border: none; font-size: 24px; color: var(--text-dark); cursor: pointer; padding: 0; }
        .nav-right { display: flex; align-items: center; gap: 25px; position: relative; } /* Ditambah relative */
        .user-profile { display: flex; align-items: center; gap: 12px; }
        .user-info { text-align: right; line-height: 1.2; }
        .user-name { font-weight: 600; font-size: 14px; color: var(--text-dark); margin: 0; }
        .user-role { font-size: 11px; color: var(--text-gray); margin: 0; text-transform: capitalize; }
        .user-avatar { font-size: 32px; color: var(--primary-blue); }
        .content-area { padding: 30px 40px; flex-grow: 1; overflow-y: auto; }

        /* --- STYLING HALAMAN SETTINGS --- */
        .settings-card { background: #FFFFFF; border-radius: 16px; border: 1px solid var(--border-color); padding: 35px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); margin-bottom: 25px; }
        .settings-title { font-size: 16px; font-weight: 700; color: var(--text-dark); margin-bottom: 25px; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid var(--border-color); padding-bottom: 15px; }
        .settings-title i { color: var(--primary-blue); }
        
        .form-label-custom { font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px; display: block; text-transform: uppercase; letter-spacing: 0.5px; }
        .input-custom { width: 100%; border: 1px solid #CBD5E1; border-radius: 10px; padding: 12px 16px; font-size: 14px; color: var(--text-dark); font-weight: 500; background-color: #F8FAFC; transition: all 0.2s; outline: none; }
        .input-custom:focus { border-color: var(--primary-blue); box-shadow: 0 0 0 3px rgba(10, 83, 155, 0.1); background-color: #FFFFFF; }
        .input-custom:disabled { background-color: #E2E8F0; cursor: not-allowed; color: #94A3B8; }
        
        .btn-save { background-color: var(--primary-blue); color: white; border: none; border-radius: 10px; padding: 12px 25px; font-size: 14px; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(10,83,155,0.2); }
        .btn-save:hover { background-color: #08427b; transform: translateY(-2px); box-shadow: 0 6px 12px rgba(10,83,155,0.3); color: white; }

        /* Profile Avatar Besar */
        .avatar-upload { display: flex; align-items: center; gap: 20px; margin-bottom: 30px; }
        .avatar-lg { width: 80px; height: 80px; border-radius: 50%; background-color: var(--light-blue); color: var(--primary-blue); display: flex; align-items: center; justify-content: center; font-size: 36px; font-weight: 700; }
        .btn-outline-custom { border: 1px solid var(--border-color); background: white; color: var(--text-dark); padding: 8px 15px; border-radius: 8px; font-size: 13px; font-weight: 500; cursor: pointer; transition: 0.2s; }
        .btn-outline-custom:hover { background: #F8F9FA; border-color: #CCC; }

        /* --- NOTIFIKASI DROPDOWN --- */
        .nav-icon { position: relative; cursor: pointer; }
        .badge-dot { position: absolute; top: 0; right: 0; width: 8px; height: 8px; background-color: #EF4444; border-radius: 50%; display: none; }
        .badge-dot.active { display: block; }
        
        .notification-dropdown {
            position: absolute;
            top: 60px;
            right: 0;
            width: 320px;
            background: #FFFFFF;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border: 1px solid var(--border-color);
            display: none;
            z-index: 1000;
            overflow: hidden;
        }
        .notification-dropdown.show { display: block; }
        .notification-header {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border-color);
            font-weight: 600;
            color: var(--text-dark);
            background-color: #FAFAFA;
        }
        .notification-list {
            max-height: 300px;
            overflow-y: auto;
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .notification-item {
            padding: 15px 20px;
            border-bottom: 1px solid #F1F5F9;
            display: flex;
            align-items: start;
            gap: 15px;
            transition: background-color 0.2s;
        }
        .notification-item:hover { background-color: #F8FAFC; }
        .notification-item:last-child { border-bottom: none; }
        .notification-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }
        .notif-finance { background-color: #ECFDF5; color: #10B981; }
        
        .notification-content p { margin: 0; font-size: 13px; color: var(--text-dark); line-height: 1.4; }
        .notification-content span { font-size: 11px; color: var(--text-gray); }

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

    <!-- MENGAMBIL DATA NOTIFIKASI OTOMATIS -->
    @php
        $userId = \Illuminate\Support\Facades\Auth::id();
        
        // Logika Notifikasi khusus Finance (Melihat SPPD yang pending_l2)
        $notifications = \App\Models\TravelRequest::with('user')
            ->where('status', 'pending_l2')
            ->latest()
            ->take(5)
            ->get();
        $hasNewNotif = $notifications->count() > 0;
    @endphp

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="wrapper">
        
        <!-- SIDEBAR FINANCE -->
        <aside class="sidebar" id="sidebar">
            <div class="logo-area">
                <a href="{{ route('finance.dashboard') ?? '#' }}">
                    <img src="{{ asset('img/logo.svg') }}" alt="Logo" class="logo-img">
                </a>
            </div>

            <ul class="sidebar-menu">
                <li><a href="{{ route('finance.dashboard') ?? '#' }}" class="menu-item"><i class="fas fa-border-all menu-icon"></i><span class="menu-text">Dashboard</span></a></li>
                <li><a href="{{ route('approvals.index') ?? '#' }}" class="menu-item"><i class="fas fa-file-invoice-dollar menu-icon"></i><span class="menu-text">Antrean Pencairan</span></a></li>
                <li><a href="{{ route('finance.history') ?? '#' }}" class="menu-item"><i class="fas fa-history menu-icon"></i><span class="menu-text">Riwayat Pencairan</span></a></li>
                <li><a href="{{ route('arsip.index') ?? '#' }}" class="menu-item"><i class="fas fa-archive menu-icon"></i><span class="menu-text">Arsip UC</span></a></li>
                <li><a href="{{ route('finance.settings') ?? '#' }}" class="menu-item active"><i class="fas fa-gear menu-icon"></i><span class="menu-text">Settings</span></a></li>
            </ul>

            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">@csrf</form>
                <a href="#" class="menu-item" style="color: var(--text-gray);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-arrow-right-from-bracket menu-icon"></i><span class="menu-text">Keluar</span>
                </a>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="main-content">
            <header class="top-navbar">
                <div class="nav-left">
                    <button class="hamburger-btn" id="toggleSidebar"><i class="fas fa-bars"></i></button>
                    <h5 class="mb-0 fw-bold ms-3 d-none d-md-block">Pengaturan Akun Finance</h5>
                </div>
                <div class="nav-right">
                    
                    <!-- AREA NOTIFIKASI -->
                    <div class="nav-icon" id="notificationToggle">
                        <i class="far fa-bell" style="font-size: 20px;"></i>
                        <div class="badge-dot {{ $hasNewNotif ? 'active' : '' }}"></div>
                        
                        <!-- DROPDOWN NOTIFIKASI FINANCE -->
                        <div class="notification-dropdown" id="notificationDropdown">
                            <div class="notification-header">
                                Notifikasi Terkini
                            </div>
                            <ul class="notification-list">
                                @forelse($notifications as $notif)
                                    <li class="notification-item" onclick="window.location.href='{{ route('approvals.show', $notif->id) }}'" style="cursor: pointer;">
                                        <div class="notification-icon notif-finance"><i class="fas fa-file-invoice-dollar"></i></div>
                                        <div class="notification-content">
                                            <p>Pengajuan UC <strong>{{ $notif->user->name ?? 'Staff' }}</strong> ({{ $notif->destination }}) telah disetujui Manajer dan menunggu pencairan dana.</p>
                                            <span>{{ \Carbon\Carbon::parse($notif->updated_at)->diffForHumans() }}</span>
                                        </div>
                                    </li>
                                @empty
                                    <li class="notification-item"><div class="notification-content"><p class="text-muted text-center w-100">Tidak ada dokumen untuk dicairkan.</p></div></li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    <!-- END AREA NOTIFIKASI -->

                    <div class="user-profile">
                        <div class="user-info">
                            <p class="user-name">{{ Auth::user()->name ?? 'Nama Finance' }}</p>
                            <p class="user-role">{{ Auth::user()->role ?? 'finance' }}</p>
                        </div>
                        <i class="fas fa-user-circle user-avatar"></i>
                    </div>
                </div>
            </header>

            <main class="content-area">

                <!-- Alert jika ada pesan sukses dari backend -->
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" style="border-radius: 12px; border: none; background-color: #ECFDF5; color: #065F46;" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                
                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" style="border-radius: 12px; border: none; background-color: #FEF2F2; color: #991B1B;" role="alert">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="row g-4">
                    <!-- BAGIAN 1: PROFIL PRIBADI -->
                    <div class="col-xl-8">
                        <div class="settings-card h-100">
                            <h5 class="settings-title"><i class="far fa-user"></i> Informasi Profil Finance</h5>
                            
                            <div class="avatar-upload">
                                <div class="avatar-lg">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'F', 0, 1)) }}
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">{{ Auth::user()->name ?? 'Tim Keuangan' }}</h6>
                                    <p class="text-muted small mb-2">{{ Auth::user()->email ?? 'finance@sanzaya.com' }}</p>
                                    <button class="btn-outline-custom"><i class="fas fa-camera me-1"></i> Ubah Foto</button>
                                </div>
                            </div>

                            <form id="profileForm" onsubmit="event.preventDefault(); saveProfile();">
                                
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Nama Lengkap</label>
                                        <input type="text" name="name" class="input-custom" value="{{ Auth::user()->name ?? '' }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Email Perusahaan</label>
                                        <input type="email" name="email" class="input-custom" value="{{ Auth::user()->email ?? '' }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Nomor Handphone</label>
                                        <input type="text" name="phone" class="input-custom" value="{{ Auth::user()->phone ?? '' }}" placeholder="08xxx">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Divisi / Departemen</label>
                                        <input type="text" class="input-custom" value="{{ Auth::user()->division ?? 'Finance' }}" disabled>
                                        <small class="text-muted" style="font-size: 10px;">Hubungi Admin Sistem jika ada perubahan divisi.</small>
                                    </div>
                                </div>

                                <div class="mt-4 pt-3 text-end">
                                    <button type="submit" class="btn-save"><i class="fas fa-save me-2"></i> Simpan Perubahan Profil</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- BAGIAN 2: KEAMANAN & PASSWORD -->
                    <div class="col-xl-4">
                        <div class="settings-card h-100">
                            <h5 class="settings-title"><i class="fas fa-shield-alt"></i> Keamanan Sandi</h5>
                            <p class="text-muted small mb-4">Pastikan Anda menggunakan kata sandi yang kuat dan rahasia untuk menjaga keamanan persetujuan keuangan Anda.</p>

                            <form id="passwordForm" onsubmit="event.preventDefault(); savePassword();">
                                
                                <div class="mb-3">
                                    <label class="form-label-custom">Password Saat Ini</label>
                                    <div class="input-group">
                                        <input type="password" name="current_password" id="current_password" class="form-control input-custom" style="border-radius: 10px 0 0 10px;" required>
                                        <button class="btn btn-light border" style="border-color: #CBD5E1 !important; border-radius: 0 10px 10px 0;" type="button" onclick="togglePassword('current_password', this)">
                                            <i class="far fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label-custom">Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" name="new_password" id="new_password" class="form-control input-custom" style="border-radius: 10px 0 0 10px;" required>
                                        <button class="btn btn-light border" style="border-color: #CBD5E1 !important; border-radius: 0 10px 10px 0;" type="button" onclick="togglePassword('new_password', this)">
                                            <i class="far fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label-custom">Konfirmasi Password Baru</label>
                                    <input type="password" name="new_password_confirmation" class="input-custom" required>
                                </div>

                                <button type="submit" class="btn-save w-100"><i class="fas fa-key me-2"></i> Perbarui Password</button>
                            </form>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // --- LOGIKA NOTIFIKASI DROPDOWN ---
        const notificationToggle = document.getElementById('notificationToggle');
        const notificationDropdown = document.getElementById('notificationDropdown');
        const badgeDot = document.querySelector('.badge-dot');

        if(notificationToggle) {
            notificationToggle.addEventListener('click', function(event) {
                event.stopPropagation(); // Mencegah klik menyebar ke window
                notificationDropdown.classList.toggle('show');
                // Jika dropdown dibuka, sembunyikan titik merah
                if(notificationDropdown.classList.contains('show') && badgeDot) {
                    badgeDot.classList.remove('active');
                }
            });

            // Tutup dropdown jika klik di luar area
            window.addEventListener('click', function(event) {
                if (!notificationToggle.contains(event.target)) {
                    notificationDropdown.classList.remove('show');
                }
            });
        }

        // --- LOGIKA RESPONSIVE SIDEBAR ---
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

        // --- FUNGSI LIHAT/SEMBUNYIKAN PASSWORD ---
        function togglePassword(inputId, btnElement) {
            const input = document.getElementById(inputId);
            const icon = btnElement.querySelector('i');
            
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // --- SIMULASI SIMPAN PROFIL ---
        function saveProfile() {
            Swal.fire({
                icon: 'success',
                title: 'Profil Diperbarui!',
                text: 'Perubahan data profil Finance berhasil disimpan.',
                confirmButtonColor: '#0A539B'
            });
        }

        // --- SIMULASI SIMPAN PASSWORD ---
        function savePassword() {
            let form = document.getElementById('passwordForm');
            let pass = document.getElementById('new_password').value;
            let conf = document.getElementsByName('new_password_confirmation')[0].value;

            if(pass !== conf) {
                Swal.fire({ icon: 'error', title: 'Oops...', text: 'Password baru dan konfirmasi tidak cocok!' });
                return;
            }

            Swal.fire({
                icon: 'success',
                title: 'Password Diubah!',
                text: 'Kata sandi Finance berhasil diperbarui. Silakan gunakan password baru pada login berikutnya.',
                confirmButtonColor: '#0A539B'
            }).then(() => {
                form.reset();
            });
        }
    </script>
</body>
</html>