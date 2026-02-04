<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('nama_bank')->nullable()->after('gaji_pokok');
            $table->string('nomor_rekening')->nullable()->after('nama_bank');
            $table->string('npwp')->nullable()->after('nomor_rekening');
            $table->enum('ptkp_status', [
                'TK/0',
                'TK/1',
                'TK/2',
                'TK/3',
                'K/0',
                'K/1',
                'K/2',
                'K/3',
                'K/I/0',
                'K/I/1',
                'K/I/2',
                'K/I/3'
            ])->nullable()->after('npwp');
            $table->string('bpjs_kesehatan_no')->nullable()->after('ptkp_status');
            $table->string('bpjs_ketenagakerjaan_no')->nullable()->after('bpjs_kesehatan_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn([
                'nama_bank',
                'nomor_rekening',
                'npwp',
                'ptkp_status',
                'bpjs_kesehatan_no',
                'bpjs_ketenagakerjaan_no'
            ]);
        });
    }
};
