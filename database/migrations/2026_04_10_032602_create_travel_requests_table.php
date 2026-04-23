<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('travel_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // Relasi ke pembuat (Staff/Manager/Dll)
            
            $table->string('destination');
            $table->text('purpose');
            $table->date('start_date');
            $table->date('end_date');
            
            // Status berjenjang: 'pending_l1', 'pending_l2', 'approved', 'rejected'
            $table->string('status')->default('pending_l1'); 
            
            // Rekam Jejak Level 1 (HRD/Manager/Kepala Marketing)
            $table->foreignId('l1_approver_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('l1_note')->nullable();
            
            // Rekam Jejak Level 2 (Finance)
            $table->foreignId('l2_approver_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('l2_note')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('travel_requests');
    }
};