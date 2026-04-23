<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\TravelRequest;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index()
    {
        // Menghitung jumlah pengajuan yang lolos dari Manajer dan menunggu Finance (Tahap 2)
        $pendingL2 = TravelRequest::where('status', 'pending_l2')->count();
        
        // Menghitung total pengajuan yang sudah beres (Selesai/Approved)
        $totalApproved = TravelRequest::where('status', 'approved')->count();
        
        // Mengambil 5 pengajuan terbaru yang masuk ke meja Finance
        $recentRequests = TravelRequest::with('user')
                            ->where('status', 'pending_l2')
                            ->latest()
                            ->take(5)
                            ->get();

        return view('finance.dashboard', compact('pendingL2', 'totalApproved', 'recentRequests'));
    }
}