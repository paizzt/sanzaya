<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Result Laporan Kunjungan - {{ $pengajuan->user->name ?? 'Pegawai' }}</title>
    <style>
        @page {
            margin: 30px 40px 60px 40px; 
        }
        body { 
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; 
            font-size: 11px; 
            line-height: 1.4; 
            color: #000; 
        }
        
        /* --- HEADER AREA --- */
        .header-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .header-table td { vertical-align: top; }
        .logo-area { display: flex; align-items: center; gap: 10px; }
        .logo-text h3 { margin: 0; color: #4A90E2; font-size: 16px; text-transform: uppercase; }
        
        .lampiran-text { color: #DC2626; font-style: italic; font-weight: bold; font-size: 10px; margin-top: 15px; margin-bottom: 5px;}
        .title-result { font-size: 18px; font-weight: normal; margin: 0; }
        .title-uc { font-size: 22px; font-weight: bold; margin: 0; }

        /* --- APPROVAL BOX --- */
        .approval-box { border-collapse: collapse; width: 350px; float: right; font-size: 10px; text-align: center; }
        .approval-box th, .approval-box td { border: 1px solid #000; padding: 4px; }
        .approval-box th { background-color: #E2E8F0; font-weight: bold; }
        .sign-space { height: 50px; vertical-align: bottom !important; font-weight: bold; }
        .role-text { font-style: italic; }

        .clearfix::after { content: ""; clear: both; display: table; }

        /* --- MAIN TABLE RESULT --- */
        .table-result { width: 100%; border-collapse: collapse; margin-top: 25px; }
        .table-result th, .table-result td { border: 1px solid #000; padding: 8px; text-align: left; vertical-align: top; }
        .table-result th { background-color: #D9E2F3; text-align: center; font-weight: bold; font-size: 11px; }
        
        .text-center { text-align: center !important; }

        /* --- FOOTER --- */
        footer {
            position: fixed;
            bottom: -30px; left: -40px; right: -40px;
            height: 30px;
            background-color: #84A9C0;
            color: white;
            font-style: italic; font-weight: bold;
            padding-left: 40px; line-height: 30px; font-size: 12px;
        }
    </style>
</head>
<body>
    
    <footer>Make a Different</footer>

    <div class="clearfix">
        <table class="header-table">
            <tr>
                <td style="width: 50%;">
                    <div class="logo-area">
                        <!-- Menggunakan Nama Perusahaan Default Sistem -->
                        <div class="logo-text">
                            <h3>PT. SANZAYA MEDIKA PRATAMA</h3>
                        </div>
                    </div>
                    
                    <div class="lampiran-text">*Lampiran klaim anggaran UC</div>
                    <div class="title-result">RESULT</div>
                    <div class="title-uc">UPCOUNTRY (UC)</div>
                </td>
                <td style="width: 50%;" align="right">
                    <table class="approval-box">
                        <tr>
                            <th width="33%">Dibuat Oleh</th>
                            <th width="33%">Diperiksa Oleh</th>
                            <th width="33%">Disetujui Oleh</th>
                        </tr>
                        <tr>
                            <!-- Pemohon (Bisa Staff, bisa Manajer jika ia ajukan sendiri) -->
                            <td class="sign-space"><u>{{ $pengajuan->user->name ?? 'Pemohon' }}</u></td>
                            <!-- Diperiksa L1 -->
                            <td class="sign-space"><u>{{ $pengajuan->l1Approver->name ?? 'HRGA Staff' }}</u></td>
                            <!-- Disetujui L2 -->
                            <td class="sign-space"><u>{{ $pengajuan->l2Approver->name ?? 'Marketing Manager' }}</u></td>
                        </tr>
                        <tr>
                            <td class="role-text">{{ ucfirst($pengajuan->user->role ?? 'Sales Marketing') }}</td>
                            <td class="role-text">Manager / HRGA</td>
                            <td class="role-text">Finance Manager</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    @php
        // Mendekode format JSON menjadi Array
        $hasilArray = json_decode($pengajuan->hasil_kunjungan, true) ?? [];
    @endphp

    <table class="table-result">
        <thead>
            <tr>
                <th width="5%">NO</th>
                <th width="20%">OUTLET</th>
                <th width="30%">TUJUAN KUNJUNGAN</th>
                <th width="45%">HASIL KUNJUNGAN</th>
            </tr>
        </thead>
        <tbody>
            @forelse($hasilArray as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center fw-bold">{{ $item['outlet'] ?? '-' }}</td>
                    <td>{{ $item['tujuan_kunjungan'] ?? '-' }}</td>
                    <!-- nl2br memastikan Enter/Ganti baris dari textarea tetap terbaca di PDF -->
                    <td style="text-align: justify;">{!! nl2br(e($item['hasil_kunjungan'] ?? '-')) !!}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center"><em>Data Hasil Kunjungan Tidak Ditemukan.</em></td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>