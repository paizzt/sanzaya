<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Persetujuan SPPD - Satu Sanzaya</title>
    
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
        .top-navbar { height: 80px; background-color: #FFFFFF; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; padding: 0 30px; }
        .nav-left { display: flex; align-items: center; gap: 20px; }
        .hamburger-btn { background: none; border: none; font-size: 24px; color: var(--text-dark); cursor: pointer; padding: 0; }
        .nav-right { display: flex; align-items: center; gap: 25px; }
        .user-profile { display: flex; align-items: center; gap: 12px; }
        .user-info { text-align: right; line-height: 1.2; }
        .user-name { font-weight: 600; font-size: 14px; color: var(--text-dark); margin: 0; }
        .user-role { font-size: 11px; color: var(--text-gray); margin: 0; text-transform: uppercase; }
        .user-avatar { font-size: 32px; color: var(--primary-blue); }
        .content-area { padding: 30px; flex-grow: 1; overflow-y: auto; }

        /* --- APPROVAL CARDS --- */
        .page-title { font-weight: 700; font-size: 24px; color: var(--text-dark); margin-bottom: 30px; }
        
        .approval-card { background: white; border-radius: 12px; border: 1px solid var(--border-color); padding: 25px; margin-bottom: 20px; transition: 0.3s; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .approval-card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); border-color: var(--primary-blue); }
        
        .req-info h6 { font-size: 12px; font-weight: 600; color: var(--text-gray); text-transform: uppercase; margin-bottom: 5px; }
        .req-info p { font-weight: 600; font-size: 14px; margin-bottom: 15px; color: var(--text-dark); }
        
        .badge-status { padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; border: 1px solid transparent; }
        .bg-pending-l1 { background: #FFFBEB; color: #D97706; border-color: #FDE68A; }
        .bg-pending-l2 { background: #EFF6FF; color: #2563EB; border-color: #BFDBFE; }

        /* Action Buttons */
        .btn-action { background: white; border-radius: 8px; padding: 10px 20px; font-weight: 500; font-size: 14px; transition: 0.2s; display: inline-flex; align-items: center; gap: 8px; border: 1px solid var(--border-color); }
        .btn-approve { color: #10B981; }
        .btn-approve:hover { background: #10B981; color: white; border-color: #10B981; }
        .btn-reject { color: #EF4444; }
        .btn-reject:hover { background: #EF4444; color: white; border-color: #EF4444; }

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
            .approval-card .btn-action { width: 100%; justify-content: center; margin-bottom: 10px; }
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
                @else
                    <li><a href="{{ route('finance.dashboard') }}" class="menu-item"><i class="fas fa-border-all menu-icon"></i><span class="menu-text">Dashboard Finance</span></a></li>
                @endif
                <li><a href="{{ route('approvals.index') }}" class="menu-item active"><i class="fas fa-file-signature menu-icon"></i><span class="menu-text">Daftar Persetujuan</span></a></li>
                <li><a href="#" class="menu-item"><i class="fas fa-history menu-icon"></i><span class="menu-text">Riwayat Proses</span></a></li>
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
                    <h5 class="mb-0 fw-bold ms-3 d-none d-md-block">Menu Persetujuan</h5>
                </div>
                <div class="nav-right">
                    <div class="nav-icon text-muted"><i class="far fa-bell"></i></div>
                    <div class="user-profile ms-3">
                        <div class="user-info">
                            <p class="user-name">{{ Auth::user()->name }}</p>
                            <p class="user-role">{{ Auth::user()->role }}</p>
                        </div>
                        <i class="fas fa-user-circle user-avatar"></i>
                    </div>
                </div>
            </header>

            <main class="content-area">
                <h1 class="page-title">Menunggu Keputusan Anda</h1>

                @if(isset($requests) && $requests->isEmpty())
                    <div class="text-center py-5" style="background: white; border-radius: 12px; border: 1px dashed var(--border-color);">
                        <i class="fas fa-check-circle fa-3x text-success mb-3" style="opacity: 0.5;"></i>
                        <h5 class="fw-bold text-dark">Semua Pekerjaan Selesai!</h5>
                        <p class="text-muted">Tidak ada berkas pengajuan SPPD yang tertunda saat ini.</p>
                    </div>
                @endif

                @if(isset($requests))
                    @foreach($requests as $req)
                    <div class="approval-card">
                        <div class="row align-items-center">
                            
                            <div class="col-md-4">
                                <div class="req-info">
                                    <h6>Pemohon</h6>
                                    <p class="mb-3"><i class="fas fa-user text-primary me-2"></i> {{ $req->user->name }} <span class="text-muted fw-normal" style="text-transform: capitalize;">({{ $req->user->role }})</span></p>
                                    
                                    <h6>Tujuan & Catatan</h6>
                                    <p class="mb-0"><i class="fas fa-map-marker-alt text-danger me-2"></i> {{ $req->destination }} <br> 
                                        <small class="text-muted fw-normal ms-4 d-block mt-1">"{{ $req->purpose }}"</small>
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-3 mt-3 mt-md-0">
                                <div class="req-info">
                                    <h6>Tanggal Pelaksanaan</h6>
                                    <p class="mb-3"><i class="far fa-calendar-alt text-primary me-2"></i> {{ \Carbon\Carbon::parse($req->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($req->end_date)->format('d M Y') }}</p>
                                    
                                    <h6>Status Berkas</h6>
                                    <span class="badge-status {{ $req->status == 'pending_l1' ? 'bg-pending-l1' : 'bg-pending-l2' }}">
                                        @if($req->status == 'pending_l1')
                                            <i class="fas fa-hourglass-half me-1"></i> Menunggu Tahap 1 (Manajer)
                                        @else
                                            <i class="fas fa-hourglass-half me-1"></i> Menunggu Tahap 2 (Finance)
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-5 text-md-end mt-4 mt-md-0">
                                <button type="button" class="btn-action btn-reject" data-bs-toggle="modal" data-bs-target="#modalAction{{ $req->id }}" onclick="setupModal('{{ $req->id }}', 'reject')">
                                    <i class="fas fa-times"></i> Tolak Pengajuan
                                </button>
                                
                                <button type="button" class="btn-action btn-approve ms-md-2 mt-2 mt-md-0" data-bs-toggle="modal" data-bs-target="#modalAction{{ $req->id }}" onclick="setupModal('{{ $req->id }}', 'approve')">
                                    <i class="fas fa-check"></i> Setujui Pengajuan
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalAction{{ $req->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                                <form action="{{ route('approvals.process', $req->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="action" id="actionInput{{ $req->id }}">
                                    
                                    <div class="modal-header border-0 p-4 pb-0">
                                        <h5 class="modal-title fw-bold" id="modalTitle{{ $req->id }}">Konfirmasi Keputusan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    
                                    <div class="modal-body p-4">
                                        <p class="text-muted small mb-3">Tambahkan catatan atau instruksi terkait keputusan Anda. <br> <span class="fw-bold text-danger">*Wajib diisi jika menolak pengajuan.</span></p>
                                        <textarea name="note" id="noteInput{{ $req->id }}" class="form-control" rows="4" placeholder="Tulis instruksi atau alasan penolakan di sini..." style="border-radius: 8px; background: #FAFAFA; border: 1px solid var(--border-color); resize: none;"></textarea>
                                    </div>
                                    
                                    <div class="modal-footer border-0 p-4 pt-0">
                                        <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal" style="border-radius: 8px; padding: 10px 20px;">Batal</button>
                                        <button type="submit" class="btn fw-bold" id="submitBtn{{ $req->id }}" style="border-radius: 8px; padding: 10px 25px; color: white;"></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Logika Sidebar Responsive
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

        // Setup Modal Dinamis (Setuju/Tolak)
        function setupModal(id, type) {
            const title = document.getElementById('modalTitle' + id);
            const actionInput = document.getElementById('actionInput' + id);
            const submitBtn = document.getElementById('submitBtn' + id);
            const noteInput = document.getElementById('noteInput' + id);
            
            actionInput.value = type;
            
            if (type === 'approve') {
                title.innerText = 'Setujui Pengajuan SPPD';
                title.style.color = '#10B981';
                submitBtn.innerText = 'Ya, Setujui Sekarang';
                submitBtn.style.backgroundColor = '#10B981';
                noteInput.removeAttribute('required');
            } else {
                title.innerText = 'Tolak Pengajuan SPPD';
                title.style.color = '#EF4444';
                submitBtn.innerText = 'Ya, Tolak Pengajuan';
                submitBtn.style.backgroundColor = '#EF4444';
                noteInput.setAttribute('required', 'required'); // Wajib isi alasan jika menolak
            }
        }

        // Tampilkan Notifikasi Sukses dari Laravel Session
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            });
        @endif
    </script>
</body>
</html>