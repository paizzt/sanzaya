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
            $table->string('nota_file')->nullable()->after('status');
            $table->json('hasil_kunjungan')->nullable()->after('nota_file');
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
