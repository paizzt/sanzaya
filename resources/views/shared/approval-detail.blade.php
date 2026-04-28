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
        .nav-right { display: flex; align-items: center; gap: 25px; }
        .user-profile { display: flex; align-items: center; gap: 12px; }
        .user-info { text-align: right; line-height: 1.2; }
        .user-name { font-weight: 600; font-size: 14px; color: var(--text-dark); margin: 0; }
        .user-role { font-size: 11px; color: var(--text-gray); margin: 0; text-transform: capitalize; }
        .user-avatar { font-size: 32px; color: var(--primary-blue); }
        .content-area { padding: 30px 40px; flex-grow: 1; overflow-y: auto; }

        /* --- STYLING DETAIL --- */
        .detail-card { background: #FFFFFF; border-radius: 16px; border: 1px solid var(--border-color); padding: 35px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); margin-bottom: 25px; }
        .section-title { font-size: 15px; font-weight: 700; color: var(--primary-blue); margin-bottom: 20px; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid var(--border-color); padding-bottom: 10px; display: flex; align-items: center; gap: 8px; }
        
        .info-group { margin-bottom: 20px; }
        .info-label { font-size: 12px; font-weight: 600; color: var(--text-gray); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px; }
        .info-value { font-size: 15px; font-weight: 600; color: var(--text-dark); background-color: #F8FAFC; padding: 12px 16px; border-radius: 10px; border: 1px solid #E2E8F0; }

        /* Input Finance Editable */
        .input-custom { width: 100%; border: 1px solid #CBD5E1; padding: 10px 12px; font-size: 14px; color: var(--text-dark); background-color: #FFFFFF; transition: all 0.2s; font-weight: 600;}
        .input-custom:focus { border-color: var(--primary-blue); box-shadow: 0 0 0 3px rgba(10, 83, 155, 0.1); outline: none; z-index: 5;}
        .input-custom[readonly] { background-color: #F8FAFC; color: var(--primary-blue); }
        .rp-text { background-color: #F8FAFC; border: 1px solid #CBD5E1; color: var(--text-dark); font-weight: 600; font-size: 14px; border-radius: 10px 0 0 10px; }

        /* Action Panel */
        .action-panel { background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 16px; padding: 25px; position: sticky; top: 30px; }
        .action-panel h5 { font-weight: 700; color: var(--text-dark); margin-bottom: 20px; font-size: 16px; }
        .form-control-note { border-radius: 10px; border: 1px solid #CBD5E1; font-size: 13px; padding: 12px; resize: none; margin-bottom: 20px; }
        .form-control-note:focus { border-color: var(--primary-blue); box-shadow: 0 0 0 3px rgba(10, 83, 155, 0.1); outline: none; }
        
        .btn-action { padding: 14px 20px; border-radius: 10px; font-weight: 600; font-size: 14px; width: 100%; border: none; display: flex; align-items: center; justify-content: center; gap: 10px; transition: 0.3s; margin-bottom: 10px; }
        .btn-approve { background-color: #10B981; color: white; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.2); }
        .btn-approve:hover { background-color: #059669; transform: translateY(-2px); }
        .btn-reject { background-color: #FEE2E2; color: #DC2626; border: 1px solid #FECACA; }
        .btn-reject:hover { background-color: #FCA5A5; color: white; transform: translateY(-2px); }

        .btn-back { display: inline-flex; align-items: center; gap: 8px; color: var(--text-gray); font-weight: 600; text-decoration: none; margin-bottom: 20px; transition: 0.2s; }
        .btn-back:hover { color: var(--primary-blue); }

        /* Status Badge */
        .status-badge { display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; }
        .status-pending { background-color: #FFFBEB; color: #D97706; border: 1px solid #FDE68A; }

        /* --- RESPONSIVE --- */
        .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 99; transition: 0.3s; }
        
        @media (max-width: 992px) {
            .action-panel { position: static; margin-top: 25px; }
        }
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

    @php
        $userRole = strtolower(trim(Auth::user()->role));
        $reqId = request()->route('id');
        $req = \App\Models\TravelRequest::with(['user'])->find($reqId);
        
        $canApprove = false;
        if($req) {
            $status = strtolower(trim($req->status));
            if(in_array($userRole, ['manager', 'hrd', 'kepala marketing']) && $status == 'pending_l1') {
                $canApprove = true;
            } elseif($userRole == 'finance' && $status == 'pending_l2') {
                $canApprove = true;
            }
        }
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
                    <li><a href="{{ route('approvals.index') ?? '#' }}" class="menu-item active"><i class="fas fa-file-signature menu-icon"></i><span class="menu-text">Persetujuan SPPD</span></a></li>
                    <li><a href="{{ route('manager.history') ?? '#' }}" class="menu-item"><i class="fas fa-history menu-icon"></i><span class="menu-text">Riwayat Proses</span></a></li>
                    <li><a href="{{ route('manager.pengajuan.create') ?? '#' }}" class="menu-item"><i class="fas fa-paper-plane menu-icon"></i><span class="menu-text">Buat Pengajuan</span></a></li>
                    <li><a href="{{ route('manager.settings') ?? '#' }}" class="menu-item"><i class="fas fa-gear menu-icon"></i><span class="menu-text">Settings</span></a></li>
                @elseif($userRole == 'finance')
                    <li><a href="{{ route('finance.dashboard') ?? '#' }}" class="menu-item"><i class="fas fa-border-all menu-icon"></i><span class="menu-text">Dashboard</span></a></li>
                    <li><a href="{{ route('approvals.index') ?? '#' }}" class="menu-item active"><i class="fas fa-file-invoice-dollar menu-icon"></i><span class="menu-text">Antrean Pencairan</span></a></li>
                    <li><a href="{{ route('finance.history') ?? '#' }}" class="menu-item"><i class="fas fa-history menu-icon"></i><span class="menu-text">Riwayat Pencairan</span></a></li>
                    <li><a href="{{ route('finance.settings') ?? '#' }}" class="menu-item"><i class="fas fa-gear menu-icon"></i><span class="menu-text">Settings</span></a></li>
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
                    <h5 class="mb-0 fw-bold ms-3 d-none d-md-block">Review Dokumen SPPD</h5>
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
                
                <a href="{{ url()->previous() }}" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali</a>

                @if(!$req)
                    <div class="alert alert-danger">Dokumen tidak ditemukan atau terjadi kesalahan dalam memuat data.</div>
                @else

                <div class="row">
                    <!-- KOLOM KIRI: DATA PENGAJUAN -->
                    <div class="col-lg-8">
                        <div class="detail-card">
                            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                                <div>
                                    <h4 class="fw-bold mb-1">Pengajuan Perjalanan Dinas (UC)</h4>
                                    <p class="text-muted small m-0">Tgl Dibuat: {{ \Carbon\Carbon::parse($req->created_at)->format('d F Y, H:i') }} WITA</p>
                                </div>
                                <div class="status-badge status-pending">
                                    <i class="fas fa-info-circle"></i> Status: {{ strtoupper(str_replace('_', ' ', $req->status)) }}
                                </div>
                            </div>

                            <div class="section-title"><i class="fas fa-user"></i> 1. Identitas Pemohon</div>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <div class="info-group">
                                        <div class="info-label">Nama Pegawai</div>
                                        <div class="info-value">{{ $req->user->name ?? 'User Dihapus' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-group">
                                        <div class="info-label">Jabatan / Divisi</div>
                                        <div class="info-value">{{ ucfirst($req->user->role ?? '-') }} / {{ $req->user->division ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="section-title"><i class="fas fa-map-marked-alt"></i> 2. Rute & Jadwal</div>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <div class="info-group">
                                        <div class="info-label">Rute Perjalanan</div>
                                        <div class="info-value text-primary">
                                            {{ $req->departure }} <i class="fas fa-arrow-right mx-2 text-muted"></i> {{ $req->destination }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-group">
                                        <div class="info-label">Tanggal Pelaksanaan</div>
                                        <div class="info-value">
                                            {{ \Carbon\Carbon::parse($req->start_date)->format('d M Y') }} s.d {{ \Carbon\Carbon::parse($req->end_date)->format('d M Y') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="section-title"><i class="fas fa-users"></i> 3. Tim & Operasional</div>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <div class="info-group">
                                        <div class="info-label">Transportasi yang Digunakan</div>
                                        <div class="info-value">
                                            @if($req->transportation_type == 'Darat')
                                                <i class="fas fa-car text-muted me-2"></i> Darat 
                                                @if($req->vehicle_number)
                                                    <span class="badge bg-secondary ms-2">{{ $req->vehicle_number }}</span>
                                                @endif
                                            @elseif($req->transportation_type == 'Udara')
                                                <i class="fas fa-plane text-muted me-2"></i> Udara
                                            @else
                                                <i class="fas fa-ship text-muted me-2"></i> Laut
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-group">
                                        <div class="info-label">Pendamping</div>
                                        <div class="info-value">
                                            @if($req->companion_1 || $req->companion_2)
                                                <ul class="mb-0 ps-3">
                                                    @if($req->companion_1) <li>{{ $req->companion_1 }}</li> @endif
                                                    @if($req->companion_2) <li>{{ $req->companion_2 }}</li> @endif
                                                </ul>
                                            @else
                                                <span class="text-muted fst-italic">Berangkat sendiri (Tidak ada)</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Menambahkan Rincian Biaya yang Bisa Diedit Finance -->
                            <div class="section-title"><i class="fas fa-file-invoice-dollar"></i> 4. Rincian Estimasi Biaya</div>
                            
                            @if($userRole == 'finance' && $canApprove)
                                <div class="alert alert-info" style="border-radius: 10px; font-size: 13px;">
                                    <i class="fas fa-info-circle me-2"></i> <strong>Mode Edit Finance:</strong> Nominal di bawah adalah estimasi awal dari sistem berdasarkan jumlah hari. Anda dapat menyesuaikannya sebelum mencairkan dana.
                                </div>
                            @endif

                            <div class="row g-3">
                                <div class="col-md-3">
                                    <div class="info-group">
                                        <div class="info-label">Uang Makan</div>
                                        @if($userRole == 'finance' && $canApprove)
                                            <!-- Field Edit untuk Finance, ditautkan ke form persetujuan (form="approvalForm") -->
                                            <div class="input-group">
                                                <span class="input-group-text rp-text">Rp</span>
                                                <input type="number" name="biaya_makan" id="biaya_makan" form="approvalForm" class="form-control input-custom" style="border-radius: 0 10px 10px 0;" value="{{ $req->biaya_makan ?? 0 }}" oninput="calculateTotal()" required>
                                            </div>
                                        @else
                                            <div class="info-value text-center" style="font-size: 13px;">Rp {{ number_format($req->biaya_makan ?? 0, 0, ',', '.') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-group">
                                        <div class="info-label">Penginapan</div>
                                        @if($userRole == 'finance' && $canApprove)
                                            <div class="input-group">
                                                <span class="input-group-text rp-text">Rp</span>
                                                <input type="number" name="biaya_penginapan" id="biaya_penginapan" form="approvalForm" class="form-control input-custom" style="border-radius: 0 10px 10px 0;" value="{{ $req->biaya_penginapan ?? 0 }}" oninput="calculateTotal()" required>
                                            </div>
                                        @else
                                            <div class="info-value text-center" style="font-size: 13px;">Rp {{ number_format($req->biaya_penginapan ?? 0, 0, ',', '.') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-group">
                                        <div class="info-label">Bensin / Trans.</div>
                                        @if($userRole == 'finance' && $canApprove)
                                            <div class="input-group">
                                                <span class="input-group-text rp-text">Rp</span>
                                                <input type="number" name="biaya_bensin" id="biaya_bensin" form="approvalForm" class="form-control input-custom" style="border-radius: 0 10px 10px 0;" value="{{ $req->biaya_bensin ?? 0 }}" oninput="calculateTotal()" required>
                                            </div>
                                        @else
                                            <div class="info-value text-center" style="font-size: 13px;">Rp {{ number_format($req->biaya_bensin ?? 0, 0, ',', '.') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-group">
                                        <div class="info-label text-primary fw-bold">Total Biaya</div>
                                        @if($userRole == 'finance' && $canApprove)
                                            <div class="input-group">
                                                <span class="input-group-text" style="background-color: #E5F0FF; border: 1px solid #CBD5E1; color: var(--primary-blue); font-weight: 700; font-size: 14px; border-radius: 10px 0 0 10px;">Rp</span>
                                                <input type="number" name="total_biaya" id="total_biaya" form="approvalForm" class="form-control input-custom fw-bold text-primary" style="border-radius: 0 10px 10px 0; background-color: #F8FAFC;" value="{{ $req->total_biaya ?? 0 }}" readonly>
                                            </div>
                                        @else
                                            <div class="info-value text-center text-white bg-primary border-primary fw-bold" style="font-size: 13px;">Rp {{ number_format($req->total_biaya ?? 0, 0, ',', '.') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Riwayat Catatan -->
                            @if($req->l1_note || $req->l2_note)
                                <div class="mt-4 pt-3 border-top">
                                    <h6 class="fw-bold mb-3"><i class="fas fa-comments text-muted me-2"></i> Riwayat Catatan:</h6>
                                    @if($req->l1_note)
                                    <div class="alert mb-2" style="background-color: #FFFBEB; border-left: 4px solid #F59E0B; color: #92400E;">
                                        <strong>Manajer (L1):</strong> "{{ $req->l1_note }}"
                                    </div>
                                    @endif
                                    @if($req->l2_note)
                                    <div class="alert mb-0" style="background-color: #EFF6FF; border-left: 4px solid #3B82F6; color: #1E3A8A;">
                                        <strong>Finance (L2):</strong> "{{ $req->l2_note }}"
                                    </div>
                                    @endif
                                </div>
                            @endif

                        </div>
                    </div>

                    <!-- KOLOM KANAN: PANEL AKSI -->
                    <div class="col-lg-4">
                        <div class="action-panel">
                            
                            @if($canApprove)
                                <!-- MODE TINDAKAN -->
                                <h5>Tindakan Persetujuan</h5>
                                <p class="text-muted small mb-4">Silakan periksa dokumen di atas dengan cermat. Berikan catatan opsional dan tentukan keputusan Anda.</p>

                                <form action="{{ route('approvals.process', $req->id) }}" method="POST" id="approvalForm">
                                    @csrf
                                    <input type="hidden" name="action" id="approvalAction" value="">
                                    
                                    <textarea name="note" class="form-control form-control-note" rows="4" placeholder="Tulis catatan atau alasan Anda di sini (Opsional)..."></textarea>
                                    
                                    <button type="button" class="btn-action btn-approve" onclick="confirmAction('approve')">
                                        <i class="fas fa-check-circle"></i> 
                                        @if($userRole == 'finance') Transfer & Cairkan Dana @else Setujui Pengajuan (ACC) @endif
                                    </button>
                                    
                                    <button type="button" class="btn-action btn-reject" onclick="confirmAction('reject')">
                                        <i class="fas fa-times-circle"></i> Tolak Pengajuan
                                    </button>
                                </form>
                            @else
                                <!-- MODE BACA SAJA (Read Only) -->
                                <h5>Status Dokumen</h5>
                                <p class="text-muted small mb-4">Anda tidak dapat melakukan tindakan (ACC/Tolak) karena dokumen ini telah diproses atau saat ini bukan wewenang Anda.</p>
                                
                                <div class="alert text-center p-4 border-0
                                    @if($req->status == 'approved') bg-success-light text-success
                                    @elseif($req->status == 'rejected') bg-danger-light text-danger
                                    @else bg-info-light text-primary @endif">
                                    
                                    @if($req->status == 'approved')
                                        <i class="fas fa-check-circle fa-3x mb-2"></i>
                                        <h6 class="fw-bold m-0">Telah Disetujui</h6>
                                    @elseif($req->status == 'rejected')
                                        <i class="fas fa-times-circle fa-3x mb-2"></i>
                                        <h6 class="fw-bold m-0">Telah Ditolak</h6>
                                    @else
                                        <i class="fas fa-hourglass-half fa-3x mb-2"></i>
                                        <h6 class="fw-bold m-0 text-uppercase">{{ str_replace('_', ' ', $req->status) }}</h6>
                                    @endif
                                </div>
                                
                                <!-- Tombol Cetak PDF -->
                                @if($req->status == 'approved')
                                    <a href="{{ route('pengajuan.cetak', $req->id) }}" target="_blank" class="btn btn-danger w-100 mt-3" style="border-radius: 10px; font-weight: 600; padding: 12px;">
                                        <i class="fas fa-file-pdf me-2"></i> Unduh PDF Dokumen
                                    </a>
                                @endif
                            @endif

                        </div>
                    </div>
                </div>

                @endif

            </main>
        </div>
    </div>

    <!-- PENTING: Panggil library SweetAlert2 untuk Popup -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // --- LOGIKA MENGHITUNG TOTAL BIAYA SECARA REAL-TIME ---
        function calculateTotal() {
            let makan = parseFloat(document.getElementById('biaya_makan').value) || 0;
            let penginapan = parseFloat(document.getElementById('biaya_penginapan').value) || 0;
            let bensin = parseFloat(document.getElementById('biaya_bensin').value) || 0;
            
            let total = makan + penginapan + bensin;
            
            // Masukkan hasil ke input total_biaya
            document.getElementById('total_biaya').value = total;
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

        // --- KONFIRMASI TINDAKAN DENGAN SWEETALERT ---
        function confirmAction(actionType) {
            const isApprove = actionType === 'approve';
            const actionText = isApprove ? 'Menyetujui' : 'Menolak';
            const btnColor = isApprove ? '#10B981' : '#DC2626';

            Swal.fire({
                title: 'Konfirmasi ' + actionText,
                text: "Apakah Anda yakin ingin " + actionText.toLowerCase() + " pengajuan ini?",
                icon: isApprove ? 'question' : 'warning',
                showCancelButton: true,
                confirmButtonColor: btnColor,
                cancelButtonColor: '#94A3B8',
                confirmButtonText: 'Ya, ' + actionText + '!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Set nilai hidden input action
                    document.getElementById('approvalAction').value = actionType;
                    
                    // Tampilkan loading & submit form
                    Swal.fire({
                        title: 'Memproses...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    document.getElementById('approvalForm').submit();
                }
            });
        }
    </script>
</body>
</html>