<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained();
            $table->string('bulan', 2); 
            $table->string('tahun', 4); 
            $table->decimal('gaji_pokok', 15, 2);
            $table->decimal('total_tunjangan', 15, 2)->default(0);
            $table->decimal('total_potongan', 15, 2)->default(0);
            $table->decimal('total_lembur', 15, 2)->default(0);
            $table->decimal('gaji_kotor', 15, 2);
            $table->decimal('gaji_bersih', 15, 2); 
            $table->enum('status', ['pending', 'approved_hrd', 'approved_finance', 'paid', 'rejected'])
                  ->default('pending');
            $table->foreignId('generated_by')->constrained('users');
            $table->foreignId('finance_approved_by')->nullable()->constrained('users'); 
            $table->timestamp('finance_approved_at')->nullable();
            $table->text('catatan_revisi')->nullable(); 
            $table->timestamps();
            $table->unique(['employee_id', 'bulan', 'tahun']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
