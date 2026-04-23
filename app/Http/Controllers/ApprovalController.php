<?php

namespace App\Http\Controllers;

use App\Models\TravelRequest; // Pastikan Model ini sudah ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = TravelRequest::with('user');

        // Logika penyaringan berdasarkan Role
        if ($user->role == 'finance') {
            $query->where('status', 'pending_l2');
        } elseif (in_array($user->role, ['manager', 'hrd', 'kepala marketing'])) {
            $query->where('status', 'pending_l1');
        } elseif ($user->role != 'admin') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $requests = $query->latest()->get();
        return view('shared.approval-list', compact('requests'));
    }

    public function process(Request $request, $id)
    {
        $travelRequest = TravelRequest::findOrFail($id);
        $user = Auth::user();
        $action = $request->action; // 'approve' atau 'reject'
        $note = $request->note; // Menangkap catatan dari form

        if ($action == 'approve') {
            if ($travelRequest->status == 'pending_l1') {
                $travelRequest->status = 'pending_l2';
                $travelRequest->l1_approver_id = $user->id;
                $travelRequest->l1_note = $note;
            } else {
                $travelRequest->status = 'approved';
                $travelRequest->l2_approver_id = $user->id;
                $travelRequest->l2_note = $note;
            }
        } else {
            $travelRequest->status = 'rejected';
            // Simpan catatan penolakan sesuai siapa yang menolak
            if ($travelRequest->status == 'pending_l1' || empty($travelRequest->l1_approver_id)) {
                $travelRequest->l1_note = $note;
            } else {
                $travelRequest->l2_note = $note;
            }
        }

        $travelRequest->save();
        $kataKerja = ($action == 'approve') ? 'menyetujui' : 'menolak';
        
        // Catat aktivitas ke Riwayat Perubahan Admin
        \App\Models\ActivityLog::create([
            'user_id' => $user->id,
            'activity' => 'Persetujuan SPPD',
            'description' => $user->name . ' (' . strtoupper($user->role) . ') ' . $kataKerja . ' pengajuan SPPD milik ' . $travelRequest->user->name,
            'target_type' => 'TravelRequest'
        ]);
        return back()->with('success', 'Keputusan dan catatan berhasil disimpan.');
    }
    // Menampilkan Detail Pengajuan Spesifik
    public function show($id)
    {
        // Ambil data pengajuan beserta relasi user dan approver-nya
        $pengajuan = TravelRequest::with(['user', 'l1Approver', 'l2Approver'])->findOrFail($id);
        
        // Pastikan user punya hak akses melihat detail ini
        $user = \Illuminate\Support\Facades\Auth::user();
        
        return view('shared.approval-detail', compact('pengajuan'));
    }
}