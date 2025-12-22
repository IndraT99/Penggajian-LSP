<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'bulan',
        'tahun',
        'gaji_pokok',
        'total_tunjangan',
        'total_potongan',
        'total_lembur',
        'gaji_kotor',
        'gaji_bersih',
        'status',
        'generated_by',
        'finance_approved_by',
        'finance_approved_at',
        'catatan_revisi',
    ];

    protected function casts(): array
    {
        return [
            'gaji_pokok' => 'decimal:2',
            'total_tunjangan' => 'decimal:2',
            'total_potongan' => 'decimal:2',
            'total_lembur' => 'decimal:2',
            'gaji_kotor' => 'decimal:2',
            'gaji_bersih' => 'decimal:2',
            'finance_approved_at' => 'datetime',
            'bulan' => 'integer',
            'tahun' => 'integer',
        ];
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function details()
    {
        return $this->hasMany(PayrollDetail::class);
    }

    public function generatedBy()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }

    public function financeApprovedBy()
    {
        return $this->belongsTo(User::class, 'finance_approved_by');
    }
}