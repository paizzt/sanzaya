<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengajuan SPPD - Satu Sanzaya</title>
    
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

        /* --- STEPPER PROGRESS --- */
        .stepper-container { display: flex; justify-content: center; align-items: center; margin-bottom: 40px; margin-top: 10px; width: 100%; max-width: 650px; margin-left: auto; margin-right: auto; }
        .step-item { display: flex; flex-direction: column; align-items: center; position: relative; z-index: 2; width: 80px; }
        .step-circle { width: 40px; height: 40px; border-radius: 50%; background-color: #FFFFFF; color: #94A3B8; display: flex; justify-content: center; align-items: center; font-weight: 600; font-size: 15px; margin-bottom: 10px; border: 2px solid #E2E8F0; transition: all 0.3s ease; }
        .step-text { font-size: 12px; font-weight: 600; color: #94A3B8; text-align: center; white-space: nowrap; text-transform: uppercase; letter-spacing: 0.5px; }
        .step-line { flex-grow: 1; height: 2px; background: repeating-linear-gradient(90deg, #CBD5E1, #CBD5E1 5px, transparent 5px, transparent 10px); position: relative; top: -14px; z-index: 1; margin: 0 10px; }
        
        .step-item.active .step-circle { background-color: #FFFFFF; color: var(--primary-blue); border-color: var(--primary-blue); box-shadow: 0 4px 10px rgba(10, 83, 155, 0.3); border-width: 3px; }
        .step-item.active .step-text { color: var(--primary-blue); }
        .step-item.completed .step-circle { background-color: var(--primary-blue); color: #FFFFFF; border-color: var(--primary-blue); }
        .step-item.completed .step-text { color: var(--primary-blue); }
        .step-line.completed { background: var(--primary-blue); border: none; height: 2px; }

        /* --- RANGKUMAN CARD --- */
        .summary-card { background-color: #FFFFFF; border-radius: 20px; padding: 40px; box-shadow: 0 10px 25px rgba(0,0,0,0.03); border: 1px solid #E2E8F0; }
        .summary-header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px dashed #E2E8F0; padding-bottom: 20px; margin-bottom: 30px; }
        .req-id { font-size: 24px; font-weight: 700; color: var(--text-dark); margin: 0; }
        .req-date { font-size: 13px; color: var(--text-gray); margin-top: 5px; }
        
        .section-title { font-size: 12px; font-weight: 700; color: #94A3B8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px; margin-top: 30px; }
        
        /* --- APPROVAL TRACKER 2 LEVEL --- */
        .approval-track { display: flex; gap: 20px; margin-bottom: 40px; }
        .approval-step { flex: 1; background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 14px; padding: 20px; display: flex; align-items: center; gap: 15px; transition: 0.3s; position: relative; }
        
        /* State Colors */
        .approval-step.active { border-color: #FBBF24; background: #FFFBEB; box-shadow: 0 4px 12px rgba(251, 191, 36, 0.1); }
        .approval-step.approved { border-color: #34D399; background: #ECFDF5; }
        .approval-step.rejected { border-color: #F87171; background: #FEF2F2; }
        .approval-step.locked { border-color: #E2E8F0; background: #F8FAFC; opacity: 0.7; }
        
        .approval-icon { width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
        .active .approval-icon { background: #F59E0B; color: white; }
        .approved .approval-icon { background: #10B981; color: white; }
        .rejected .approval-icon { background: #EF4444; color: white; }
        .locked .approval-icon { background: #CBD5E1; color: white; }
        
        .approval-info h6 { margin: 0 0 4px 0; font-weight: 700; font-size: 13px; color: var(--text-dark); text-transform: uppercase; }
        .approval-info p.status-text { margin: 0; font-size: 14px; font-weight: 600; }
        .approval-info p.reviewer { margin: 4px 0 0 0; font-size: 11px; color: var(--text-gray); }

        /* Data Box */
        .data-box { background: var(--form-bg); border-radius: 12px; padding: 20px; border: 1px solid #E0E7FF; }
        .data-label { font-size: 12px; color: var(--text-gray); text-transform: uppercase; font-weight: 600; margin-bottom: 4px; }
        .data-value { font-size: 15px; color: var(--text-dark); font-weight: 600; margin-bottom: 15px; }
        
        /* Tabel Rute */
        .route-table { width: 100%; border-collapse: separate; border-spacing: 0; margin-top: 10px; }
        .route-table th { background-color: var(--light-blue); color: var(--primary-blue); font-size: 12px; font-weight: 600; text-transform: uppercase; padding: 12px 15px; text-align: left; }
        .route-table th:first-child { border-radius: 8px 0 0 8px; }
        .route-table th:last-child { border-radius: 0 8px 8px 0; }
        .route-table td { padding: 15px; border-bottom: 1px solid #E2E8F0; font-size: 14px; font-weight: 500; color: var(--text-dark); vertical-align: middle; }
        .transport-badge { background: #FFFFFF; border: 1px solid #E2E8F0; padding: 6px 12px; border-radius: 8px; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; }

        /* Action Buttons */
        .btn-action-container { display: flex; gap: 15px; justify-content: flex-end; margin-top: 40px; padding-top: 20px; border-top: 1px solid #E2E8F0; }
        .btn-secondary-custom { background: #FFFFFF; border: 1px solid #E2E8F0; color: var(--text-dark); padding: 12px 24px; border-radius: 10px; font-weight: 600; transition: 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
        .btn-secondary-custom:hover { background: #F8FAFC; border-color: #CBD5E1; color: var(--text-dark); }
        .btn-primary-custom { background: var(--primary-blue); border: 1px solid var(--primary-blue); color: #FFFFFF; padding: 12px 24px; border-radius: 10px; font-weight: 600; transition: 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
        .btn-primary-custom:hover { background: #08427b; color: #FFFFFF; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(10, 83, 155, 0.2); }

        /* Responsive */
        .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 99; transition: 0.3s; }
        @media (max-width: 992px) {
            .route-table { display: block; overflow-x: auto; white-space: nowrap; }
            .approval-track { flex-direction: column; gap: 15px; }
        }
        @media (max-width: 768px) {
            .sidebar { position: fixed; left: -100%; box-shadow: 4px 0 15px rgba(0,0,0,0.1); }
            .sidebar.mobile-active { left: 0; }
            .sidebar-overlay.active { display: block; }
            .main-content { width: 100%; }
            .content-area { padding: 20px; }
            .summary-card { padding: 20px; }
            .stepper-container { max-width: 100%; overflow-x: auto; justify-content: flex-start; padding-bottom: 15px; }
            .btn-action-container { flex-direction: column; }
            .btn-action-container a { width: 100%; justify-content: center; }
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
                <li><a href="#" class="menu-item"><i class="fas fa-border-all menu-icon"></i><span class="menu-text">Dashboard</span></a></li>
                <li><a href="#" class="menu-item"><i class="fas fa-clock-rotate-left menu-icon"></i><span class="menu-text">Riwayat Pengajuan</span></a></li>
                <li><a href="#" class="menu-item active"><i class="fas fa-file-lines menu-icon"></i><span class="menu-text">Pengajuan UC</span></a></li>
                <li><a href="#" class="menu-item"><i class="fas fa-gear menu-icon"></i><span class="menu-text">Settings</span></a></li>
            </ul>
        </aside>

        <div class="main-content">
            <header class="top-navbar">
                <div class="nav-left">
                    <button class="hamburger-btn" id="toggleSidebar"><i class="fas fa-bars"></i></button>
                </div>
                <div class="nav-right">
                    <div class="user-profile">
                        <div class="user-info">
                            <p class="user-name">{{ Auth::user()->name ?? 'Faisal Faiz' }}</p>
                            <p class="user-role">Staff</p>
                        </div>
                        <i class="fas fa-user-circle user-avatar"></i>
                    </div>
                </div>
            </header>

            <main class="content-area">
                
                <div class="stepper-container">
                    <div class="step-item completed">
                        <div class="step-circle"><i class="fas fa-check"></i></div>
                        <div class="step-text">Pengajuan</div>
                    </div>
                    <div class="step-line completed"></div>
                    <div class="step-item active">
                        <div class="step-circle">2</div>
                        <div class="step-text">Proses</div>
                    </div>
                    <div class="step-line"></div>
                    <div class="step-item">
                        <div class="step-circle">3</div>
                        <div class="step-text">ACC / Tolak</div>
                    </div>
                    <div class="step-line"></div>
                    <div class="step-item">
                        <div class="step-circle">4</div>
                        <div class="step-text">Selesai</div>
                    </div>
                </div>

                <div class="summary-card">
                    
                    <div class="summary-header">
                        <div>
                            <h2 class="req-id">#SPPD-20271230-001</h2>
                            <p class="req-date">Diajukan pada: 20 April 2026, 10:49 WITA</p>
                        </div>
                    </div>

                    <div class="section-title mt-0">Status Persetujuan</div>
                    <div class="approval-track">
                        
                        <div class="approval-step active">
                            <div class="approval-icon"><i class="fas fa-hourglass-half"></i></div>
                            <div class="approval-info">
                                <h6>Level 1: Manajer / HRD</h6>
                                <p class="status-text text-warning">Menunggu Persetujuan</p>
                                <p class="reviewer"><i class="far fa-user"></i> Membutuhkan respon atasan</p>
                            </div>
                        </div>

                        <div class="approval-step locked">
                            <div class="approval-icon"><i class="fas fa-lock"></i></div>
                            <div class="approval-info">
                                <h6>Level 2: Finance</h6>
                                <p class="status-text text-muted">Menunggu Tahap 1</p>
                                <p class="reviewer"><i class="far fa-clock"></i> Tertahan</p>
                            </div>
                        </div>

                    </div>

                    <div class="section-title">Informasi Pemohon</div>
                    <div class="data-box">
                        <div class="row">
                            <div class="col-md-3 col-6">
                                <div class="data-label">Nama Lengkap</div>
                                <div class="data-value">{{ Auth::user()->name ?? 'Faisal Faiz' }}</div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="data-label">Nomor Karyawan</div>
                                <div class="data-value">EMP-2024-001</div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="data-label">Divisi</div>
                                <div class="data-value">Operasional IT</div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="data-label">Jabatan</div>
                                <div class="data-value">Staff</div>
                            </div>
                        </div>
                    </div>

                    <div class="section-title">Rute Perjalanan</div>
                    <table class="route-table">
                        <thead>
                            <tr>
                                <th>Transportasi</th>
                                <th>Dari</th>
                                <th>Ke</th>
                                <th>Tanggal</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="transport-badge"><i class="fas fa-plane text-primary"></i> Pesawat</span></td>
                                <td>Makassar</td>
                                <td>Bantaeng</td>
                                <td>30 Des 2027</td>
                                <td>06:30</td>
                                <td>20:30</td>
                            </tr>
                            <tr>
                                <td><span class="transport-badge"><i class="fas fa-car text-primary"></i> Mobil</span></td>
                                <td>Bantaeng</td>
                                <td>Makassar</td>
                                <td>01 Jan 2028</td>
                                <td>06:30</td>
                                <td>20:30</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="row mt-4">
                        <div class="col-md-7">
                            <div class="section-title">Rincian Biaya & Akomodasi</div>
                            <div class="data-box">
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <div class="data-label">Malam Akomodasi</div>
                                        <div class="data-value">2 Malam (Makassar)</div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="data-label">Hari Uang Makan</div>
                                        <div class="data-value">2 Hari (Makassar)</div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="data-label">Durasi Uang Saku</div>
                                        <div class="data-value">2 Hari <br><small class="text-muted fw-normal">12 Des 2027 - 13 Des 2027</small></div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="data-label">Estimasi Harga Tiket / Bensin</div>
                                        <div class="data-value text-primary fs-5">Rp 1.500.000</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="section-title">Info Tambahan</div>
                            <div class="data-box" style="height: calc(100% - 40px);">
                                <div class="data-label">Catatan Khusus</div>
                                <div class="data-value" style="font-weight: 500;">
                                    Terdapat kunjungan tambahan ke site proyek Bantaeng pada siang hari.
                                </div>

                                <div class="data-label mt-4">Pendamping</div>
                                <div class="data-value" style="font-weight: 500;">
                                    1. Budi Santoso - Staff<br>
                                    2. Rina Melati - Manager
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="btn-action-container">
                        <a href="#" class="btn-secondary-custom">
                            <i class="fas fa-print"></i> Cetak Draft
                        </a>
                        <a href="{{ route('staff.dashboard') ?? '#' }}" class="btn-primary-custom">
                            Kembali ke Dashboard
                        </a>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        document.getElementById('toggleSidebar').addEventListener('click', () => {
            if (window.innerWidth <= 768) { sidebar.classList.toggle('mobile-active'); overlay.classList.toggle('active'); } 
            else { sidebar.classList.toggle('collapsed'); }
        });
        overlay.addEventListener('click', () => { sidebar.classList.remove('mobile-active'); overlay.classList.remove('active'); });
    </script>
</body>
</html>