<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pengajuan SPPD - Satu Sanzaya</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-blue: #0A539B;
            --light-blue: #E5F0FF;
            --form-bg: #F0F5FF; 
            --sidebar-bg: #FAFAFA;
            --text-dark: #1E293B;
            --text-gray: #64748B;
            --border-color: #E2E8F0;
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 80px; 
        }

        body { font-family: 'Poppins', sans-serif; background-color: #F8FAFC; margin: 0; overflow-x: hidden; }
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
        .menu-item.active { background-color: var(--light-blue); color: var(--primary-blue); font-weight: 600; }
        .menu-icon { font-size: 18px; min-width: 30px; text-align: center; }
        .menu-text { margin-left: 15px; transition: opacity 0.2s; }
        .sidebar.collapsed .menu-text { opacity: 0; display: none; }
        .sidebar-footer { padding: 20px; border-top: 1px solid var(--border-color); }

        /* --- MAIN CONTENT --- */
        .main-content { flex-grow: 1; display: flex; flex-direction: column; width: calc(100% - var(--sidebar-width)); transition: width 0.3s ease; }
        .sidebar.collapsed ~ .main-content { width: calc(100% - var(--sidebar-collapsed-width)); }
        .top-navbar { height: 80px; background-color: #FFFFFF; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; padding: 0 30px; z-index: 10; }
        .nav-left { display: flex; align-items: center; gap: 20px; }
        .hamburger-btn { background: none; border: none; font-size: 24px; color: var(--text-dark); cursor: pointer; padding: 0; transition: 0.2s; }
        .hamburger-btn:hover { color: var(--primary-blue); }
        .nav-right { display: flex; align-items: center; gap: 25px; }
        .user-profile { display: flex; align-items: center; gap: 12px; }
        .user-info { text-align: right; line-height: 1.2; }
        .user-name { font-weight: 600; font-size: 14px; color: var(--text-dark); margin: 0; }
        .user-role { font-size: 11px; color: var(--text-gray); margin: 0; text-transform: capitalize; }
        .user-avatar { font-size: 32px; color: var(--primary-blue); }
        .content-area { padding: 30px 40px; flex-grow: 1; overflow-y: auto; }

        /* --- FORM PENGAJUAN AREA --- */
        .form-card { background-color: var(--form-bg); border-radius: 20px; padding: 40px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); border: 1px solid #E0E7FF; }
        .section-title { font-size: 14px; font-weight: 700; color: var(--primary-blue); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 25px; display: flex; align-items: center; gap: 10px; }
        .section-title::after { content: ''; flex-grow: 1; height: 1px; background-color: #CBD5E1; }
        
        .input-custom { width: 100%; border: 1px solid transparent; border-radius: 10px; padding: 12px 16px; font-size: 14px; color: var(--text-dark); font-weight: 500; background-color: #FFFFFF; transition: all 0.2s; outline: none; }
        .input-custom:focus { border-color: var(--primary-blue); box-shadow: 0 0 0 3px rgba(10, 83, 155, 0.1); }
        .input-custom::placeholder { color: #94A3B8; font-weight: 400; }
        .input-custom:disabled, .input-custom[readonly] { background-color: #E2E8F0; color: #64748B; cursor: not-allowed; }
        
        .form-label-custom { font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px; display: block; }
        
        /* Custom Radio */
        .transport-options { display: flex; gap: 20px; margin-top: 10px; }
        .transport-label { display: flex; align-items: center; gap: 8px; font-size: 14px; color: var(--text-dark); cursor: pointer; font-weight: 500; }
        .transport-label input[type="radio"] { width: 18px; height: 18px; cursor: pointer; accent-color: var(--primary-blue); }

        /* Tombol Submit Modern */
        .btn-submit-form { background-color: var(--primary-blue); color: #FFFFFF; border: none; border-radius: 14px; padding: 16px; width: 100%; font-size: 16px; font-weight: 600; margin-top: 40px; transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(10, 83, 155, 0.2); display: flex; justify-content: center; align-items: center; gap: 10px; }
        .btn-submit-form:hover { background-color: #08427b; transform: translateY(-2px); box-shadow: 0 8px 15px rgba(10, 83, 155, 0.3); }

        /* Alert Info */
        .info-box { background-color: #EFF6FF; border-left: 4px solid #3B82F6; padding: 15px 20px; border-radius: 0 10px 10px 0; margin-bottom: 30px; }
        .info-box p { color: #1E3A8A; font-size: 13px; margin: 0; font-weight: 500; }

        /* Responsive */
        .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 99; transition: 0.3s; }
        @media (max-width: 768px) {
            .sidebar { position: fixed; left: -100%; box-shadow: 4px 0 15px rgba(0,0,0,0.1); }
            .sidebar.mobile-active { left: 0; }
            .sidebar-overlay.active { display: block; }
            .main-content { width: 100%; }
            .content-area { padding: 20px; }
            .form-card { padding: 25px; }
            .transport-options { flex-direction: column; gap: 10px; }
        }
    </style>
</head>
<body>

    <!-- MENGAMBIL DATA UNTUK KEBUTUHAN FORM -->
    @php
        // Mengambil daftar user kecuali user yang login untuk dropdown pendamping
        $usersList = \App\Models\User::where('id', '!=', Auth::id())->orderBy('name', 'asc')->get();
    @endphp

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="wrapper">
        
        <!-- SIDEBAR -->
        <aside class="sidebar" id="sidebar">
            <div class="logo-area">
                <a href="{{ route('staff.dashboard') ?? '#' }}">
                    <img src="{{ asset('img/logo.svg') }}" alt="Logo" class="logo-img">
                </a>
            </div>

            <ul class="sidebar-menu">
                <li><a href="{{ route('staff.dashboard') ?? '#' }}" class="menu-item"><i class="fas fa-border-all menu-icon"></i><span class="menu-text">Dashboard</span></a></li>
                <li><a href="{{ route('staff.riwayat') ?? '#' }}" class="menu-item"><i class="fas fa-clock-rotate-left menu-icon"></i><span class="menu-text">Riwayat Pengajuan</span></a></li>
                <li><a href="{{ route('staff.pengajuan.create') ?? '#' }}" class="menu-item active"><i class="fas fa-file-lines menu-icon"></i><span class="menu-text">Pengajuan UC</span></a></li>
                <li><a href="{{ route('staff.settings') ?? '#' }}" class="menu-item"><i class="fas fa-gear menu-icon"></i><span class="menu-text">Settings</span></a></li>
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
                    <h5 class="mb-0 fw-bold ms-3 d-none d-md-block">Form Pengajuan UC Baru</h5>
                </div>
                <div class="nav-right">
                    <div class="user-profile">
                        <div class="user-info">
                            <p class="user-name">{{ Auth::user()->name ?? 'Nama Staff' }}</p>
                            <p class="user-role">{{ Auth::user()->role ?? 'staff' }}</p>
                        </div>
                        <i class="fas fa-user-circle user-avatar"></i>
                    </div>
                </div>
            </header>

            <main class="content-area">
                
                <div class="row justify-content-center">
                    <div class="col-xl-8 col-lg-10">

                        <div class="info-box">
                            <p><i class="fas fa-info-circle me-2"></i> Isi formulir di bawah ini dengan cermat. Pengajuan akan diteruskan ke Manajer Anda untuk persetujuan (Level 1) sebelum diproses oleh Keuangan (Level 2).</p>
                        </div>

                        <div class="form-card">
                            
                            <!-- Tampilkan Error Validasi Jika Ada -->
                            @if($errors->any())
                            <div class="alert alert-danger" style="border-radius: 10px; font-size: 13px;">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <form action="{{ route('staff.pengajuan.store') }}" method="POST" id="pengajuanForm">
                                @csrf
                                
                                <div class="section-title"><i class="fas fa-user me-2"></i> Identitas Pemohon</div>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Nama Pegawai</label>
                                        <input type="text" class="input-custom" value="{{ Auth::user()->name ?? '' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Jabatan / Divisi</label>
                                        <input type="text" class="input-custom" value="{{ ucfirst(Auth::user()->role ?? '') }} {{ Auth::user()->division ?? '' }}" readonly>
                                    </div>
                                </div>

                                <div class="section-title"><i class="fas fa-map-marked-alt me-2"></i> Rute & Jadwal Perjalanan</div>
                                <div class="row g-3 mb-4">
                                    <!-- Keberangkatan & Tujuan (Input Tunggal, Tidak Pakai Array) -->
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Kota Keberangkatan <span class="text-danger">*</span></label>
                                        <input type="text" name="departure" class="input-custom" placeholder="Contoh: Makassar..." required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Kota Tujuan <span class="text-danger">*</span></label>
                                        <input type="text" name="destination" class="input-custom" placeholder="Contoh: Bantaeng..." required>
                                    </div>

                                    <!-- Tanggal Berangkat & Pulang -->
                                    <div class="col-md-4">
                                        <label class="form-label-custom">Tanggal Keberangkatan <span class="text-danger">*</span></label>
                                        <input type="date" name="start_date" id="start_date" class="input-custom" required onchange="calculateDays()">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label-custom">Tanggal Kepulangan <span class="text-danger">*</span></label>
                                        <input type="date" name="end_date" id="end_date" class="input-custom" required onchange="calculateDays()">
                                    </div>
                                    
                                    <!-- Field Kalkulator Hari Otomatis -->
                                    <div class="col-md-4">
                                        <label class="form-label-custom">Estimasi Waktu (Hari)</label>
                                        <input type="text" id="waktu_hari" class="input-custom fw-bold" placeholder="0 Hari" readonly style="color: var(--primary-blue);">
                                    </div>
                                </div>

                                <div class="section-title"><i class="fas fa-users me-2"></i> Pendamping (Opsional)</div>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Nama Pendamping 1</label>
                                        <select name="companion_1" class="form-select input-custom">
                                            <option value="">-- Tidak Ada --</option>
                                            @foreach($usersList as $u)
                                                <option value="{{ $u->name }} - {{ ucfirst($u->role) }} {{ $u->division }}">
                                                    {{ $u->name }} ({{ ucfirst($u->role) }} {{ $u->division }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Nama Pendamping 2</label>
                                        <select name="companion_2" class="form-select input-custom">
                                            <option value="">-- Tidak Ada --</option>
                                            @foreach($usersList as $u)
                                                <option value="{{ $u->name }} - {{ ucfirst($u->role) }} {{ $u->division }}">
                                                    {{ $u->name }} ({{ ucfirst($u->role) }} {{ $u->division }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="section-title"><i class="fas fa-car me-2"></i> Transportasi & Operasional</div>
                                <div class="row g-3 mb-2">
                                    <div class="col-md-6">
                                        <label class="form-label-custom">Jenis Transportasi Utama <span class="text-danger">*</span></label>
                                        <div class="transport-options">
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

                                    <!-- Muncul otomatis jika transport darat dipilih -->
                                    <div class="col-md-6" id="no_polisi_div">
                                        <label class="form-label-custom">No. Polisi Kendaraan (Jika Darat)</label>
                                        <input type="text" name="vehicle_number" id="vehicle_number" class="input-custom" placeholder="Contoh: DD 1234 XY">
                                    </div>
                                    
                                    <!-- TAMBAHAN INPUT BENSIN -->
                                    <div class="col-md-12 mt-4">
                                        <label class="form-label-custom text-primary"><i class="fas fa-gas-pump me-2"></i>Estimasi Biaya Bensin (Manual)</label>
                                        <input type="number" name="biaya_bensin" class="input-custom" placeholder="Contoh: 150000 (Isi jika ada kebutuhan bensin/transportasi tambahan)">
                                        <small class="text-muted" style="font-size: 11px;">*Biaya makan dan penginapan akan dihitung otomatis oleh sistem.</small>
                                    </div>
                                </div>

                                <button type="submit" class="btn-submit-form" id="btnSubmit">
                                    <i class="fas fa-paper-plane"></i> Ajukan Perjalanan Dinas (UC)
                                </button>
                                <p class="text-center text-muted small mt-3 fst-italic">Demikian pengajuan ini dibuat dengan sebenar-benarnya sesuai dengan kebutuhan perusahaan.</p>

                            </form>
                        </div>

                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- PENTING: Panggil library SweetAlert2 untuk Popup -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
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
                        text: 'Tanggal kepulangan tidak boleh mendahului tanggal keberangkatan!',
                        confirmButtonColor: '#0A539B'
                    });
                    document.getElementById('end_date').value = '';
                    hariInput.value = '';
                    return;
                }

                // Hitung selisih waktu dalam milidetik
                const diffTime = Math.abs(endDate - startDate);
                // Konversi ke hari (ditambah 1 agar perhitungannya inklusif/dihitung penuh)
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; 
                
                hariInput.value = diffDays + ' Hari';
            }
        }

        // --- HIDE/SHOW NOMOR POLISI BERDASARKAN TRANSPORTASI ---
        document.querySelectorAll('input[name="transportation_type"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const noPolisiDiv = document.getElementById('no_polisi_div');
                const noPolisiInput = document.getElementById('vehicle_number');
                if(this.value === 'Darat') {
                    noPolisiDiv.style.display = 'block';
                } else {
                    noPolisiDiv.style.display = 'none';
                    noPolisiInput.value = ''; // Reset isian
                }
            });
        });

        // --- KONFIRMASI SEBELUM SUBMIT & PENCEGAH SPAM KLIK ---
        document.getElementById('pengajuanForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('btnSubmit');
            if(btn.classList.contains('disabled')) {
                e.preventDefault(); // Cegah jika sudah di-klik
                return;
            }
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses Pengajuan...';
            btn.classList.add('disabled');
        });
    </script>
</body>
</html>