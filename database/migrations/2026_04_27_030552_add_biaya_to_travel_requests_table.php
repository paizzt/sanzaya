<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('travel_requests', function (Blueprint $table) {
            $table->decimal('biaya_makan', 12, 2)->default(0);
            $table->decimal('biaya_penginapan', 12, 2)->default(0);
            $table->decimal('biaya_bensin', 12, 2)->default(0);
            $table->decimal('total_biaya', 12, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('travel_requests', function (Blueprint $table) {
            //
        });
    }
};
