<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TravelRequest;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PengajuanController extends Controller
{
    public function create()
    {
        $role = strtolower(trim(Auth::user()->role));
        $usersList = User::where('id', '!=', Auth::id())->orderBy('name', 'asc')->get();

        // Cek jika yang login adalah kelompok Manajer (L1)
        if (in_array($role, ['manager', 'hrd', 'kepala marketing'])) {
            // Ambil daftar staff untuk fitur "mewakilkan pembuatan UC"
            $staffList = User::where('role', 'staff')->orderBy('name', 'asc')->get();
            return view('manager.pengajuan', compact('usersList', 'staffList'));
        }
        
        return view('staff.pengajuan', compact('usersList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'departure'           => 'required|string|max:255',
            'destination'         => 'required|string|max:255',
            'start_date'          => 'required|date',
            'end_date'            => 'required|date|after_or_equal:start_date',
            'transportation_type' => 'required|string',
            'biaya_bensin'        => 'nullable|numeric|min:0',
        ]);

        $pengajuan = new TravelRequest();
        
        $role = strtolower(trim(Auth::user()->role));
        $isManajemen = in_array($role, ['manager', 'hrd', 'kepala marketing', 'admin']);

        // LOGIKA MEWAKILKAN: Jika manajer memilih untuk membuatkan UC stafnya
        $userId = Auth::id();
        if ($isManajemen && $request->has('for_user_id') && !empty($request->for_user_id)) {
            $userId = $request->for_user_id;
        }
        $pengajuan->user_id = $userId;

        $pengajuan->departure = $request->departure; 
        $pengajuan->destination = $request->destination;
        $pengajuan->start_date = $request->start_date;
        $pengajuan->end_date = $request->end_date;
        $pengajuan->companion_1 = $request->companion_1;
        $pengajuan->companion_2 = $request->companion_2;
        $pengajuan->transportation_type = $request->transportation_type;
        $pengajuan->vehicle_number = $request->vehicle_number;
        
        // --- PERHITUNGAN BIAYA OTOMATIS ---
        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        $days = $start->diffInDays($end) + 1; // Dihitung inklusif (hari penuh)
        $nights = $days > 1 ? $days - 1 : 0; // Malam menginap
        
        // Cek role user yang berangkat (Bukan yang membuat)
        $traveler = User::find($userId);
        $travelerRole = strtolower(trim($traveler->role ?? 'staff'));
        $travelerIsManajemen = in_array($travelerRole, ['manager', 'hrd', 'kepala marketing', 'admin']);
        
        if ($travelerIsManajemen) {
            $biayaMakan = (100000 * 3) * $days; // Manajemen: 100rb x 3 per hari
            $biayaPenginapan = 350000 * $nights; // Manajemen: 350rb per malam
        } else {
            $biayaMakan = (50000 * 3) * $days; // Staff: 50rb x 3 per hari
            $biayaPenginapan = 250000 * $nights; // Staff: 250rb per malam
        }
        
        // Bensin dari input manual form (jika ada)
        $biayaBensin = $request->biaya_bensin ? floatval($request->biaya_bensin) : 0;
        
        $pengajuan->biaya_makan = $biayaMakan;
        $pengajuan->biaya_penginapan = $biayaPenginapan;
        $pengajuan->biaya_bensin = $biayaBensin;
        $pengajuan->total_biaya = $biayaMakan + $biayaPenginapan + $biayaBensin;

        // LOGIKA BYPASS: Jika Manajer yang buat (meski buatkan untuk staf), langsung ke Finance (L2)
        if ($isManajemen) {
            $pengajuan->status = 'pending_l2'; 
            $pengajuan->l1_approver_id = Auth::id(); // Manajer yang membuat jadi approver L1 otomatis
            $pengajuan->l1_note = 'Diwakilkan / Auto-approved oleh ' . Auth::user()->name;
        } else {
            $pengajuan->status = 'pending_l1'; 
        }

        $pengajuan->save();

        $route = Auth::user()->role == 'staff' ? 'staff.riwayat' : 'manager.history';
        return redirect()->route($route)->with('success', 'Pengajuan UC berhasil dikirim!');
    }

    public function track($id)
    {
        $pengajuan = TravelRequest::findOrFail($id);
        if (Auth::user()->role == 'staff') {
            return view('staff.pengajuan-detail', compact('pengajuan'));
        }
        return view('manager.pengajuan-detail', compact('pengajuan'));
    }

    public function cetakPDF($id)
    {
        $pengajuan = TravelRequest::with(['user', 'l1Approver', 'l2Approver'])->findOrFail($id);

        if (!in_array($pengajuan->status, ['approved', 'selesai'])) {
            return back()->with('error', 'Dokumen belum disetujui sepenuhnya.');
        }

        $pdf = PDF::loadView('staff.pdf-sppd', compact('pengajuan'));
        return $pdf->download('Surat_Tugas_UC_' . $pengajuan->user->name . '.pdf');
    }

    // ========================================================
    // FITUR KLAIM BIAYA (UPLOAD NOTA & INPUT HASIL KUNJUNGAN)
    // ========================================================

    public function klaimForm($id)
    {
        $pengajuan = TravelRequest::findOrFail($id);

        // Pastikan hanya yang berhak yang bisa upload (Pemilik dokumen atau Manajer)
        if ($pengajuan->user_id !== Auth::id() && !in_array(Auth::user()->role, ['manager', 'hrd', 'kepala marketing'])) {
            return abort(403, 'Unauthorized action.');
        }

        return view('shared.klaim-form', compact('pengajuan'));
    }

    public function submitKlaim(Request $request, $id)
    {
        $request->validate([
            'nota_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
            'outlet' => 'required|array',
            'tujuan_kunjungan' => 'required|array',
            'hasil_kunjungan' => 'required|array',
        ]);

        $pengajuan = TravelRequest::findOrFail($id);

        // Upload File Nota
        if ($request->hasFile('nota_file')) {
            $file = $request->file('nota_file');
            $filename = time() . '_Nota_' . str_replace(' ', '_', $pengajuan->user->name) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/nota'), $filename);
            $pengajuan->nota_file = $filename; // Pastikan Anda menambahkan kolom ini di Database
        }

        // Menyusun Array Hasil Kunjungan
        $hasilArray = [];
        for ($i = 0; $i < count($request->outlet); $i++) {
            if (!empty($request->outlet[$i]) && !empty($request->hasil_kunjungan[$i])) {
                $hasilArray[] = [
                    'outlet' => $request->outlet[$i],
                    'tujuan_kunjungan' => $request->tujuan_kunjungan[$i],
                    'hasil_kunjungan' => $request->hasil_kunjungan[$i],
                ];
            }
        }

        // Simpan ke database JSON format
        $pengajuan->hasil_kunjungan = json_encode($hasilArray); // Pastikan Anda menambahkan kolom ini di Database
        
        // Status berubah menjadi "selesai" yang berarti Siklus UC telah tuntas 100%
        $pengajuan->status = 'selesai'; 
        $pengajuan->save();

        $route = Auth::user()->role == 'staff' ? 'staff.riwayat' : 'manager.history';
        return redirect()->route($route)->with('success', 'Nota dan Laporan Hasil (Result) berhasil disubmit. Proses Selesai!');
    }

    public function cetakResult($id)
    {
        $pengajuan = TravelRequest::with(['user', 'l1Approver', 'l2Approver'])->findOrFail($id);

        if (empty($pengajuan->hasil_kunjungan)) {
            return back()->with('error', 'Laporan Hasil Kunjungan belum diisi.');
        }

        $pdf = PDF::loadView('shared.pdf-result', compact('pengajuan'));
        return $pdf->download('Result_UC_' . $pengajuan->user->name . '.pdf');
    }
}