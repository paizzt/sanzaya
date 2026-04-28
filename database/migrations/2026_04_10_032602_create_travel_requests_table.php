<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('travel_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // --- TAMBAHKAN KOLOM INI ---
            $table->string('departure'); 
            
            $table->string('destination');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('companion_1')->nullable();
            $table->string('companion_2')->nullable();
            $table->string('transportation_type');
            $table->string('vehicle_number')->nullable();
            $table->enum('status', ['pending_l1', 'pending_l2', 'approved', 'rejected'])->default('pending_l1');
            $table->text('l1_note')->nullable();
            $table->text('l2_note')->nullable();
            $table->foreignId('l1_approver_id')->nullable()->constrained('users');
            $table->foreignId('l2_approver_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('travel_requests');
    }
};