<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TravelRequest;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    // Menampilkan daftar antrean yang butuh persetujuan
    public function index()
    {
        $userRole = strtolower(trim(Auth::user()->role));

        if (in_array($userRole, ['manager', 'hrd', 'kepala marketing'])) {
            $requests = TravelRequest::with('user')->where('status', 'pending_l1')->latest()->get();
        } elseif ($userRole == 'finance') {
            $requests = TravelRequest::with('user')->where('status', 'pending_l2')->latest()->get();
        } else {
            $requests = collect();
        }

        return view('shared.approval-list', compact('requests'));
    }

    // Menampilkan detail pengajuan
    public function show($id)
    {
        $pengajuan = TravelRequest::with('user')->findOrFail($id);
        return view('shared.approval-detail', compact('pengajuan'));
    }

    // Memproses Tindakan ACC / Tolak
    public function process(Request $request, $id)
    {
        $pengajuan = TravelRequest::findOrFail($id);
        $action = $request->input('action'); // isinya: 'approve' atau 'reject'
        $note = $request->input('note');
        $userRole = strtolower(trim(Auth::user()->role));

        if (in_array($userRole, ['manager', 'hrd', 'kepala marketing'])) {
            // PROSES MANAJER (L1)
            if ($action == 'approve') {
                $pengajuan->status = 'pending_l2';
            } else {
                $pengajuan->status = 'rejected';
            }
            $pengajuan->l1_approver_id = Auth::id();
            $pengajuan->l1_note = $note;

        } elseif ($userRole == 'finance') {
            // PROSES FINANCE (L2)
            if ($action == 'approve') {
                $pengajuan->status = 'approved';
                
                // Menyimpan input rincian biaya yang diedit oleh Finance
                if($request->has('biaya_makan')) $pengajuan->biaya_makan = $request->biaya_makan;
                if($request->has('biaya_penginapan')) $pengajuan->biaya_penginapan = $request->biaya_penginapan;
                if($request->has('biaya_bensin')) $pengajuan->biaya_bensin = $request->biaya_bensin;
                if($request->has('total_biaya')) $pengajuan->total_biaya = $request->total_biaya;
                
            } else {
                $pengajuan->status = 'rejected';
            }
            $pengajuan->l2_approver_id = Auth::id();
            $pengajuan->l2_note = $note;
        }

        $pengajuan->save();

        return redirect()->route('approvals.index')->with('success', 'Dokumen berhasil diproses dan status telah diperbarui.');
    }
}