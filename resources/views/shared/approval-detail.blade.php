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

        body { font-family: 'Poppins', sans-serif; background-color: #F8FAFC; margin: 0; overflow-x: hidden; }
        .wrapper { display: flex; height: 100vh; }

        /* --- SIDEBAR --- */
        .sidebar { width: var(--sidebar-width); background-color: var(--sidebar-bg); border-right: 1px solid var(--border-color); display: flex; flex-direction: column; transition: all 0.3s ease; position: relative; z-index: 100; height: 100vh; }
        .sidebar.collapsed { width: var(--sidebar-collapsed-width); }
        .logo-area { height: 80px; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .logo-img { max-width: 140px; }
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
        .top-navbar { height: 80px; background-color: #FFFFFF; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; padding: 0 30px; }
        .nav-left { display: flex; align-items: center; gap: 20px; }
        .hamburger-btn { background: none; border: none; font-size: 24px; color: var(--text-dark); cursor: pointer; padding: 0; }
        .user-profile { display: flex; align-items: center; gap: 12px; }
        .user-info { text-align: right; line-height: 1.2; }
        .user-name { font-weight: 600; font-size: 14px; color: var(--text-dark); margin: 0; }
        .user-role { font-size: 11px; color: var(--text-gray); margin: 0; text-transform: uppercase; }
        .user-avatar { font-size: 32px; color: var(--primary-blue); }
        .content-area { padding: 30px 40px; flex-grow: 1; overflow-y: auto; }

        /* --- DETAIL CARD STYLING --- */
        .detail-card { background: white; border-radius: 16px; border: 1px solid var(--border-color); padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); max-width: 900px; margin: 0 auto; }
        .detail-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px dashed var(--border-color); padding-bottom: 20px; margin-bottom: 30px; }
        .doc-title { font-size: 22px; font-weight: 700; color: var(--primary-blue); margin: 0; }
        .doc-id { font-size: 14px; color: var(--text-gray); font-weight: 600; }
        
        .section-title { font-size: 14px; font-weight: 700; color: var(--text-gray); text-transform: uppercase; margin-bottom: 15px; letter-spacing: 0.5px; }
        
        .info-group { margin-bottom: 20px; }
        .info-label { font-size: 12px; color: var(--text-gray); margin-bottom: 4px; }
        .info-value { font-size: 15px; font-weight: 600; color: var(--text-dark); }

        .timeline-box { background: #F8FAFC; border: 1px solid var(--border-color); border-radius: 12px; padding: 20px; margin-bottom: 15px; }
        .timeline-box.success { border-left: 4px solid #10B981; }
        .timeline-box.warning { border-left: 4px solid #F59E0B; }
        .timeline-box.danger { border-left: 4px solid #EF4444; }

        /* Buttons */
        .action-bar { display: flex; justify-content: space-between; align-items: center; margin-top: 40px; padding-top: 20px; border-top: 1px solid var(--border-color); }
        .btn-back { background: white; border: 1px solid var(--border-color); color: var(--text-dark); padding: 10px 20px; border-radius: 8px; font-weight: 600; text-decoration: none; transition: 0.2s; }
        .btn-back:hover { background: #F1F5F9; color: var(--text-dark); }
        
        .btn-action { border-radius: 8px; padding: 10px 25px; font-weight: 600; font-size: 14px; transition: 0.2s; border: none; color: white; display: inline-flex; align-items: center; gap: 8px; }
        .btn-approve { background: #10B981; }
        .btn-approve:hover { background: #059669; transform: translateY(-2px); }
        .btn-reject { background: #EF4444; }
        .btn-reject:hover { background: #DC2626; transform: translateY(-2px); }

        /* Responsive */
        .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 99; transition: 0.3s; }
        @media (max-width: 768px) {
            .sidebar { position: fixed; left: -100%; box-shadow: 4px 0 15px rgba(0,0,0,0.1); }
            .sidebar.mobile-active { left: 0; }
            .sidebar-overlay.active { display: block; }
            .main-content { width: 100%; }
            .content-area { padding: 15px; }
            .detail-card { padding: 25px; }
            .action-bar { flex-direction: column-reverse; gap: 15px; }
            .action-bar > div, .btn-back { width: 100%; text-align: center; }
            .btn-action { width: 100%; justify-content: center; margin-bottom: 10px; }
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
                @if(in_array(Auth::user()->role, ['manager', 'hrd', 'kepala marketing']))
                    <li><a href="{{ route('manager.dashboard') ?? '#' }}" class="menu-item"><i class="fas fa-border-all menu-icon"></i><span class="menu-text">Dashboard</span></a></li>
                @elseif(Auth::user()->role == 'finance')
                    <li><a href="{{ route('finance.dashboard') ?? '#' }}" class="menu-item"><i class="fas fa-border-all menu-icon"></i><span class="menu-text">Dashboard Finance</span></a></li>
                @endif
                <li><a href="{{ route('approvals.index') }}" class="menu-item active"><i class="fas fa-file-signature menu-icon"></i><span class="menu-text">Daftar Persetujuan</span></a></li>
                @if(in_array(Auth::user()->role, ['manager', 'hrd', 'kepala marketing']))
                    <li><a href="{{ route('manager.settings') ?? '#' }}" class="menu-item"><i class="fas fa-gear menu-icon"></i><span class="menu-text">Settings</span></a></li>
                @endif
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
                    <h5 class="mb-0 fw-bold ms-3 d-none d-md-block">Detail Dokumen</h5>
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
                <div class="detail-card">
                    
                    <div class="detail-header">
                        <div>
                            <h2 class="doc-title">Formulir Pengajuan SPPD</h2>
                            <p class="doc-id mb-0">No. Registrasi: #SPPD-{{ str_pad($pengajuan->id, 4, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div class="text-end">
                            <span class="badge {{ $pengajuan->status == 'approved' ? 'bg-success' : ($pengajuan->status == 'rejected' ? 'bg-danger' : 'bg-warning text-dark') }} px-3 py-2" style="font-size: 14px; border-radius: 8px;">
                                @if($pengajuan->status == 'pending_l1') Menunggu L1 (Manajer)
                                @elseif($pengajuan->status == 'pending_l2') Menunggu L2 (Finance)
                                @elseif($pengajuan->status == 'approved') Disetujui Penuh
                                @else Ditolak @endif
                            </span>
                            <div class="mt-2 text-muted" style="font-size: 12px;">Diajukan: {{ \Carbon\Carbon::parse($pengajuan->created_at)->format('d M Y, H:i') }}</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 border-end pe-md-4">
                            <h6 class="section-title"><i class="fas fa-user-tie me-2"></i> Informasi Pemohon</h6>
                            <div class="info-group">
                                <div class="info-label">Nama Lengkap</div>
                                <div class="info-value">{{ $pengajuan->user->name }}</div>
                            </div>
                            <div class="info-group">
                                <div class="info-label">Posisi / Divisi</div>
                                <div class="info-value" style="text-transform: capitalize;">{{ $pengajuan->user->role }} / {{ $pengajuan->user->division ?? 'Operasional' }}</div>
                            </div>

                            <h6 class="section-title mt-5"><i class="fas fa-map-marked-alt me-2"></i> Rincian Perjalanan</h6>
                            <div class="info-group">
                                <div class="info-label">Kota Tujuan</div>
                                <div class="info-value text-primary"><i class="fas fa-map-marker-alt me-1"></i> {{ $pengajuan->destination }}</div>
                            </div>
                            <div class="info-group">
                                <div class="info-label">Tanggal Pelaksanaan</div>
                                <div class="info-value">{{ \Carbon\Carbon::parse($pengajuan->start_date)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($pengajuan->end_date)->format('d M Y') }}</div>
                            </div>
                            <div class="info-group">
                                <div class="info-label">Keperluan / Agenda</div>
                                <div class="info-value p-3 bg-light rounded mt-1" style="font-weight: 500;">"{{ $pengajuan->purpose }}"</div>
                            </div>
                        </div>

                        <div class="col-md-6 ps-md-4 mt-4 mt-md-0">
                            <h6 class="section-title"><i class="fas fa-clipboard-check me-2"></i> Rekam Jejak Persetujuan</h6>
                            
                            <div class="timeline-box {{ $pengajuan->l1_approver_id ? ($pengajuan->status == 'rejected' && !$pengajuan->l2_approver_id ? 'danger' : 'success') : 'warning' }}">
                                <h6 class="fw-bold mb-1" style="font-size: 14px;">Tahap 1: Manajer / HRD</h6>
                                @if($pengajuan->l1_approver_id)
                                    <p class="mb-1" style="font-size: 13px;">Diperiksa oleh: <strong>{{ $pengajuan->l1Approver->name }}</strong></p>
                                    @if($pengajuan->l1_note)
                                        <div class="p-2 bg-white border rounded small fst-italic">"{{ $pengajuan->l1_note }}"</div>
                                    @endif
                                @else
                                    <p class="text-muted small mb-0"><i class="fas fa-hourglass-half me-1"></i> Sedang menunggu antrean pemeriksaan.</p>
                                @endif
                            </div>

                            <div class="timeline-box {{ $pengajuan->l2_approver_id ? ($pengajuan->status == 'rejected' ? 'danger' : 'success') : ($pengajuan->status == 'pending_l2' ? 'warning' : '') }}">
                                <h6 class="fw-bold mb-1" style="font-size: 14px;">Tahap 2: Finance</h6>
                                @if($pengajuan->l2_approver_id)
                                    <p class="mb-1" style="font-size: 13px;">Dicairkan oleh: <strong>{{ $pengajuan->l2Approver->name }}</strong></p>
                                    @if($pengajuan->l2_note)
                                        <div class="p-2 bg-white border rounded small fst-italic">"{{ $pengajuan->l2_note }}"</div>
                                    @endif
                                @elseif($pengajuan->status == 'pending_l2')
                                    <p class="text-muted small mb-0"><i class="fas fa-hourglass-half me-1"></i> Sedang menunggu antrean pencairan dana.</p>
                                @else
                                    <p class="text-muted small mb-0 opacity-50">Menunggu Tahap 1 selesai.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="action-bar">
                        <a href="{{ route('approvals.index') }}" class="btn-back"><i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar</a>
                        
                        <div>
                            @if( (in_array(Auth::user()->role, ['manager', 'hrd', 'kepala marketing']) && $pengajuan->status == 'pending_l1') || 
                                 (Auth::user()->role == 'finance' && $pengajuan->status == 'pending_l2') )
                                
                                <button type="button" class="btn-action btn-reject" data-bs-toggle="modal" data-bs-target="#modalAction" onclick="setupModal('reject')">
                                    <i class="fas fa-times"></i> Tolak Pengajuan
                                </button>
                                
                                <button type="button" class="btn-action btn-approve ms-md-2" data-bs-toggle="modal" data-bs-target="#modalAction" onclick="setupModal('approve')">
                                    <i class="fas fa-check"></i> Setujui Pengajuan
                                </button>

                            @endif
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <div class="modal fade" id="modalAction" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px; border: none;">
                <form action="{{ route('approvals.process', $pengajuan->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="action" id="actionInput">
                    <div class="modal-header border-0 p-4 pb-0">
                        <h5 class="modal-title fw-bold" id="modalTitle">Konfirmasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <p class="text-muted small mb-3">Tambahkan catatan instruksi atau alasan Anda.</p>
                        <textarea name="note" id="noteInput" class="form-control" rows="4" style="border-radius: 8px; background: #FAFAFA;"></textarea>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn fw-bold" id="submitBtn" style="color: white;"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        document.getElementById('toggleSidebar').addEventListener('click', () => {
            if (window.innerWidth <= 768) { sidebar.classList.toggle('mobile-active'); overlay.classList.toggle('active'); } 
            else { sidebar.classList.toggle('collapsed'); }
        });
        overlay.addEventListener('click', () => { sidebar.classList.remove('mobile-active'); overlay.classList.remove('active'); });

        // Setup Modal
        function setupModal(type) {
            document.getElementById('actionInput').value = type;
            const title = document.getElementById('modalTitle');
            const submitBtn = document.getElementById('submitBtn');
            const noteInput = document.getElementById('noteInput');
            
            if (type === 'approve') {
                title.innerText = 'Setujui Pengajuan'; title.style.color = '#10B981';
                submitBtn.innerText = 'Setujui Sekarang'; submitBtn.style.backgroundColor = '#10B981';
                noteInput.removeAttribute('required');
            } else {
                title.innerText = 'Tolak Pengajuan'; title.style.color = '#EF4444';
                submitBtn.innerText = 'Tolak Pengajuan'; submitBtn.style.backgroundColor = '#EF4444';
                noteInput.setAttribute('required', 'required');
            }
        }
    </script>
</body>
</html>