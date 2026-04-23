<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        .btn-create { background-color: var(--primary-blue); color: white; border: none; width: 100%; padding: 12px; border-radius: 8px; font-weight: 500; display: flex; align-items: center; justify-content: center; gap: 10px; transition: 0.3s; box-shadow: 0 4px 6px rgba(10,83,155,0.2); }
        .btn-create:hover { background-color: #08427b; transform: translateY(-1px); box-shadow: 0 6px 12px rgba(10,83,155,0.3); }
        .sidebar.collapsed .sidebar-footer { padding: 20px 10px; }
        .sidebar.collapsed .btn-create span { display: none; }

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
        .stepper-container { display: flex; justify-content: center; align-items: center; margin-bottom: 30px; margin-top: 10px; width: 100%; max-width: 650px; margin-left: auto; margin-right: auto; }
        .step-item { display: flex; flex-direction: column; align-items: center; position: relative; z-index: 2; width: 80px; }
        .step-circle { width: 40px; height: 40px; border-radius: 50%; background-color: #FFFFFF; color: #94A3B8; display: flex; justify-content: center; align-items: center; font-weight: 600; font-size: 15px; margin-bottom: 10px; border: 2px solid #E2E8F0; transition: all 0.3s ease; }
        .step-text { font-size: 12px; font-weight: 600; color: #94A3B8; text-align: center; white-space: nowrap; text-transform: uppercase; letter-spacing: 0.5px; }
        .step-line { flex-grow: 1; height: 2px; background: repeating-linear-gradient(90deg, #CBD5E1, #CBD5E1 5px, transparent 5px, transparent 10px); position: relative; top: -14px; z-index: 1; margin: 0 10px; transition: 0.3s; }
        
        .step-item.active .step-circle { background-color: var(--primary-blue); color: #FFFFFF; border-color: var(--primary-blue); box-shadow: 0 4px 10px rgba(10, 83, 155, 0.3); }
        .step-item.active .step-text { color: var(--primary-blue); }
        
        /* Tambahan CSS untuk status "Selesai/Lolos" */
        .step-item.completed .step-circle { background-color: #10B981; color: #FFFFFF; border-color: #10B981; }
        .step-item.completed .step-text { color: #10B981; }

        /* --- FORM PENGAJUAN AREA --- */
        .form-card { background-color: var(--form-bg); border-radius: 20px; padding: 40px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); border: 1px solid #E0E7FF; }
        .section-title { font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 25px; display: flex; align-items: center; gap: 10px; }
        .section-title::after { content: ''; flex-grow: 1; height: 1px; background-color: #CBD5E1; }
        
        .input-custom { width: 100%; border: 1px solid transparent; border-radius: 10px; padding: 12px 16px; font-size: 14px; color: var(--text-dark); font-weight: 500; background-color: #FFFFFF; transition: all 0.2s; outline: none; }
        .input-custom:focus { border-color: var(--primary-blue); box-shadow: 0 0 0 3px rgba(10, 83, 155, 0.1); }
        .input-custom::placeholder { color: #94A3B8; font-weight: 400; }
        .form-label-custom { font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px; display: block; text-transform: capitalize; }
        
        /* Input Spesial untuk No Polisi */
        .no-polisi-input { font-size: 12px; padding: 8px 12px; border: 1px dashed #CBD5E1; background-color: #F8FAFC; text-transform: uppercase; transition: 0.3s; }
        .no-polisi-input:focus { border: 1px solid var(--primary-blue); border-style: solid; background-color: #FFFFFF; }

        /* Grid Transportasi Dinamis */
        .transport-row { display: grid; grid-template-columns: 2fr 2fr 2fr 2.5fr 1.5fr 1.5fr auto; gap: 12px; align-items: end; margin-bottom: 15px; position: relative; }
        .btn-action-row { background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 10px; color: #64748B; cursor: pointer; display: flex; align-items: center; justify-content: center; width: 44px; height: 44px; transition: 0.2s; }
        .btn-action-row:hover { background: #FEE2E2; color: #EF4444; border-color: #FCA5A5; }
        
        .btn-add-route { background: #FFFFFF; border: 1px dashed var(--primary-blue); color: var(--primary-blue); padding: 10px 20px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; transition: 0.2s; display: inline-flex; align-items: center; gap: 8px; }
        .btn-add-route:hover { background: var(--light-blue); }

        /* Input Group Counter */
        .input-counter-group { display: flex; align-items: center; justify-content: space-between; background: #FFFFFF; border-radius: 10px; padding: 8px 16px; margin-bottom: 12px; border: 1px solid transparent; transition: 0.2s; }
        .input-counter-group:focus-within { border-color: var(--primary-blue); box-shadow: 0 0 0 3px rgba(10, 83, 155, 0.1); }
        .input-counter-group span { font-size: 13px; font-weight: 600; color: #475569; }
        .input-counter-group input { width: 50px; border: none; text-align: center; font-weight: 600; color: var(--text-dark); background: transparent; outline: none; font-size: 14px; }
        .input-counter-group input[type="number"]::-webkit-inner-spin-button { opacity: 1; height: 30px; }

        /* Info Tarif (Badge) */
        .info-tarif { font-size: 11px; background-color: var(--light-blue); color: var(--primary-blue); padding: 4px 8px; border-radius: 6px; font-weight: 600; margin-left: 5px; }

        /* Area Kalkulator Total */
        .total-box { background: #FFFFFF; border: 1px solid var(--primary-blue); border-radius: 10px; padding: 10px 15px; margin-top: 10px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 6px rgba(10,83,155,0.05); }
        .total-box span { font-size: 12px; font-weight: 600; color: #475569; }
        .total-box .total-amount { font-size: 16px; font-weight: 700; color: var(--primary-blue); }

        /* Tombol Submit Modern */
        .btn-submit-form { background-color: #FFFFFF; color: var(--primary-blue); border: 2px solid transparent; border-radius: 14px; padding: 16px; width: 100%; font-size: 16px; font-weight: 600; margin-top: 40px; transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(0,0,0,0.02); display: flex; justify-content: center; align-items: center; gap: 10px; }
        .btn-submit-form:hover { background-color: var(--primary-blue); color: #FFFFFF; box-shadow: 0 10px 20px rgba(10, 83, 155, 0.2); }

        /* Transisi Label Biaya */
        #label-biaya { transition: color 0.3s; }
        .highlight-label { color: var(--primary-blue) !important; }

        /* Responsive */
        .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 99; transition: 0.3s; }
        @media (max-width: 1200px) {
            .transport-row { display: flex; flex-wrap: wrap; background: rgba(255,255,255,0.5); padding: 20px; border-radius: 16px; border: 1px solid #E2E8F0; }
            .transport-row > div { flex: 1 1 30%; min-width: 150px; }
            .transport-row .btn-action-row { width: 100%; margin-top: 10px; }
            .d-lg-grid { display: none !important; }
        }
        @media (max-width: 768px) {
            .sidebar { position: fixed; left: -100%; box-shadow: 4px 0 15px rgba(0,0,0,0.1); }
            .sidebar.mobile-active { left: 0; }
            .sidebar-overlay.active { display: block; }
            .main-content, .sidebar.collapsed ~ .main-content { width: 100%; }
            .content-area { padding: 20px; }
            .form-card { padding: 25px; }
            .stepper-container { max-width: 100%; overflow-x: auto; justify-content: flex-start; padding-bottom: 15px; }
        }
    </style>
</head>
<body>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="wrapper">
        
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

        <div class="main-content">
            <header class="top-navbar">
                <div class="nav-left">
                    <button class="hamburger-btn" id="toggleSidebar"><i class="fas fa-bars"></i></button>
                </div>
                <div class="nav-right">
                    <div class="nav-icon"><i class="far fa-bell"></i><div class="badge-dot"></div></div>
                    <div class="user-profile">
                        <div class="user-info">
                            <p class="user-name">{{ Auth::user()->name ?? 'Nama Staff' }}</p>
                            <p class="user-role" id="displayUserRole">{{ Auth::user()->role ?? 'staff' }}</p>
                        </div>
                        <i class="fas fa-user-circle user-avatar"></i>
                    </div>
                </div>
            </header>

            <main class="content-area">
                
                @if(isset($pengajuanTerakhir))
                <div class="stepper-container">
                    <div class="step-item completed">
                        <div class="step-circle"><i class="fas fa-check"></i></div>
                        <div class="step-text">Pengajuan</div>
                    </div>
                    
                    <div class="step-line" style="{{ in_array($pengajuanTerakhir->status, ['pending_l1', 'pending_l2', 'approved']) ? 'background: #10B981;' : '' }}"></div>

                    <div class="step-item {{ in_array($pengajuanTerakhir->status, ['pending_l2', 'approved']) ? 'completed' : ($pengajuanTerakhir->status == 'pending_l1' ? 'active' : '') }}">
                        <div class="step-circle">
                            @if(in_array($pengajuanTerakhir->status, ['pending_l2', 'approved'])) <i class="fas fa-check"></i> @else 2 @endif
                        </div>
                        <div class="step-text">Proses L1</div>
                    </div>

                    <div class="step-line" style="{{ in_array($pengajuanTerakhir->status, ['pending_l2', 'approved']) ? 'background: #10B981;' : '' }}"></div>

                    <div class="step-item {{ $pengajuanTerakhir->status == 'approved' ? 'completed' : ($pengajuanTerakhir->status == 'pending_l2' ? 'active' : '') }}">
                        <div class="step-circle">
                            @if($pengajuanTerakhir->status == 'approved') <i class="fas fa-check"></i> @else 3 @endif
                        </div>
                        <div class="step-text">ACC Finance</div>
                    </div>

                    <div class="step-line" style="{{ $pengajuanTerakhir->status == 'approved' ? 'background: #10B981;' : '' }}"></div>

                    <div class="step-item {{ $pengajuanTerakhir->status == 'approved' ? 'completed' : '' }}">
                        <div class="step-circle">
                            @if($pengajuanTerakhir->status == 'approved') <i class="fas fa-flag-checkered"></i> @else 4 @endif
                        </div>
                        <div class="step-text">Selesai</div>
                    </div>
                </div>

                <div class="text-center mb-5 mt-n3">
                    <h6 class="fw-bold mb-3"><i class="fas fa-map-marker-alt text-danger me-2"></i> Tujuan Terakhir: {{ $pengajuanTerakhir->destination }}</h6>
                    <a href="{{ route('staff.riwayat') }}" class="btn btn-sm btn-outline-primary rounded-pill px-4">Lacak Detail Riwayat</a>
                </div>
                
                @else
                <div class="stepper-container">
                    <div class="step-item active">
                        <div class="step-circle">1</div>
                        <div class="step-text">Pengajuan</div>
                    </div>
                    <div class="step-line"></div>
                    <div class="step-item">
                        <div class="step-circle">2</div>
                        <div class="step-text">Proses L1</div>
                    </div>
                    <div class="step-line"></div>
                    <div class="step-item">
                        <div class="step-circle">3</div>
                        <div class="step-text">ACC Finance</div>
                    </div>
                    <div class="step-line"></div>
                    <div class="step-item">
                        <div class="step-circle">4</div>
                        <div class="step-text">Selesai</div>
                    </div>
                </div>
                <div class="text-center mb-5 mt-n3">
                    <p class="text-muted small">Anda belum memiliki riwayat pengajuan SPPD.</p>
                </div>
                @endif

                <div class="form-card">
                    <form action="{{ route('staff.pengajuan.store') }}" method="POST" id="pengajuanForm">
                        @csrf
                        
                        <div class="section-title">Transportasi & Rute Perjalanan</div>

                        <div class="transport-row d-none d-lg-grid mb-1">
                            <label class="form-label-custom text-center mb-0">Transportasi</label>
                            <label class="form-label-custom text-center mb-0">Keberangkatan</label>
                            <label class="form-label-custom text-center mb-0">Tujuan</label>
                            <label class="form-label-custom text-center mb-0">Tanggal</label>
                            <label class="form-label-custom text-center mb-0">Jam Mulai</label>
                            <label class="form-label-custom text-center mb-0">Jam Selesai</label>
                            <div></div>
                        </div>

                        <div id="transportContainer">
                            <div class="transport-row route-item align-items-start">
                                <div>
                                    <label class="form-label-custom d-lg-none">Transportasi</label>
                                    <select class="input-custom transport-select" name="transport[]" required>
                                        <option value="Mobil" selected>Mobil</option>
                                        <option value="Motor">Motor</option>
                                        <option value="Pesawat">Pesawat</option>
                                        <option value="Kereta">Kereta</option>
                                        <option value="Kapal">Kapal</option>
                                    </select>
                                    <input type="text" class="input-custom no-polisi-input mt-2" name="no_polisi[]" placeholder="No Polisi (Mis: DD 1234 A)" required>
                                </div>
                                <div>
                                    <label class="form-label-custom d-lg-none">Dari</label>
                                    <input type="text" class="input-custom" name="from[]" placeholder="Kota Asal" required>
                                </div>
                                <div>
                                    <label class="form-label-custom d-lg-none">Ke</label>
                                    <input type="text" class="input-custom" name="to[]" placeholder="Kota Tujuan" required>
                                </div>
                                <div>
                                    <label class="form-label-custom d-lg-none">Tanggal</label>
                                    <input type="date" class="input-custom" name="date[]" required>
                                </div>
                                <div>
                                    <label class="form-label-custom d-lg-none">Jam Mulai</label>
                                    <input type="time" class="input-custom" name="start_time[]" required>
                                </div>
                                <div>
                                    <label class="form-label-custom d-lg-none">Jam Selesai</label>
                                    <input type="time" class="input-custom" name="end_time[]" required>
                                </div>
                                <button type="button" class="btn-action-row btn-delete-row" title="Hapus Rute" disabled style="opacity: 0.5; cursor: not-allowed;"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </div>

                        <div class="mt-3 text-end">
                            <button type="button" class="btn-add-route" id="btnAddRoute"><i class="fas fa-plus"></i> Tambah Rute</button>
                        </div>

                        <hr style="border-color: #CBD5E1; margin: 35px 0;">

                        <div class="row g-4">
                            
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label-custom d-flex justify-content-between">
                                    Akomodasi (Malam) <span class="info-tarif" id="tarifAkomodasiLabel"></span>
                                </label>
                                <div class="input-counter-group">
                                    <span>Kota 1</span>
                                    <input type="number" class="calc-input akomodasi-input" name="akomodasi_1" value="0" min="0">
                                </div>
                                <div class="input-counter-group">
                                    <span>Kota 2</span>
                                    <input type="number" class="calc-input akomodasi-input" name="akomodasi_2" value="0" min="0">
                                </div>
                                <div class="total-box">
                                    <span>Total:</span>
                                    <span class="total-amount" id="totalAkomodasi">Rp 0</span>
                                </div>

                                <label class="form-label-custom text-center w-100 mt-4" id="label-biaya">Bensin / BBM</label>
                                <input type="text" class="input-custom text-center fw-bold" id="input-biaya" name="biaya" placeholder="Rp 0" style="color: var(--primary-blue); font-size: 16px;">
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <label class="form-label-custom d-flex justify-content-between">
                                    Uang Makan (Hari) <span class="info-tarif" id="tarifMakanLabel"></span>
                                </label>
                                <div class="input-counter-group">
                                    <span>Kota 1</span>
                                    <input type="number" class="calc-input makan-input" name="makan_1" value="0" min="0">
                                </div>
                                <div class="input-counter-group">
                                    <span>Kota 2</span>
                                    <input type="number" class="calc-input makan-input" name="makan_2" value="0" min="0">
                                </div>
                                <div class="total-box">
                                    <span>Total:</span>
                                    <span class="total-amount" id="totalMakan">Rp 0</span>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <label class="form-label-custom w-100">Durasi Perjalanan</label>
                                <div class="input-custom d-flex justify-content-between align-items-center mb-1" style="background: #FFFFFF;">
                                    <input type="date" name="durasi_start" style="border:none; outline:none; background:transparent; width: 45%; font-size:13px;" required>
                                    <span class="text-muted">-</span>
                                    <input type="date" name="durasi_end" style="border:none; outline:none; background:transparent; width: 45%; font-size:13px;" required>
                                </div>
                                <small class="text-muted d-block mb-4" style="font-size: 11px;">Mulai dari awal hingga selesainya perjalanan dinas</small>

                                <label class="form-label-custom w-100">Catatan Khusus</label>
                                <textarea class="input-custom" name="catatan" rows="3" placeholder="Tambahkan catatan jika diperlukan..." style="resize: none;"></textarea>
                            </div>

                            <div class="col-lg-2 col-md-6">
                                <label class="form-label-custom w-100">Pendamping <small class="text-muted fw-normal">(Opsional)</small></label>
                                <div class="mb-2">
                                    <select class="input-custom" name="pendamping_1">
                                        <option value="">1. Pilih Rekan</option>
                                        @if(isset($users))
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }} - {{ ucwords($user->role) }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div>
                                    <select class="input-custom" name="pendamping_2">
                                        <option value="">2. Pilih Rekan</option>
                                        @if(isset($users))
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }} - {{ ucwords($user->role) }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="mt-4 text-end">
                            <h5 class="text-dark fw-bold mb-0">Total Estimasi SPPD: <span id="grandTotal" class="text-primary">Rp 0</span></h5>
                            <small class="text-muted">Total biaya di atas bersifat estimasi dan menunggu persetujuan.</small>
                        </div>

                        <button type="submit" class="btn-submit-form">Ajukan SPPD <i class="fas fa-paper-plane ms-2"></i></button>

                    </form>
                </div>

            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // --- LOGIKA RESPONSIVE SIDEBAR ---
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        document.getElementById('toggleSidebar').addEventListener('click', () => {
            if (window.innerWidth <= 768) { sidebar.classList.toggle('mobile-active'); overlay.classList.toggle('active'); } 
            else { sidebar.classList.toggle('collapsed'); }
        });
        overlay.addEventListener('click', () => { sidebar.classList.remove('mobile-active'); overlay.classList.remove('active'); });

        // --- SISTEM KALKULATOR OTOMATIS BERDASARKAN ROLE ---
        const userRole = "{{ strtolower(Auth::user()->role ?? 'staff') }}";
        
        let tarifMakan = 150000; 
        let tarifAkomodasi = 250000; 

        if (userRole === 'manager' || userRole === 'manajemen' || userRole === 'kepala marketing' || userRole === 'hrd' || userRole === 'finance') {
            tarifMakan = 300000; 
            tarifAkomodasi = 350000; 
        }

        const formatRupiah = (number) => {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
        };
        
        document.getElementById('tarifMakanLabel').innerText = formatRupiah(tarifMakan) + '/Hari';
        document.getElementById('tarifAkomodasiLabel').innerText = formatRupiah(tarifAkomodasi) + '/Mlm';

        function calculateTotals() {
            const akom1 = parseInt(document.querySelector('input[name="akomodasi_1"]').value) || 0;
            const akom2 = parseInt(document.querySelector('input[name="akomodasi_2"]').value) || 0;
            const totalAkomodasi = (akom1 + akom2) * tarifAkomodasi;
            document.getElementById('totalAkomodasi').innerText = formatRupiah(totalAkomodasi);

            const makan1 = parseInt(document.querySelector('input[name="makan_1"]').value) || 0;
            const makan2 = parseInt(document.querySelector('input[name="makan_2"]').value) || 0;
            const totalMakan = (makan1 + makan2) * tarifMakan;
            document.getElementById('totalMakan').innerText = formatRupiah(totalMakan);

            let bensinInput = document.getElementById('input-biaya').value.replace(/[^,\d]/g, '');
            const totalBensin = parseInt(bensinInput) || 0;

            const grandTotal = totalAkomodasi + totalMakan + totalBensin;
            document.getElementById('grandTotal').innerText = formatRupiah(grandTotal);
        }

        document.querySelectorAll('.calc-input').forEach(input => {
            input.addEventListener('input', calculateTotals);
            input.addEventListener('change', calculateTotals);
        });

        const inputBiaya = document.getElementById('input-biaya');
        inputBiaya.addEventListener('keyup', function(e) {
            let value = this.value.replace(/[^,\d]/g, '');
            let split = value.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            this.value = rupiah ? 'Rp ' + rupiah : '';
            
            calculateTotals();
        });

        const container = document.getElementById('transportContainer');
        const btnAdd = document.getElementById('btnAddRoute');
        const labelBiaya = document.getElementById('label-biaya');

        function checkTransportTypes() {
            const rows = document.querySelectorAll('.route-item');
            let hasPublicTransport = false;

            rows.forEach(row => {
                const select = row.querySelector('.transport-select');
                const noPolisiInput = row.querySelector('.no-polisi-input');
                const val = select.value.toLowerCase();

                if (val === 'mobil' || val === 'motor') {
                    noPolisiInput.style.display = 'block';
                    noPolisiInput.setAttribute('required', 'required');
                } else {
                    hasPublicTransport = true;
                    noPolisiInput.style.display = 'none';
                    noPolisiInput.removeAttribute('required');
                    noPolisiInput.value = ''; 
                }
            });

            if (hasPublicTransport) {
                labelBiaya.innerText = 'Harga Tiket Transportasi';
                labelBiaya.classList.add('highlight-label');
                inputBiaya.placeholder = 'Rp Masukkan Harga Tiket';
            } else {
                labelBiaya.innerText = 'Bensin / BBM';
                labelBiaya.classList.remove('highlight-label');
                inputBiaya.placeholder = 'Rp Estimasi Bensin';
            }
        }

        checkTransportTypes();

        container.addEventListener('change', function(e) {
            if (e.target.classList.contains('transport-select')) {
                checkTransportTypes();
            }
        });

        btnAdd.addEventListener('click', function() {
            const firstRow = container.querySelector('.route-item');
            const newRow = firstRow.cloneNode(true);
            
            newRow.querySelectorAll('input').forEach(input => input.value = '');
            
            const btnDelete = newRow.querySelector('.btn-delete-row');
            btnDelete.disabled = false;
            btnDelete.style.opacity = '1';
            btnDelete.style.cursor = 'pointer';

            container.appendChild(newRow);
            
            checkTransportTypes();
            updateDeleteButtons();
        });

        container.addEventListener('click', function(e) {
            const btnDelete = e.target.closest('.btn-delete-row');
            if (btnDelete && !btnDelete.disabled) {
                btnDelete.closest('.route-item').remove();
                checkTransportTypes();
                updateDeleteButtons();
            }
        });

        function updateDeleteButtons() {
            const rows = container.querySelectorAll('.route-item');
            const firstBtn = rows[0].querySelector('.btn-delete-row');
            if (rows.length === 1) {
                firstBtn.disabled = true;
                firstBtn.style.opacity = '0.5';
                firstBtn.style.cursor = 'not-allowed';
            } else {
                firstBtn.disabled = false;
                firstBtn.style.opacity = '1';
                firstBtn.style.cursor = 'pointer';
            }
        }
    </script>
</body>
</html>