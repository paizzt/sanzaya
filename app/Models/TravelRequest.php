<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelRequest extends Model
{
    use HasFactory;

    // Mengizinkan semua kolom diisi secara massal (mass assignment)
    protected $guarded = ['id'];

    /**
     * Relasi ke tabel users (Pemohon SPPD)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke tabel users (Manajer/HRD yang menyetujui Tahap 1)
     */
    public function l1Approver()
    {
        return $this->belongsTo(User::class, 'l1_approver_id');
    }

    /**
     * Relasi ke tabel users (Finance yang menyetujui Tahap 2)
     */
    public function l2Approver()
    {
        return $this->belongsTo(User::class, 'l2_approver_id');
    }
}