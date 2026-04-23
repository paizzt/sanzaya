<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\TravelRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    // 1. Menampilkan Form
    public function create()
    {
        // Mengambil data user untuk dropdown pendamping
        $users = \App\Models\User::orderBy('name', 'asc')->get();
        $pengajuanTerakhir = \App\Models\TravelRequest::where('user_id', \Illuminate\Support\Facades\Auth::id())
                        ->latest()
                        ->first();
        return view('staff.pengajuan', compact('users'));
    }
    public function cetakPDF($id)
    {
        // Ambil data pengajuan beserta relasi yang menyetujui
        $pengajuan = \App\Models\TravelRequest::with(['user', 'l1Approver', 'l2Approver'])->findOrFail($id);

        // Keamanan: Pastikan hanya berkas yang sudah "approved" yang bisa dicetak
        if ($pengajuan->status !== 'approved') {
            abort(403, 'Dokumen ini belum disetujui sepenuhnya dan tidak dapat dicetak.');
        }

        // Generate PDF menggunakan view 'staff.pdf-sppd'
        $pdf = Pdf::loadView('staff.pdf-sppd', compact('pengajuan'));
        
        // Atur ukuran kertas (A4, Potrait)
        $pdf->setPaper('A4', 'portrait');

        // Kembalikan file PDF untuk di-download
        return $pdf->download('Surat_Tugas_SPPD_' . str_replace(' ', '_', $pengajuan->user->name) . '.pdf');
    }
    // 2. Menyimpan Data Form ke Database
    public function store(Request $request)
    {
        // Ambil data user yang sedang login
        $user = Auth::user();

        // Membuat record pengajuan baru di tabel travel_requests
        $pengajuan = new TravelRequest();
        $pengajuan->user_id = $user->id;
        
        // Mengambil destinasi dari array 'to' (kota tujuan terakhir)
        $destinations = $request->input('to');
        $pengajuan->destination = end($destinations) ?? 'Tidak diketahui';
        
        $pengajuan->purpose = $request->catatan ?? 'Perjalanan Dinas';
        $pengajuan->start_date = $request->durasi_start;
        $pengajuan->end_date = $request->durasi_end;
        
        // Status otomatis masuk ke Tahap 1 (Menunggu Manajer)
        $pengajuan->status = 'pending_l1';
        
        // Simpan ke database
        $pengajuan->save();
        \App\Models\ActivityLog::create([
            'user_id' => $user->id,
            'activity' => 'Pengajuan SPPD Baru',
            'description' => $user->name . ' (Staff) mengajukan SPPD tujuan ' . $pengajuan->destination,
            'target_type' => 'TravelRequest'
        ]);
        // Catatan: Karena di form Anda ada input transportasi dinamis (array), akomodasi, dll, 
        // idealnya Anda membuat tabel terpisah (misal: travel_routes) atau menyimpannya dalam format JSON.
        // Untuk tahap awal ini, kita simpan data intinya dulu agar alur ACC bisa berjalan.
    
        // Arahkan ke halaman riwayat pengajuan dengan pesan sukses
        return redirect()->route('staff.riwayat')->with('success', 'Pengajuan SPPD berhasil dikirim dan menunggu persetujuan Tahap 1.');
        
    }
    // Menampilkan halaman Pelacakan (Tracking) untuk Staff
    public function track($id)
    {
        // Ambil data pengajuan beserta relasi yang memproses
        $pengajuan = \App\Models\TravelRequest::with(['l1Approver', 'l2Approver'])->findOrFail($id);

        // Keamanan: Pastikan Staff hanya bisa melacak pengajuannya sendiri
        if ($pengajuan->user_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403, 'Akses ditolak. Anda hanya dapat melihat dokumen Anda sendiri.');
        }

        return view('staff.tracking', compact('pengajuan'));
    }
}