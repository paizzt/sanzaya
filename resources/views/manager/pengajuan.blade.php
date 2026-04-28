<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Form Pengajuan UC Manajer - Satu Sanzaya</title>
    
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
        .nav-right { display: flex; align-items: center; gap: 25px; position: relative; }
        .user-profile { display: flex; align-items: center; gap: 12px; }
        .user-info { text-align: right; line-height: 1.2; }
        .user-name { font-weight: 600; font-size: 14px; color: var(--text-dark); margin: 0; }
        .user-role { font-size: 11px; color: var(--text-gray); margin: 0; text-transform: capitalize; }
        .user-avatar { font-size: 32px; color: var(--primary-blue); }
        .content-area { padding: 30px 40px; flex-grow: 1; overflow-y: auto; }

        /* --- STYLING FORM PENGAJUAN --- */
        .form-card { background: #FFFFFF; border-radius: 16px; border: 1px solid var(--border-color); padding: 35px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); margin-bottom: 25px; }
        .form-title { font-size: 18px; font-weight: 700; color: var(--primary-blue); margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px; }
        .form-subtitle { font-size: 13px; color: var(--text-gray); margin-bottom: 30px; }
        
        .form-label-custom { font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px; display: block; text-transform: uppercase; letter-spacing: 0.5px; }
        .input-custom { width: 100%; border: 1px solid #CBD5E1; border-radius: 10px; padding: 12px 16px; font-size: 14px; color: var(--text-dark); background-color: #F8FAFC; transition: all 0.2s; }
        .input-custom:focus { border-color: var(--primary-blue); box-shadow: 0 0 0 3px rgba(10, 83, 155, 0.1); background-color: #FFFFFF; outline: none; }
        .input-custom:disabled, .input-custom[readonly] { background-color: #E2E8F0; cursor: not-allowed; color: #64748B; font-weight: 500; }
        
        .btn-submit { background-color: var(--primary-blue); color: white; border: none; border-radius: 10px; padding: 14px 30px; font-size: 15px; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(10,83,155,0.2); width: 100%; display: flex; justify-content: center; align-items: center; gap: 10px; }
        .btn-submit:hover { background-color: #08427b; transform: translateY(-2px); box-shadow: 0 6px 12px rgba(10,83,155,0.3); color: white; }

        .info-box { background-color: #FFFBEB; border-left: 4px solid #D97706; padding: 15px 20px; border-radius: 0 10px 10px 0; margin-bottom: 30px; }
        .info-box h6 { color: #B45309; font-weight: 700; margin-bottom: 5px; font-size: 14px; }
        .info-box p { color: #92400E; font-size: 12px; margin: 0; }

        /* Custom Checkbox/Radio */
        .transport-options { display: flex; gap: 20px; }
        .transport-label { display: flex; align-items: center; gap: 8px; font-size: 14px; color: var(--text-dark); cursor: pointer; }
        .transport-label input[type="radio"] { width: 18px; height: 18px; cursor: pointer; accent-color: var(--primary-blue); }

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
        .notif-manager { background-color: #FFFBEB; color: #D97706; }
        
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
            .transport-options { flex-direction: column; gap: 10px; }
        }
    </style>
</head>
<body>

    <!-- MENGAMBIL DATA PEGAWAI & NOTIFIKASI MANAJER -->
    @php
        // Mengambil semua user kecuali manajer yang sedang login
        $usersList = \App\Models\User::where('id', '!=', Auth::id())
                        ->orderBy('name', 'asc')
                        ->get();

        // Logika Notifikasi khusus Manajer (Melihat SPPD yang pending_l1)
        $notifications = \App\Models\TravelRequest::with('user')
            ->where('status', 'pending_l1')
            ->latest()
            ->take(5)
            ->get();
        $hasNewNotif = $notifications->count() > 0;
    @endphp

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="wrapper">
        
        <!-- SIDEBAR MANAGER -->
        <aside class="sidebar" id="sidebar">
            <div class="logo-area">
                <a href="{{ route('manager.dashboard') ?? '#' }}">
                    <img src="{{ asset('img/logo.svg') }}" alt="Logo" class="logo-img">
                </a>
            </div>

            <ul class="sidebar-menu">
                <li><a href="{{ route('manager.dashboard') ?? '#' }}" class="menu-item"><i class="fas fa-border-all menu-icon"></i><span class="menu-text">Dashboard</span></a></li>
                <li><a href="{{ route('approvals.index') ?? '#' }}" class="menu-item"><i class="fas fa-file-signature menu-icon"></i><span class="menu-text">Persetujuan SPPD</span></a></li>
                <li><a href="{{ route('manager.history') ?? '#' }}" class="menu-item"><i class="fas fa-history menu-icon"></i><span class="menu-text">Riwayat Proses</span></a></li>
                <li><a href="{{ route('arsip.index') ?? '#' }}" class="menu-item"><i class="fas fa-archive menu-icon"></i><span class="menu-text">Arsip UC</span></a></li>
                <li><a href="{{ route('manager.pengajuan.create') ?? '#' }}" class="menu-item active"><i class="fas fa-paper-plane menu-icon"></i><span class="menu-text">Buat Pengajuan</span></a></li>
                <li><a href="{{ route('manager.settings') ?? '#' }}" class="menu-item"><i class="fas fa-gear menu-icon"></i><span class="menu-text">Settings</span></a></li>
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
                    <h5 class="mb-0 fw-bold ms-3 d-none d-md-block">Form Pengajuan UC (Manajer)</h5>
                </div>
                <div class="nav-right">

                    <!-- AREA NOTIFIKASI -->
                    <div class="nav-icon" id="notificationToggle">
                        <i class="far fa-bell" style="font-size: 20px;"></i>
                        <div class="badge-dot {{ $hasNewNotif ? 'active' : '' }}"></div>
                        
                        <!-- DROPDOWN NOTIFIKASI MANAJER -->
                        <div class="notification-dropdown" id="notificationDropdown">
                            <div class="notification-header">
                                Notifikasi Terkini
                            </div>
                            <ul class="notification-list">
                                @forelse($notifications as $notif)
                                    <li class="notification-item" onclick="window.location.href='{{ route('approvals.show', $notif->id) }}'" style="cursor: pointer;">
                                        <div class="notification-icon notif-manager"><i class="fas fa-file-signature"></i></div>
                                        <div class="notification-content">
                                            <p>Pengajuan UC baru dari <strong>{{ $notif->user->name ?? 'Staff' }}</strong> ({{ $notif->destination }}) menunggu persetujuan Anda.</p>
                                            <span>{{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}</span>
                                        </div>
                                    </li>
                                @empty
                                    <li class="notification-item"><div class="notification-content"><p class="text-muted text-center w-100">Tidak ada pengajuan baru yang menunggu persetujuan.</p></div></li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    <!-- END AREA NOTIFIKASI -->

                    <div class="user-profile">
                        <div class="user-info">
                            <p class="user-name">{{ Auth::user()->name ?? 'Nama Manajer' }}</p>
                            <p class="user-role">{{ Auth::user()->role ?? 'manager' }}</p>
                        </div>
                        <i class="fas fa-user-circle user-avatar"></i>
                    </div>
                </div>
            </header>

            <main class="content-area">
                
                <div class="row justify-content-center">
                    <div class="col-xl-9 col-lg-10">
                        
                        <div class="info-box">
                            <h6><i class="fas fa-rocket me-2"></i> Jalur Langsung (Fast-Track)</h6>
                            <p>Sebagai Manajer, pengajuan SPPD (UC) yang Anda buat akan <strong>langsung diteruskan ke divisi Keuangan/Finance (Level 2)</strong> untuk proses pencairan dana, tanpa memerlukan persetujuan L1 lagi.</p>
                        </div>

                        <div class="form-card">
                            <h4 class="form-title">Form Pengajuan Biaya</h4>
                            <p class="form-subtitle">Perjalanan Dinas Upcountry (UC)</p>
                            
                            <!-- Alert Error Validasi -->
                            @if($errors->any())
                            <div class="alert alert-danger" style="border-radius: 10px; font-size: 13px;">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <form action="{{ route('manager.pengajuan.store') }}" method="POST" id="pengajuanForm">
                                @csrf
                                <!-- Penanda bahwa yang mengajukan adalah Manajer agar backend bisa melakukan ByPass L1 -->
                                <input type="hidden" name="direct_to_finance" value="1">
                                
                                <div class="row g-4">
                                    <!-- Identitas Pemohon -->
                                    <div class="col-md-6">
                                        <label class="form-label-custom">1. Nama Pegawai</label>
                                        <input type="text" class="input-custom" value="{{ Auth::user()->name ?? '' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-custom">2. Jabatan / Divisi</label>
                                        <input type="text" class="input-custom" value="{{ ucfirst(Auth::user()->role ?? '') }} {{ Auth::user()->division ?? '' }}" readonly>
                                    </div>

                                    <!-- Keberangkatan & Tujuan -->
                                    <div class="col-md-6">
                                        <label class="form-label-custom">3. Kota Keberangkatan <span class="text-danger">*</span></label>
                                        <input type="text" name="departure" class="input-custom" placeholder="Contoh: Makassar..." required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-custom">4. Kota Tujuan <span class="text-danger">*</span></label>
                                        <input type="text" name="destination" class="input-custom" placeholder="Contoh: Pinrang, Parepare..." required>
                                    </div>

                                    <!-- Tanggal Berangkat & Pulang -->
                                    <div class="col-md-4">
                                        <label class="form-label-custom">5. Tanggal Berangkat <span class="text-danger">*</span></label>
                                        <input type="date" name="start_date" id="start_date" class="input-custom" required onchange="calculateDays()">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label-custom">6. Tanggal Pulang <span class="text-danger">*</span></label>
                                        <input type="date" name="end_date" id="end_date" class="input-custom" required onchange="calculateDays()">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label-custom">7. Estimasi Waktu (Hari)</label>
                                        <input type="text" id="waktu_hari" class="input-custom fw-bold" placeholder="0 Hari" readonly style="color: var(--primary-blue);">
                                    </div>

                                    <!-- Pendamping (Dropdown Data User) -->
                                    <div class="col-md-12">
                                        <label class="form-label-custom">8. Nama Pendamping (Opsional)</label>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <select name="companion_1" class="form-select input-custom">
                                                    <option value="">-- Pilih Pendamping 1 --</option>
                                                    @foreach($usersList as $u)
                                                        <option value="{{ $u->name }} - {{ ucfirst($u->role) }} {{ $u->division }}">
                                                            {{ $u->name }} ({{ ucfirst($u->role) }} {{ $u->division }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <select name="companion_2" class="form-select input-custom">
                                                    <option value="">-- Pilih Pendamping 2 --</option>
                                                    @foreach($usersList as $u)
                                                        <option value="{{ $u->name }} - {{ ucfirst($u->role) }} {{ $u->division }}">
                                                            {{ $u->name }} ({{ ucfirst($u->role) }} {{ $u->division }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Transportasi -->
                                    <div class="col-md-6">
                                        <label class="form-label-custom">9. Jenis Transportasi <span class="text-danger">*</span></label>
                                        <div class="transport-options mt-2">
                                            <label class="transport-label">
                                                <input type="radio" name="transportation_type" value="Darat" required checked> Darat
                                            </label>
                                            <label class="transport-label">
                                                <input type="radio" name="transportation_type" value="Laut"> Laut
                                            </label>
                                            <label class="transport-label">
                                                <input type="radio" name="transportation_type" value="Udara"> Udara
                                            </label>
                                        </div>
                                    </div>

                                    <!-- No Polisi -->
                                    <div class="col-md-6" id="no_polisi_div">
                                        <label class="form-label-custom">10. No. Polisi Kendaraan (Opsional)</label>
                                        <input type="text" name="vehicle_number" id="vehicle_number" class="input-custom" placeholder="Contoh: DD 1234 XY">
                                        <small class="text-muted" style="font-size: 11px;">Isi jika menggunakan kendaraan operasional/pribadi (Darat).</small>
                                    </div>
                                </div>

                                <div class="mt-5 pt-4 border-top">
                                    <p class="text-muted small mb-4 fst-italic">Demikian surat tugas ini saya buat sebenar-benarnya untuk diteruskan kepada Keuangan.</p>
                                    
                                    <button type="submit" class="btn-submit" id="btnSubmit">
                                        <i class="fas fa-paper-plane"></i> Ajukan ke Finance
                                    </button>
                                </div>

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

        // --- KALKULATOR HARI OTOMATIS ---
        function calculateDays() {
            const startInput = document.getElementById('start_date').value;
            const endInput = document.getElementById('end_date').value;
            const hariInput = document.getElementById('waktu_hari');

            if (startInput && endInput) {
                const startDate = new Date(startInput);
                const endDate = new Date(endInput);

                // Validasi agar tanggal pulang tidak sebelum tanggal berangkat
                if (endDate < startDate) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Tanggal Tidak Valid',
                        text: 'Tanggal pulang tidak boleh mendahului tanggal keberangkatan!',
                    });
                    document.getElementById('end_date').value = '';
                    hariInput.value = '';
                    return;
                }

                // Hitung selisih waktu dalam milidetik
                const diffTime = Math.abs(endDate - startDate);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; 
                
                hariInput.value = diffDays + ' Hari';
            }
        }

        // --- HIDE/SHOW NOMOR POLISI ---
        document.querySelectorAll('input[name="transportation_type"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const noPolisiDiv = document.getElementById('no_polisi_div');
                const noPolisiInput = document.getElementById('vehicle_number');
                if(this.value === 'Darat') {
                    noPolisiDiv.style.display = 'block';
                } else {
                    noPolisiDiv.style.display = 'none';
                    noPolisiInput.value = ''; 
                }
            });
        });

        // --- KONFIRMASI SEBELUM SUBMIT ---
        document.getElementById('pengajuanForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('btnSubmit');
            if(btn.classList.contains('disabled')) {
                e.preventDefault();
                return;
            }
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sedang Mengirim...';
            btn.classList.add('disabled');
        });
    </script>
</body>
</html>