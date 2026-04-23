<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pengajuan UPCOUNTRY (UC)</title>
    <style>
        /* Pengaturan Dasar Halaman PDF */
        @page {
            margin: 30px 40px 60px 40px; /* Atas, Kanan, Bawah, Kiri */
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #000;
        }

        /* Footer Biru di Bawah Halaman (Otomatis muncul di tiap halaman) */
        footer {
            position: fixed;
            bottom: -30px;
            left: -40px;
            right: -40px;
            height: 30px;
            background-color: #84A9C0;
            color: white;
            font-style: italic;
            font-weight: bold;
            padding-left: 40px;
            line-height: 30px;
        }

        /* --- TABEL KOP & APPROVAL --- */
        .header-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .header-table td {
            vertical-align: top;
        }
        .logo-area h3 {
            margin: 0;
            color: #4A90E2;
            font-size: 16px;
        }
        .logo-area p {
            margin: 0;
            font-size: 10px;
            color: #555;
            letter-spacing: 1px;
        }

        .approval-box {
            border-collapse: collapse;
            width: 300px;
            float: right;
            font-size: 10px;
            text-align: center;
        }
        .approval-box th, .approval-box td {
            border: 1px solid #000;
            padding: 4px;
        }
        .approval-box th {
            background-color: #F8F9FA;
            font-weight: normal;
        }
        .sign-space {
            height: 50px;
            vertical-align: bottom !important;
            font-weight: bold;
        }
        
        /* Clearfix untuk float */
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        /* --- KONTEN HALAMAN 1 --- */
        .doc-title {
            text-transform: uppercase;
            font-size: 16px;
            margin-top: 40px;
            font-weight: bold;
        }
        .doc-subtitle {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
            margin-top: 2px;
        }

        .date-right {
            text-align: right;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .intro-text {
            text-align: justify;
            margin-bottom: 20px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 5px 0;
            vertical-align: top;
        }
        .info-table .col-num { width: 3%; }
        .info-table .col-label { width: 25%; }
        .info-table .col-colon { width: 2%; text-align: center; }
        .info-table .col-value { width: 70%; }

        /* Kotak Input Palsu di PDF */
        .input-box {
            border: 1px solid #000;
            padding: 3px 8px;
            display: inline-block;
            width: 90%;
            min-height: 15px;
        }
        
        .checkbox-box {
            border: 1px solid #000;
            display: inline-block;
            width: 12px;
            height: 12px;
            margin-right: 5px;
            text-align: center;
            line-height: 12px;
            font-size: 10px;
            vertical-align: middle;
        }

        /* --- KONTEN HALAMAN 2 (BIAYA) --- */
        .page-break {
            page-break-before: always;
        }

        .table-biaya {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 11px;
            text-align: center;
        }
        .table-biaya th, .table-biaya td {
            border: 1px solid #000;
            padding: 8px;
        }
        .table-biaya th {
            background-color: #F0F5FF;
            font-weight: bold;
        }
        .table-biaya .text-left { text-align: left; }
        .table-biaya .text-right { text-align: right; }
        .table-biaya .bg-gray { background-color: #F8F9FA; font-weight: bold; }

        .rekening-info {
            color: #D32F2F;
            font-weight: bold;
            font-size: 11px;
            margin-top: 15px;
        }
    </style>
</head>
<body>

    <footer>Make a Different</footer>

    <div class="clearfix">
        <table class="header-table">
            <tr>
                <td style="width: 40%;">
                    <div class="logo-area">
                        <h3>PT. SANZAYA MEDIKA PRATAMA</h3>
                        <p>MEDICAL & HEALTHCARE</p>
                    </div>
                    
                    <div class="doc-title">Form Pengajuan Biaya</div>
                    <div class="doc-subtitle">UPCOUNTRY (UC)</div>
                </td>
                <td style="width: 60%;" align="right">
                    <table class="approval-box">
                        <tr>
                            <th>Dibuat Oleh</th>
                            <th>Diperiksa Oleh</th>
                            <th>Disetujui Oleh</th>
                        </tr>
                        <tr>
                            <td class="sign-space">
                                <u>{{ $pengajuan->user->name }}</u>
                            </td>
                            <td class="sign-space">
                                @if($pengajuan->l1Approver)
                                    <u>{{ $pengajuan->l1Approver->name }}</u>
                                @else
                                    .............................
                                @endif
                            </td>
                            <td class="sign-space">
                                @if($pengajuan->l2Approver)
                                    <u>{{ $pengajuan->l2Approver->name }}</u>
                                @else
                                    .............................
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="text-transform: capitalize;">{{ $pengajuan->user->role }}</td>
                            <td>Manager</td>
                            <td>Finance</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div class="date-right">
        Makassar, {{ \Carbon\Carbon::parse($pengajuan->created_at)->translatedFormat('d F Y') }}
    </div>

    <div class="intro-text">
        Sehubungan dengan kebutuhan operasional guna memaksimalkan upaya pengembangan performa penjualan perusahaan, dengan ini kami mengajukan untuk melakukan perjalanan sebagai berikut:
    </div>

    <table class="info-table">
        <tr>
            <td class="col-num">1.</td>
            <td class="col-label">Nama</td>
            <td class="col-colon">:</td>
            <td class="col-value">{{ $pengajuan->user->name }}</td>
        </tr>
        <tr>
            <td>2.</td>
            <td>Jabatan</td>
            <td>:</td>
            <td><span style="text-transform: capitalize;">{{ $pengajuan->user->role }} {{ $pengajuan->user->division ?? '' }}</span></td>
        </tr>
        <tr>
            <td>3.</td>
            <td>Tujuan</td>
            <td>:</td>
            <td>{{ $pengajuan->destination }}</td>
        </tr>
        <tr>
            <td>4.</td>
            <td>Waktu (hari)</td>
            <td>:</td>
            <td>
                @php
                    $start = \Carbon\Carbon::parse($pengajuan->start_date);
                    $end = \Carbon\Carbon::parse($pengajuan->end_date);
                    $hari = $start->diffInDays($end) + 1; // Ditambah 1 agar terhitung inklusif
                @endphp
                <div class="input-box">{{ $hari }} Hari</div>
            </td>
        </tr>
        <tr>
            <td>5.</td>
            <td>Tanggal Berangkat</td>
            <td>:</td>
            <td><div class="input-box">{{ \Carbon\Carbon::parse($pengajuan->start_date)->translatedFormat('d F Y') }}</div></td>
        </tr>
        <tr>
            <td>6.</td>
            <td>Tanggal Pulang</td>
            <td>:</td>
            <td><div class="input-box">{{ \Carbon\Carbon::parse($pengajuan->end_date)->translatedFormat('d F Y') }}</div></td>
        </tr>
        <tr>
            <td>7.</td>
            <td>Nama & Jabatan<br>&nbsp;&nbsp;&nbsp;&nbsp;Pendamping</td>
            <td>:</td>
            <td>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="width: 5%;">1.</td>
                        <td><div class="input-box">-</div></td>
                    </tr>
                    <tr>
                        <td>2.</td>
                        <td><div class="input-box" style="margin-top: 3px;">-</div></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>8.</td>
            <td>Jenis Transportasi</td>
            <td>:</td>
            <td>
                <div style="margin-bottom: 2px;"><span class="checkbox-box">X</span> Darat</div>
                <div style="margin-bottom: 2px;"><span class="checkbox-box">&nbsp;</span> Laut</div>
                <div><span class="checkbox-box">&nbsp;</span> Udara</div>
            </td>
        </tr>
        <tr>
            <td>9.</td>
            <td>No. Polisi</td>
            <td>:</td>
            <td><div class="input-box">Sesuai Lampiran</div></td>
        </tr>
    </table>

    <div class="intro-text" style="margin-top: 40px;">
        Demikian surat tugas ini kami buat. Atas perhatiannya kami ucapkan terima kasih.
    </div>


    <div class="page-break"></div>

    <div class="clearfix">
        <table class="header-table">
            <tr>
                <td style="width: 40%; vertical-align: middle;">
                    <div class="logo-area">
                        <h3>PT. SANZAYA MEDIKA PRATAMA</h3>
                    </div>
                    <div class="doc-title" style="margin-top: 10px; font-size: 14px;">Lampiran Pengajuan</div>
                    <div class="doc-subtitle" style="font-size: 16px;">UPCOUNTRY (UC)</div>
                </td>
                <td style="width: 60%;" align="right">
                    <table class="approval-box">
                        <tr>
                            <th>Dibuat Oleh</th>
                            <th>Diperiksa Oleh</th>
                            <th>Disetujui Oleh</th>
                        </tr>
                        <tr>
                            <td class="sign-space"><u>{{ $pengajuan->user->name }}</u></td>
                            <td class="sign-space"><u>{{ $pengajuan->l1Approver->name ?? '...................' }}</u></td>
                            <td class="sign-space"><u>{{ $pengajuan->l2Approver->name ?? '...................' }}</u></td>
                        </tr>
                        <tr>
                            <td style="text-transform: capitalize;">{{ $pengajuan->user->role }}</td>
                            <td>Manager</td>
                            <td>Finance</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <table class="table-biaya">
        <thead>
            <tr>
                <th style="width: 5%;">NO</th>
                <th style="width: 45%;">ITEM</th>
                <th style="width: 25%;">KETERANGAN</th>
                <th style="width: 25%;">BIAYA (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td class="text-left">BIAYA BAHAN BAKAR / TIKET</td>
                <td>Transportasi</td>
                <td class="text-right">Menyesuaikan</td>
            </tr>
            <tr>
                <td>2</td>
                <td class="text-left">BIAYA KONSUMSI</td>
                <td>Makan</td>
                <td class="text-right">Menyesuaikan</td>
            </tr>
            <tr>
                <td>3</td>
                <td class="text-left">BIAYA PENGINAPAN</td>
                <td>Akomodasi (Hotel)</td>
                <td class="text-right">Menyesuaikan</td>
            </tr>
            
            <tr>
                <td colspan="3" class="text-left bg-gray">TOTAL ESTIMASI BIAYA PERJALANAN</td>
                <td class="text-right bg-gray">Menunggu Nota</td>
            </tr>
            <tr>
                <td colspan="3" class="text-left bg-gray">PANJAR BIAYA 50%</td>
                <td class="text-right"></td>
            </tr>
            <tr>
                <td colspan="3" class="text-left bg-gray">SISA BIAYA KLAIM PERJALANAN</td>
                <td class="text-right"></td>
            </tr>
        </tbody>
    </table>

    <div class="rekening-info">
        Rek {{ $pengajuan->user->bank ?? '.......' }} A/N {{ $pengajuan->user->nama_rekening ?? $pengajuan->user->name }} ({{ $pengajuan->user->nomor_rekening ?? '..............................' }})
    </div>

</body>
</html>