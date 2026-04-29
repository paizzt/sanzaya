<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Laporan Result - Satu Sanzaya</title>
    
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
        .user-role { font-size: 11px; color: var(--text-gray); margin: 0; text-transform: capitalize; }
        .user-avatar { font-size: 32px; color: var(--primary-blue); }
        .content-area { padding: 30px 40px; flex-grow: 1; overflow-y: auto; }

        /* --- STYLING FORM KLAIM --- */
        .form-card { background: #FFFFFF; border-radius: 16px; border: 1px solid var(--border-color); padding: 35px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); margin-bottom: 25px; }
        .form-title { font-size: 18px; font-weight: 700; color: var(--primary-blue); margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px; }
        
        .upload-area { border: 2px dashed var(--primary-blue); border-radius: 12px; padding: 30px; text-align: center; background-color: #F8FBFF; transition: 0.3s; cursor: pointer; }
        .upload-area:hover { background-color: #E5F0FF; }
        .upload-area i { font-size: 40px; color: var(--primary-blue); margin-bottom: 15px; }
        
        .table-result th { background-color: var(--primary-blue); color: white; font-weight: 600; font-size: 13px; text-align: center; padding: 12px; }
        .table-result td { padding: 10px; vertical-align: top; }
        .form-control-result { width: 100%; border: 1px solid #CBD5E1; border-radius: 8px; padding: 10px; font-size: 13px; outline: none; transition: 0.2s; }
        .form-control-result:focus { border-color: var(--primary-blue); box-shadow: 0 0 0 3px rgba(10, 83, 155, 0.1); }
        
        .btn-add-row { background-color: #10B981; color: white; border: none; padding: 8px 16px; border-radius: 8px; font-size: 12px; font-weight: 600; transition: 0.2s; }
        .btn-add-row:hover { background-color: #059669; color: white; }
        
        .btn-remove-row { background-color: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; padding: 8px 12px; border-radius: 8px; font-size: 12px; transition: 0.2s; }
        .btn-remove-row:hover { background-color: #DC2626; color: white; }

        .btn-submit { background-color: var(--primary-blue); color: white; border: none; border-radius: 10px; padding: 14px 30px; font-size: 15px; font-weight: 600; width: 100%; transition: 0.3s; box-shadow: 0 4px 6px rgba(10,83,155,0.2); }
        .btn-submit:hover { background-color: #08427b; transform: translateY(-2px); }
        
        /* --- RESPONSIVE --- */
        .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 99; transition: 0.3s; }
        
        @media (max-width: 768px) {
            .sidebar { position: fixed; left: -100%; box-shadow: 4px 0 15px rgba(0,0,0,0.1); }
            .sidebar.mobile-active { left: 0; }
            .sidebar-overlay.active { display: block; }
            .main-content, .sidebar.collapsed ~ .main-content { width: 100%; }
        }
    </style>
</head>
<body>

    @php
        $userRole = strtolower(trim(Auth::user()->role));
    @endphp

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="wrapper">
        
        <!-- SIDEBAR PINTAR (DINAMIS BERDASARKAN ROLE) -->
        <aside class="sidebar" id="sidebar">
            <div class="logo-area">
                <a href="{{ url('/home') }}">
                    <img src="{{ asset('img/logo.svg') }}" alt="Logo" class="logo-img">
                </a>
            </div>

            <ul class="sidebar-menu">
                @if(in_array($userRole, ['manager', 'hrd', 'kepala marketing']))
                    <li><a href="{{ route('manager.dashboard') ?? '#' }}" class="menu-item"><i class="fas fa-border-all menu-icon"></i><span class="menu-text">Dashboard</span></a></li>
                    <li><a href="{{ route('approvals.index') ?? '#' }}" class="menu-item"><i class="fas fa-file-signature menu-icon"></i><span class="menu-text">Persetujuan SPPD</span></a></li>
                    <li><a href="{{ route('manager.history') ?? '#' }}" class="menu-item active"><i class="fas fa-history menu-icon"></i><span class="menu-text">Riwayat Proses</span></a></li>
                    <li><a href="{{ route('arsip.index') ?? '#' }}" class="menu-item"><i class="fas fa-archive menu-icon"></i><span class="menu-text">Arsip UC</span></a></li>
                    <li><a href="{{ route('manager.pengajuan.create') ?? '#' }}" class="menu-item"><i class="fas fa-paper-plane menu-icon"></i><span class="menu-text">Buat Pengajuan</span></a></li>
                    <li><a href="{{ route('manager.settings') ?? '#' }}" class="menu-item"><i class="fas fa-gear menu-icon"></i><span class="menu-text">Settings</span></a></li>
                @elseif($userRole == 'staff')
                    <li><a href="{{ route('staff.dashboard') ?? '#' }}" class="menu-item"><i class="fas fa-border-all menu-icon"></i><span class="menu-text">Dashboard</span></a></li>
                    <li><a href="{{ route('staff.riwayat') ?? '#' }}" class="menu-item active"><i class="fas fa-clock-rotate-left menu-icon"></i><span class="menu-text">Riwayat Pengajuan</span></a></li>
                    <li><a href="{{ route('staff.pengajuan.create') ?? '#' }}" class="menu-item"><i class="fas fa-file-lines menu-icon"></i><span class="menu-text">Pengajuan UC</span></a></li>
                    <li><a href="{{ route('staff.settings') ?? '#' }}" class="menu-item"><i class="fas fa-gear menu-icon"></i><span class="menu-text">Settings</span></a></li>
                @endif
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
                    <h5 class="mb-0 fw-bold ms-3 d-none d-md-block">Form Pelaporan Result & Klaim</h5>
                </div>
                <div class="nav-right">
                    <div class="user-profile">
                        <div class="user-info">
                            <p class="user-name">{{ Auth::user()->name ?? 'Nama User' }}</p>
                            <p class="user-role">{{ Auth::user()->role ?? 'Role' }}</p>
                        </div>
                        <i class="fas fa-user-circle user-avatar"></i>
                    </div>
                </div>
            </header>

            <main class="content-area">
                
                <a href="{{ url()->previous() }}" class="btn btn-light border mb-4 fw-bold" style="border-radius: 8px;"><i class="fas fa-arrow-left me-2"></i> Kembali</a>

                <div class="row justify-content-center">
                    <div class="col-xl-10">
                        
                        <div class="form-card">
                            <div class="mb-4 pb-3 border-bottom d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="form-title">Lampiran Klaim Anggaran UC</h4>
                                    <p class="text-muted small m-0">Pengajuan: {{ $pengajuan->departure }} - {{ $pengajuan->destination }}</p>
                                </div>
                                <span class="badge bg-primary px-3 py-2" style="font-size: 13px;">Form Result Final</span>
                            </div>

                            @if($errors->any())
                            <div class="alert alert-danger" style="border-radius: 10px;">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <form action="{{ route('pengajuan.klaim.store', $pengajuan->id) }}" method="POST" enctype="multipart/form-data" id="klaimForm">
                                @csrf
                                
                                <!-- UPLOAD NOTA -->
                                <h6 class="fw-bold mb-3"><i class="fas fa-file-invoice me-2 text-primary"></i> 1. Bukti Nota / Kwitansi Lengkap</h6>
                                <p class="text-muted small mb-3">Upload file yang berisi gabungan foto nota penginapan, tiket/bensin, dan makan (Bisa format PDF, JPG, atau PNG. Maksimal 5MB).</p>
                                
                                <label class="upload-area w-100 d-block mb-5" for="nota_file">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <h6 class="fw-bold text-dark">Klik Untuk Memilih File Nota</h6>
                                    <p class="text-muted small m-0" id="fileNameDisplay">Belum ada file yang dipilih</p>
                                    <input type="file" name="nota_file" id="nota_file" class="d-none" accept=".pdf,.jpg,.jpeg,.png" required onchange="document.getElementById('fileNameDisplay').innerText = this.files[0].name">
                                </label>

                                <!-- HASIL KUNJUNGAN -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold m-0"><i class="fas fa-clipboard-list me-2 text-primary"></i> 2. Laporan Hasil Kunjungan (Result)</h6>
                                    <button type="button" class="btn-add-row" onclick="addRow()"><i class="fas fa-plus me-1"></i> Tambah Baris</button>
                                </div>
                                
                                <div class="table-responsive mb-4">
                                    <table class="table table-bordered table-result" id="resultTable">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;">NO</th>
                                                <th style="width: 25%;">OUTLET / INSTANSI</th>
                                                <th style="width: 25%;">TUJUAN KUNJUNGAN</th>
                                                <th style="width: 40%;">HASIL KUNJUNGAN</th>
                                                <th style="width: 5%;"><i class="fas fa-cog"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody id="resultBody">
                                            <tr>
                                                <td class="text-center fw-bold row-num">1</td>
                                                <td><input type="text" name="outlet[]" class="form-control-result" placeholder="Contoh: RSUD..." required></td>
                                                <td><textarea name="tujuan_kunjungan[]" class="form-control-result" rows="3" placeholder="Tujuan..." required></textarea></td>
                                                <td><textarea name="hasil_kunjungan[]" class="form-control-result" rows="3" placeholder="Rincian hasil pembicaraan/kunjungan..." required></textarea></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn-remove-row" onclick="removeRow(this)"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-5 pt-4 border-top">
                                    <div class="alert alert-warning mb-4" style="background-color: #FFFBEB; color: #B45309; border: 1px solid #FDE68A;">
                                        <i class="fas fa-info-circle me-2"></i> <strong>Perhatian:</strong> Setelah Anda menekan tombol submit, dokumen ini akan dianggap <strong>Selesai (Final)</strong> dan PDF Result bisa langsung diunduh/dicetak.
                                    </div>
                                    <button type="submit" class="btn-submit" id="btnSubmitForm">
                                        <i class="fas fa-paper-plane me-2"></i> Submit Laporan & Nota Sekarang
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
    <script>
        // --- LOGIKA RESPONSIVE SIDEBAR ---
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            if (window.innerWidth <= 768) { sidebar.classList.toggle('mobile-active'); overlay.classList.toggle('active'); } 
            else { sidebar.classList.toggle('collapsed'); }
        });
        overlay.addEventListener('click', function() { sidebar.classList.remove('mobile-active'); overlay.classList.remove('active'); });

        // --- LOGIKA TABEL DINAMIS ---
        function updateRowNumbers() {
            const rows = document.querySelectorAll('#resultBody tr');
            rows.forEach((row, index) => { row.querySelector('.row-num').innerText = index + 1; });
        }

        function addRow() {
            const tbody = document.getElementById('resultBody');
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="text-center fw-bold row-num"></td>
                <td><input type="text" name="outlet[]" class="form-control-result" placeholder="Outlet..." required></td>
                <td><textarea name="tujuan_kunjungan[]" class="form-control-result" rows="3" placeholder="Tujuan..." required></textarea></td>
                <td><textarea name="hasil_kunjungan[]" class="form-control-result" rows="3" placeholder="Hasil..." required></textarea></td>
                <td class="text-center">
                    <button type="button" class="btn-remove-row" onclick="removeRow(this)"><i class="fas fa-trash"></i></button>
                </td>
            `;
            tbody.appendChild(tr);
            updateRowNumbers();
        }

        function removeRow(btn) {
            const tbody = document.getElementById('resultBody');
            if(tbody.children.length > 1) {
                btn.closest('tr').remove();
                updateRowNumbers();
            } else {
                alert('Minimal harus ada 1 baris laporan.');
            }
        }
        
        // Form Loading
        document.getElementById('klaimForm').addEventListener('submit', function() {
            const btn = document.getElementById('btnSubmitForm');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Mengunggah File...';
            btn.style.pointerEvents = 'none';
        });
    </script>
</body>
</html>