<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Data Pengguna - Satu Sanzaya</title>
    
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

        /* --- SIDEBAR --- */
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
        .content-area { padding: 30px; flex-grow: 1; overflow-y: auto; }

        /* --- STYLING HALAMAN KELOLA DATA --- */
        .filter-card { background: #FFFFFF; border-radius: 12px; border: 1px solid var(--border-color); padding: 20px; margin-bottom: 20px; }
        .table-card { background: #FFFFFF; border-radius: 12px; border: 1px solid var(--border-color); overflow: hidden; }
        .table th { font-weight: 600; font-size: 12px; color: var(--text-gray); text-transform: uppercase; padding: 15px 20px; background-color: #FAFAFA; border-bottom: 1px solid var(--border-color); }
        .table td { padding: 15px 20px; vertical-align: middle; font-size: 14px; color: var(--text-dark); border-bottom: 1px solid var(--border-color); cursor: pointer; transition: 0.2s; }
        .table tbody tr:hover td { background-color: #F8FBFF; }
        
        .badge-jabatan { padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 500; text-transform: capitalize; }
        .bg-staff { background-color: #E3F2FD; color: #1976D2; }
        .bg-manager { background-color: #E8F5E9; color: #2E7D32; }
        .bg-admin { background-color: #FFF3E0; color: #F57C00; }
        .bg-finance { background-color: #E0F2F1; color: #00897B; }

        .btn-create { background-color: var(--primary-blue); color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 500; transition: 0.3s; width: 100%; height: 42px; }
        .btn-create:hover { background-color: #08427b; color: white; }

        /* --- OFFCANVAS PANEL --- */
        .offcanvas-end { width: 500px !important; border-left: 1px solid var(--border-color); }
        .form-label { font-size: 13px; font-weight: 600; color: var(--text-gray); text-transform: uppercase; margin-bottom: 6px; }
        .form-control, .form-select { border-radius: 8px; border: 1px solid var(--border-color); padding: 10px 15px; font-size: 14px; }
        .form-control:focus, .form-select:focus { border-color: var(--light-blue); box-shadow: 0 0 0 3px rgba(10, 83, 155, 0.1); }
        .form-control:disabled, .form-select:disabled { background-color: #F8F9FA; cursor: not-allowed; }

        /* --- DESAIN TOMBOL MINIMALIS (Hover Animasi) --- */
        .action-bar { display: flex; justify-content: space-between; align-items: center; width: 100%; }
        .btn-minimal { background-color: #FFFFFF; border: 1px solid #EAEAEA; border-radius: 12px; color: #334155; font-weight: 600; font-size: 14px; padding: 10px 20px; display: inline-flex; align-items: center; justify-content: center; transition: all 0.2s ease-in-out; cursor: pointer; box-shadow: 0 1px 2px rgba(0,0,0,0.02); }
        .btn-minimal-icon { padding: 10px; width: 44px; height: 44px; }
        .btn-minimal i { font-size: 16px; }
        .btn-minimal:hover { border-color: #CBD5E1; background-color: #F8FAFC; transform: translateY(-3px); box-shadow: 0 6px 12px rgba(0,0,0,0.08); }
        .btn-minimal.danger { color: #EF4444; }
        .btn-minimal.danger:hover { background-color: #FEF2F2; border-color: #FECACA; color: #DC2626; }
        .btn-minimal.primary { color: var(--primary-blue); }
        .btn-minimal.primary:hover { background-color: #F0F7FF; border-color: #BFDBFE; }

        /* --- RESPONSIVE --- */
        .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 99; transition: 0.3s; }
        
        @media (max-width: 768px) {
            .sidebar { position: fixed; left: -100%; box-shadow: 4px 0 15px rgba(0,0,0,0.1); }
            .sidebar.mobile-active { left: 0; }
            .sidebar-overlay.active { display: block; }
            .main-content, .sidebar.collapsed ~ .main-content { width: 100%; }
            .offcanvas-end { width: 100% !important; }
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
                <a href="{{ route('admin.dashboard') ?? '#' }}">
                    <img src="{{ asset('img/logo.svg') }}" alt="Logo" class="logo-img">
                </a>
            </div>

            <ul class="sidebar-menu">
                <li><a href="{{ route('admin.dashboard') ?? '#' }}" class="menu-item"><i class="fas fa-border-all menu-icon"></i><span class="menu-text">Dashboard</span></a></li>
                <li><a href="{{ route('admin.riwayat.perubahan') ?? '#' }}" class="menu-item"><i class="fas fa-clock-rotate-left menu-icon"></i><span class="menu-text">Riwayat Perubahan</span></a></li>
                <li><a href="{{ route('admin.users.index') ?? '#' }}" class="menu-item active"><i class="fas fa-users menu-icon"></i><span class="menu-text">Kelola data</span></a></li>
                <li><a href="{{ route('admin.settings') ?? '#' }}" class="menu-item"><i class="fas fa-gear menu-icon"></i><span class="menu-text">Settings</span></a></li>
            </ul>

            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">@csrf</form>
                <a href="#" class="menu-item" style="color: var(--text-gray);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-arrow-right-from-bracket menu-icon"></i><span class="menu-text">Keluar</span>
                </a>
            </div>
        </aside>

        <div class="main-content">
            <header class="top-navbar">
                <div class="nav-left">
                    <button class="hamburger-btn" id="toggleSidebar"><i class="fas fa-bars"></i></button>
                    <h5 class="mb-0 fw-bold ms-3 d-none d-md-block">Data Pengguna</h5>
                </div>
                <div class="nav-right">
                    <div class="user-profile">
                        <div class="user-info">
                            <p class="user-name">{{ Auth::user()->name ?? 'Admin Name' }}</p>
                            <p class="user-role">admin</p>
                        </div>
                        <i class="fas fa-user-circle user-avatar"></i>
                    </div>
                </div>
            </header>

            <main class="content-area">
                
                <div class="filter-card">
                    <div class="row align-items-end g-3">
                        <div class="col-md-3">
                            <label class="form-label">Cari Pengguna</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" placeholder="Ketik kata kunci...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Filter Jabatan</label>
                            <select class="form-select">
                                <option value="">Semua Jabatan</option>
                                <option value="manager">Manajer</option>
                                <option value="finance">Finance</option>
                                <option value="admin">Admin</option>
                                <option value="staff">Staff Biasa</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Urutkan</label>
                            <select class="form-select">
                                <option value="asc">A - Z</option>
                                <option value="desc">Z - A</option>
                                <option value="new">Terbaru Ditambahkan</option>
                            </select>
                        </div>
                        <div class="col-md-3 text-md-end">
                            <button type="button" class="btn btn-create" onclick="resetForm()">
                                <i class="fas fa-plus"></i> Tambah Pengguna
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-card table-responsive">
                    <table class="table table-borderless mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>Informasi Pengguna</th>
                                <th>NIK / No. Karyawan</th>
                                <th>Divisi & Jabatan</th>
                                <th>Kontak</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <!-- Data akan dimuat dari JS -->
                        </tbody>
                    </table>
                </div>

            </main>
        </div>
    </div>

    <!-- PANEL GESER OFFCANVAS -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="panelPengguna">
        <div class="offcanvas-header border-bottom p-4">
            <h5 class="offcanvas-title fw-bold" id="panelTitle">Tambah Pengguna Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-4">
            
            <form id="formPengguna" onsubmit="event.preventDefault();">
                <input type="hidden" id="userId" name="user_id">
                
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" placeholder="Masukkan nama lengkap" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" name="birth_place" placeholder="Kota lahir">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="birth_date">
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">NIK (KTP)</label>
                        <input type="text" class="form-control" name="nik" placeholder="16 Digit NIK">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nomor Karyawan</label>
                        <input type="text" class="form-control" name="employee_id" placeholder="Contoh: EMP-001">
                    </div>

                    <!-- DROPDOWN DIVISI BARU -->
                    <div class="col-md-6">
                        <label class="form-label">Divisi <span class="text-danger">*</span></label>
                        <select class="form-select" name="division" required>
                            <option value="">-- Pilih Divisi --</option>
                            <option value="Finance">Finance</option>
                            <option value="GA">GA</option>
                            <option value="Logistik">Logistik</option>
                            <option value="Marketing">Marketing</option>
                            <option value="Cleaning Service">Cleaning Service</option>
                            <option value="Manajemen">Manajemen</option>
                            <option value="IT">IT</option>
                            <option value="HRD">HRD</option>
                        </select>
                    </div>
                    
                    <!-- DROPDOWN JABATAN BARU -->
                    <div class="col-md-6">
                        <label class="form-label">Jabatan <span class="text-danger">*</span></label>
                        <select class="form-select" name="role" required>
                            <option value="">-- Pilih Jabatan --</option>
                            <option value="manager">Manajer</option>
                            <option value="finance">Finance</option>
                            <option value="admin">Admin</option>
                            <option value="staff">Staff Biasa</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" placeholder="nama@sanzaya.com" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No. Handphone</label>
                        <input type="text" class="form-control" name="phone" placeholder="08xxx">
                    </div>

                    <!-- INFORMASI REKENING BANK -->
                    <div class="col-12 mt-4">
                        <h6 class="fw-bold mb-2" style="color: var(--primary-blue);"><i class="fas fa-university me-2"></i>Informasi Rekening Bank</h6>
                        <hr class="mt-0 mb-3">
                    </div>
                    
                    <div class="col-md-4 mt-0">
                        <label class="form-label">Bank</label>
                        <select class="form-select" name="bank">
                            <option value="">Pilih Bank</option>
                            <option value="BCA">BCA</option>
                            <option value="Mandiri">Mandiri</option>
                            <option value="BNI">BNI</option>
                            <option value="BRI">BRI</option>
                            <option value="BSI">BSI</option>
                            <option value="CIMB Niaga">CIMB Niaga</option>
                            <option value="Lainnya">Lainnya...</option>
                        </select>
                    </div>
                    <div class="col-md-4 mt-0">
                        <label class="form-label">No. Rekening</label>
                        <input type="text" class="form-control" name="nomor_rekening" placeholder="Contoh: 12345678">
                    </div>
                    <div class="col-md-4 mt-0">
                        <label class="form-label">Atas Nama</label>
                        <input type="text" class="form-control" name="nama_rekening" placeholder="Sesuai buku">
                    </div>

                    <div class="col-12 mt-4">
                        <label class="form-label">Password Sistem</label>
                        <input type="password" class="form-control" name="password" placeholder="Kosongkan untuk password default: 12345678">
                    </div>
                </div>

                <div class="mt-5 pt-3 border-top" id="actionButtons">
                    <!-- Tombol akan dimuat secara dinamis melalui JS -->
                </div>
            </form>

        </div>
    </div>

    <!-- PENTING: Panggil library SweetAlert2 untuk Popup -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // --- SETUP CSRF TOKEN UNTUK AJAX ---
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // --- LOGIKA SIDEBAR ---
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

        // --- LOAD DATA TABEL (AJAX) ---
        async function fetchUsers() {
            try {
                // Pastikan route backend Anda ada di /admin/api/users atau sesuaikan
                const response = await fetch('/admin/api/users');
                const users = await response.json();
                let tableBody = document.getElementById('tableBody');
                tableBody.innerHTML = ''; 

                users.forEach(user => {
                    // Penentuan Warna Badge Jabatan
                    let badgeClass = 'bg-staff';
                    if(user.role === 'admin') badgeClass = 'bg-admin';
                    if(user.role === 'finance') badgeClass = 'bg-finance';
                    if(user.role === 'manager') badgeClass = 'bg-manager';
                    
                    let row = `
                        <tr style="cursor: pointer;" onclick="loadDetailData(${user.id})">
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                        <i class="fas fa-user text-primary"></i>
                                    </div>
                                    <div><p class="mb-0 fw-bold">${user.name}</p><span class="text-muted small">${user.birth_place || '-'}, ${user.birth_date || '-'}</span></div>
                                </div>
                            </td>
                            <td><p class="mb-0 fw-medium">${user.nik || '-'}</p><span class="text-muted small">${user.employee_id || '-'}</span></td>
                            <td><p class="mb-1"><span class="badge-jabatan ${badgeClass}">${user.role}</span></p><span class="text-muted small">${user.division || '-'}</span></td>
                            <td><p class="mb-0 small"><i class="fas fa-envelope text-muted me-2"></i> ${user.email}</p><p class="mb-0 small"><i class="fas fa-phone text-muted me-2"></i> ${user.phone || '-'}</p></td>
                        </tr>
                    `;
                    tableBody.insertAdjacentHTML('beforeend', row);
                });
            } catch (error) { 
                console.error("Gagal memuat data tabel:", error); 
            }
        }

        // Panggil data saat halaman terbuka
        document.addEventListener('DOMContentLoaded', fetchUsers);

        // --- MODE: TAMBAH DATA BARU ---
        function resetForm() {
            try {
                document.getElementById('panelTitle').innerText = 'Tambah Pengguna Baru';
                document.getElementById('formPengguna').reset();
                document.getElementById('userId').value = ''; 
                
                document.querySelectorAll('#formPengguna input, #formPengguna select').forEach(el => el.disabled = false);

                document.getElementById('actionButtons').innerHTML = `
                    <div class="action-bar mt-2">
                        <button type="button" class="btn-minimal btn-minimal-icon" data-bs-dismiss="offcanvas" title="Batal">
                            <i class="fas fa-times"></i>
                        </button>
                        <button type="button" class="btn-minimal primary" onclick="submitData()">
                            Simpan
                        </button>
                    </div>
                `;

                const panel = document.getElementById('panelPengguna');
                const bsOffcanvas = bootstrap.Offcanvas.getOrCreateInstance(panel);
                bsOffcanvas.show();
            } catch (error) {
                console.error("Terjadi kesalahan saat membuka form:", error);
            }
        }

        // --- MODE: LIHAT DETAIL ---
        async function loadDetailData(id) {
            document.getElementById('panelTitle').innerText = 'Memuat Data...';
            
            // Tampilkan panel
            const panel = document.getElementById('panelPengguna');
            const bsOffcanvas = bootstrap.Offcanvas.getOrCreateInstance(panel);
            bsOffcanvas.show();
            
            try {
                const response = await fetch(`/admin/api/users/${id}`);
                const user = await response.json();

                document.getElementById('panelTitle').innerText = 'Detail Pengguna';
                document.getElementById('userId').value = user.id;

                // Isi Form
                document.querySelector('[name="name"]').value = user.name;
                document.querySelector('[name="email"]').value = user.email;
                document.querySelector('[name="role"]').value = user.role;
                document.querySelector('[name="nik"]').value = user.nik || '';
                document.querySelector('[name="employee_id"]').value = user.employee_id || '';
                document.querySelector('[name="division"]').value = user.division || '';
                document.querySelector('[name="phone"]').value = user.phone || '';
                document.querySelector('[name="birth_place"]').value = user.birth_place || '';
                document.querySelector('[name="birth_date"]').value = user.birth_date || '';
                
                // Isi Form Rekening Bank
                document.querySelector('[name="bank"]').value = user.bank || '';
                document.querySelector('[name="nomor_rekening"]').value = user.nomor_rekening || '';
                document.querySelector('[name="nama_rekening"]').value = user.nama_rekening || '';
                
                document.querySelector('[name="password"]').value = ''; // Kosongkan saat view
                
                // Kunci Input (Mode Lihat/View)
                document.querySelectorAll('#formPengguna input, #formPengguna select').forEach(el => el.disabled = true);

                document.getElementById('actionButtons').innerHTML = `
                    <div class="action-bar mt-2">
                        <div class="d-flex gap-2">
                            <button type="button" class="btn-minimal btn-minimal-icon" data-bs-dismiss="offcanvas" title="Tutup">
                                <i class="fas fa-times"></i>
                            </button>
                            <button type="button" class="btn-minimal btn-minimal-icon danger" onclick="deleteUser(${user.id})" title="Hapus">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </div>
                        <button type="button" class="btn-minimal" onclick="enableEditMode()">
                            Edit Data <i class="fas fa-pencil-alt ms-2"></i>
                        </button>
                    </div>
                `;
            } catch (error) { 
                Swal.fire({ icon: 'error', title: 'Oops...', text: 'Gagal menarik data dari server.' }); 
            }
        }

        // --- MODE: EDIT DATA ---
        function enableEditMode() {
            document.getElementById('panelTitle').innerText = 'Edit Pengguna';
            
            // Buka kunci semua input
            document.querySelectorAll('#formPengguna input, #formPengguna select').forEach(el => {
                el.disabled = false;
            });

            document.getElementById('actionButtons').innerHTML = `
                <div class="action-bar mt-2">
                    <button type="button" class="btn-minimal" onclick="loadDetailData(document.getElementById('userId').value)">
                        Batal
                    </button>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn-minimal btn-minimal-icon danger" onclick="deleteUser(document.getElementById('userId').value)" title="Hapus">
                            <i class="far fa-trash-alt"></i>
                        </button>
                        <button type="button" class="btn-minimal btn-minimal-icon primary" onclick="submitData()" title="Simpan Perubahan">
                            <i class="far fa-save"></i>
                        </button>
                    </div>
                </div>
            `;
        }

        // --- AKSI: SIMPAN / UPDATE ---
        async function submitData() {
            let form = document.getElementById('formPengguna');
            if(!form.checkValidity()) { form.reportValidity(); return; }

            let formData = new FormData(form);
            let userId = document.getElementById('userId').value;
            let url = userId ? `/admin/api/users/${userId}` : '/admin/api/users';
            
            if(userId) formData.append('_method', 'PUT'); 

            Swal.fire({
                title: 'Menyimpan...',
                text: 'Mohon tunggu.',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });

            try {
                const response = await fetch(url, {
                    method: 'POST', 
                    body: formData,
                    headers: { 
                        'X-Requested-With': 'XMLHttpRequest', 
                        'X-CSRF-TOKEN': csrfToken 
                    }
                });

                const result = await response.json();

                if (response.ok) {
                    bootstrap.Offcanvas.getInstance(document.getElementById('panelPengguna')).hide();
                    fetchUsers();
                    Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Data disimpan.', showConfirmButton: false, timer: 1500 });
                } else {
                    let errorMsg = 'Gagal menyimpan data.';
                    if (response.status === 422 && result.errors) errorMsg = Object.values(result.errors)[0][0]; 
                    else if (result.message) errorMsg = result.message;
                    Swal.fire({ icon: 'error', title: 'Gagal', text: errorMsg });
                }
            } catch (error) { 
                Swal.fire({ icon: 'error', title: 'Kesalahan Sistem', text: 'Gagal menghubungi server.' });
            }
        }

        // --- AKSI: HAPUS ---
        async function deleteUser(id) {
            Swal.fire({
                title: 'Hapus Pengguna?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DC2626',
                cancelButtonColor: '#F1F1F1',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: '<span style="color: #333;">Batal</span>'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    Swal.fire({ title: 'Menghapus...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); }});
                    try {
                        const response = await fetch(`/admin/api/users/${id}`, {
                            method: 'DELETE',
                            headers: { 
                                'X-CSRF-TOKEN': csrfToken,
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        
                        if (response.ok) {
                            bootstrap.Offcanvas.getInstance(document.getElementById('panelPengguna')).hide();
                            fetchUsers();
                            Swal.fire({ icon: 'success', title: 'Terhapus!', text: 'Pengguna dihapus.', showConfirmButton: false, timer: 1500 });
                        } else {
                            Swal.fire({ icon: 'error', title: 'Gagal', text: 'Pengguna gagal dihapus.' });
                        }
                    } catch (error) { 
                        Swal.fire({ icon: 'error', title: 'Gagal', text: 'Kesalahan server.' });
                    }
                }
            });
        }
    </script>
</body>
</html>