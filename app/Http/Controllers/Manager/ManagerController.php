<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\TravelRequest;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function index()
    {
        // Menghitung jumlah pengajuan yang menunggu ACC Tahap 1
        $pendingL1 = TravelRequest::where('status', 'pending_l1')->count();
        
        // Menghitung total pengajuan yang sudah diproses (Approved/Rejected/Lanjut ke L2)
        $totalProcessed = TravelRequest::whereIn('status', ['pending_l2', 'approved', 'rejected'])->count();
        
        // Mengambil 5 pengajuan terbaru yang masuk ke meja Manajer
        $recentRequests = TravelRequest::with('user')
                            ->where('status', 'pending_l1')
                            ->latest()
                            ->take(5)
                            ->get();

        return view('manager.dashboard', compact('pendingL1', 'totalProcessed', 'recentRequests'));
    }
}