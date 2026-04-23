<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lacak Pengajuan - Satu Sanzaya</title>
    
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
            --success-color: #10B981;
            --reject-color: #EF4444;
        }

        body { font-family: 'Poppins', sans-serif; background-color: #F8FAFC; margin: 0; overflow-x: hidden; }
        .wrapper { display: flex; height: 100vh; }

        /* --- SIDEBAR --- */
        .sidebar { width: var(--sidebar-width); background-color: var(--sidebar-bg); border-right: 1px solid var(--border-color); display: flex; flex-direction: column; transition: all 0.3s ease; position: relative; z-index: 100; height: 100vh; }
        .sidebar.collapsed { width: var(--sidebar-collapsed-width); }
        .logo-area { height: 80px; display: flex; align-items: center; justify-content: center; padding: 20px; transition: 0.3s; }
        .logo-img { max-width: 140px; }
        .sidebar.collapsed .logo-img { max-width: 40px; }
        .sidebar-menu { list-style: none; padding: 20px 10px; margin: 0; flex-grow: 1; }
        .menu-item { display: flex; align-items: center; padding: 12px 20px; color: var(--text-gray); text-decoration: none; border-radius: 10px; margin-bottom: 5px; transition: 0.2s; font-weight: 500; font-size: 14px; white-space: nowrap; }
        .menu-item:hover { background-color: var(--border-color); color: var(--text-dark); }
        .menu-item.active { background-color: var(--light-blue); color: var(--primary-blue); font-weight: 600; }
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
        .user-profile { display: flex; align-items: center; gap: 12px; }
        .user-info { text-align: right; line-height: 1.2; }
        .user-name { font-weight: 600; font-size: 14px; color: var(--text-dark); margin: 0; }
        .user-role { font-size: 11px; color: var(--text-gray); margin: 0; text-transform: uppercase; }
        .user-avatar { font-size: 32px; color: var(--primary-blue); }
        .content-area { padding: 30px 40px; flex-grow: 1; overflow-y: auto; }

        /* --- TRACKING CARD & STEPPER --- */
        .track-card { background: white; border-radius: 16px; border: 1px solid var(--border-color); padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); max-width: 900px; margin: 0 auto; }
        .doc-header { border-bottom: 1px dashed var(--border-color); padding-bottom: 20px; margin-bottom: 40px; display: flex; justify-content: space-between; align-items: center; }
        
        /* Stepper CSS */
        .stepper-wrapper { display: flex; justify-content: space-between; position: relative; margin-bottom: 50px; }
        .stepper-wrapper::before { content: ""; position: absolute; top: 20px; left: 0; width: 100%; height: 3px; background-color: var(--border-color); z-index: 1; }
        
        /* Progress Line Dynamics */
        @php
            $progressWidth = '0%';
            if($pengajuan->status == 'pending_l1') $progressWidth = '15%';
            elseif($pengajuan->status == 'pending_l2') $progressWidth = '50%';
            elseif($pengajuan->status == 'approved') $progressWidth = '100%';
            elseif($pengajuan->status == 'rejected' && !$pengajuan->l1_approver_id) $progressWidth = '15%';
            elseif($pengajuan->status == 'rejected' && $pengajuan->l1_approver_id) $progressWidth = '50%';
        @endphp
        
        .stepper-progress { position: absolute; top: 20px; left: 0; height: 3px; background-color: var(--primary-blue); z-index: 2; transition: 0.5s; width: {{ $progressWidth }}; }
        .stepper-progress.rejected { background-color: var(--reject-color); }
        .stepper-progress.completed { background-color: var(--success-color); }

        .step-item { position: relative; z-index: 3; text-align: center; width: 25%; }
        .step-circle { width: 44px; height: 44px; background-color: white; border: 3px solid var(--border-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: bold; color: var(--text-gray); transition: 0.3s; }
        .step-title { font-size: 14px; font-weight: 600; color: var(--text-gray); margin-bottom: 5px; }
        .step-desc { font-size: 11px; color: var(--text-gray); line-height: 1.4; }

        /* States */
        .step-item.active .step-circle { border-color: var(--primary-blue); background-color: var(--primary-blue); color: white; box-shadow: 0 0 0 5px var(--light-blue); }
        .step-item.active .step-title { color: var(--primary-blue); }
        
        .step-item.completed .step-circle { border-color: var(--success-color); background-color: var(--success-color); color: white; }
        .step-item.completed .step-title { color: var(--success-color); }
        
        .step-item.rejected .step-circle { border-color: var(--reject-color); background-color: var(--reject-color); color: white; box-shadow: 0 0 0 5px #FEE2E2; }
        .step-item.rejected .step-title { color: var(--reject-color); }

        /* Note Box */
        .note-box { background: #F8FAFC; border: 1px solid var(--border-color); border-radius: 12px; padding: 20px; margin-top: 20px; }

        @media (max-width: 768px) {
            .sidebar { position: fixed; left: -100%; }
            .sidebar.mobile-active { left: 0; }
            .main-content { width: 100%; }
            .content-area { padding: 15px; }
            .track-card { padding: 25px; }
            .step-title { font-size: 11px; }
            .step-desc { display: none; }
            .doc-header { flex-direction: column; align-items: flex-start; gap: 10px; }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <aside class="sidebar" id="sidebar">
            <div class="logo-area"><img src="{{ asset('img/logo.svg') }}" alt="Logo" class="logo-img"></div>
            <ul class="sidebar-menu">
                <li><a href="{{ route('staff.dashboard') }}" class="menu-item"><i class="fas fa-border-all menu-icon"></i><span class="menu-text">Dashboard</span></a></li>
                <li><a href="{{ route('staff.riwayat') }}" class="menu-item active"><i class="fas fa-clock-rotate-left menu-icon"></i><span class="menu-text">Riwayat Pengajuan</span></a></li>
                <li><a href="{{ route('staff.pengajuan.create') }}" class="menu-item"><i class="fas fa-file-lines menu-icon"></i><span class="menu-text">Pengajuan SPPD</span></a></li>
                <li><a href="{{ route('staff.settings') }}" class="menu-item"><i class="fas fa-gear menu-icon"></i><span class="menu-text">Settings</span></a></li>
            </ul>
            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">@csrf</form>
                <a href="#" class="menu-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-arrow-right-from-bracket menu-icon"></i><span class="menu-text">Keluar</span>
                </a>
            </div>
        </aside>

        <div class="main-content">
            <header class="top-navbar">
                <div class="nav-left">
                    <button class="hamburger-btn" id="toggleSidebar"><i class="fas fa-bars"></i></button>
                    <h5 class="fw-bold m-0 ms-3 d-none d-md-block">Status Perjalanan Dinas</h5>
                </div>
                <div class="nav-right">
                    <div class="user-profile">
                        <div class="user-info">
                            <p class="user-name">{{ Auth::user()->name }}</p>
                            <p class="user-role">{{ Auth::user()->role }}</p>
                        </div>
                        <i class="fas fa-user-circle user-avatar"></i>
                    </div>
                </div>
            </header>

            <main class="content-area">
                <div class="track-card">
                    
                    <div class="doc-header">
                        <div>
                            <h4 class="fw-bold text-dark mb-1">Tujuan: {{ $pengajuan->destination }}</h4>
                            <p class="text-muted mb-0 small">Kode Berkas: #SPPD-{{ str_pad($pengajuan->id, 4, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <a href="{{ route('staff.riwayat') }}" class="btn btn-light border fw-bold px-4 rounded-3"><i class="fas fa-arrow-left me-2"></i> Kembali</a>
                    </div>

                    <div class="stepper-wrapper">
                        <div class="stepper-progress {{ $pengajuan->status == 'rejected' ? 'rejected' : ($pengajuan->status == 'approved' ? 'completed' : '') }}"></div>
                        
                        <div class="step-item completed">
                            <div class="step-circle"><i class="fas fa-file-alt"></i></div>
                            <div class="step-title">1. Diajukan</div>
                            <div class="step-desc">{{ \Carbon\Carbon::parse($pengajuan->created_at)->format('d M Y, H:i') }}</div>
                        </div>

                        <div class="step-item 
                            {{ in_array($pengajuan->status, ['pending_l2', 'approved']) ? 'completed' : '' }} 
                            {{ $pengajuan->status == 'pending_l1' ? 'active' : '' }}
                            {{ $pengajuan->status == 'rejected' && !$pengajuan->l1_approver_id ? 'rejected' : '' }}">
                            
                            <div class="step-circle">
                                @if(in_array($pengajuan->status, ['pending_l2', 'approved'])) <i class="fas fa-check"></i>
                                @elseif($pengajuan->status == 'rejected' && !$pengajuan->l1_approver_id) <i class="fas fa-times"></i>
                                @else 2 @endif
                            </div>
                            <div class="step-title">2. Pengecekan Manajer</div>
                            <div class="step-desc">
                                @if($pengajuan->l1_approver_id) ACC oleh {{ $pengajuan->l1Approver->name }}
                                @elseif($pengajuan->status == 'rejected') Ditolak Manajer
                                @else Menunggu Antrean @endif
                            </div>
                        </div>

                        <div class="step-item 
                            {{ $pengajuan->status == 'approved' ? 'completed' : '' }} 
                            {{ $pengajuan->status == 'pending_l2' ? 'active' : '' }}
                            {{ $pengajuan->status == 'rejected' && $pengajuan->l1_approver_id ? 'rejected' : '' }}">
                            
                            <div class="step-circle">
                                @if($pengajuan->status == 'approved') <i class="fas fa-check"></i>
                                @elseif($pengajuan->status == 'rejected' && $pengajuan->l1_approver_id) <i class="fas fa-times"></i>
                                @else 3 @endif
                            </div>
                            <div class="step-title">3. Pencairan Finance</div>
                            <div class="step-desc">
                                @if($pengajuan->status == 'approved') Dana Dicairkan
                                @elseif($pengajuan->status == 'rejected' && $pengajuan->l1_approver_id) Ditolak Finance
                                @elseif($pengajuan->status == 'pending_l2') Menunggu Finance @endif
                            </div>
                        </div>

                        <div class="step-item 
                            {{ $pengajuan->status == 'approved' ? 'completed' : '' }}
                            {{ $pengajuan->status == 'rejected' ? 'rejected' : '' }}">
                            <div class="step-circle">
                                @if($pengajuan->status == 'approved') <i class="fas fa-flag-checkered"></i>
                                @elseif($pengajuan->status == 'rejected') <i class="fas fa-ban"></i>
                                @else 4 @endif
                            </div>
                            <div class="step-title">4. Selesai</div>
                            <div class="step-desc">
                                @if($pengajuan->status == 'approved') PDF Siap Unduh
                                @elseif($pengajuan->status == 'rejected') Proses Berhenti @endif
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-6">
                            <div class="note-box">
                                <h6 class="text-uppercase text-muted fw-bold" style="font-size: 11px;">Komentar Manajer / HRD</h6>
                                <p class="mb-0 fw-500 {{ !$pengajuan->l1_note ? 'text-muted fst-italic' : 'text-dark' }}">
                                    {{ $pengajuan->l1_note ?? 'Belum ada catatan.' }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="note-box">
                                <h6 class="text-uppercase text-muted fw-bold" style="font-size: 11px;">Komentar Tim Finance</h6>
                                <p class="mb-0 fw-500 {{ !$pengajuan->l2_note ? 'text-muted fst-italic' : 'text-dark' }}">
                                    {{ $pengajuan->l2_note ?? 'Belum ada catatan.' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($pengajuan->status == 'approved')
                    <div class="text-center mt-5">
                        <a href="{{ route('staff.pengajuan.pdf', $pengajuan->id) }}" class="btn btn-lg px-5 text-white shadow-sm" style="background-color: var(--success-color); border-radius: 12px; font-weight: 600;">
                            <i class="fas fa-download me-2"></i> Unduh Surat SPPD (PDF)
                        </a>
                    </div>
                    @endif

                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle(window.innerWidth <= 768 ? 'mobile-active' : 'collapsed');
        });
    </script>
</body>
</html>