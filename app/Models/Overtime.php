<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'total_jam',
        'alasan_lembur',
        'biaya_lembur',
        'status',
        'approved_by',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'biaya_lembur' => 'decimal:2',
        ];
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}