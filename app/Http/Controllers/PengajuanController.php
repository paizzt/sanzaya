<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TravelRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PengajuanController extends Controller
{
    public function create()
    {
        // Cek jika yang login adalah kelompok Manajer (L1)
        if (in_array(Auth::user()->role, ['manager', 'hrd', 'kepala marketing'])) {
            return view('manager.pengajuan');
        }
        return view('staff.pengajuan');
    }

    public function store(Request $request)
    {
        $request->validate([
            'departure'           => 'required|string|max:255',
            'destination'         => 'required|string|max:255',
            'start_date'          => 'required|date',
            'end_date'            => 'required|date|after_or_equal:start_date',
            'transportation_type' => 'required|string',
            'biaya_makan'         => 'nullable|numeric|min:0',
            'biaya_penginapan'    => 'nullable|numeric|min:0',
            'biaya_bensin'        => 'nullable|numeric|min:0',
        ]);

        $pengajuan = new TravelRequest();
        $pengajuan->user_id = Auth::id();
        $pengajuan->departure = $request->departure; 
        $pengajuan->destination = $request->destination;
        $pengajuan->start_date = $request->start_date;
        $pengajuan->end_date = $request->end_date;
        $pengajuan->companion_1 = $request->companion_1;
        $pengajuan->companion_2 = $request->companion_2;
        $pengajuan->transportation_type = $request->transportation_type;
        $pengajuan->vehicle_number = $request->vehicle_number;
        
        // Simpan rincian biaya
        $pengajuan->biaya_makan = $request->biaya_makan ?? 0;
        $pengajuan->biaya_penginapan = $request->biaya_penginapan ?? 0;
        $pengajuan->biaya_bensin = $request->biaya_bensin ?? 0;
        
        // Hitung total biaya
        $pengajuan->total_biaya = $pengajuan->biaya_makan + $pengajuan->biaya_penginapan + $pengajuan->biaya_bensin;

        // LOGIKA BYPASS: Jika Manajer yang buat, langsung ke Finance (L2)
        if (in_array(Auth::user()->role, ['manager', 'hrd', 'kepala marketing'])) {
            $pengajuan->status = 'pending_l2'; 
            $pengajuan->l1_approver_id = Auth::id();
            $pengajuan->l1_note = 'Auto-approved (Manager Self-Request)';
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

        if ($pengajuan->status !== 'approved') {
            return back()->with('error', 'Dokumen belum disetujui sepenuhnya.');
        }

        $pdf = PDF::loadView('staff.pdf-sppd', compact('pengajuan'));
        
        return $pdf->download('Surat_Tugas_UC_' . $pengajuan->user->name . '.pdf');
    }
}