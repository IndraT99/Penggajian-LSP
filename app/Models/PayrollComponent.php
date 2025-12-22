<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollComponent extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_komponen',
        'tipe',
        'is_fixed',
        'jumlah_default',
    ];

    protected function casts(): array
    {
        return [
            'is_fixed' => 'boolean',
            'jumlah_default' => 'decimal:2',
        ];
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_components')
                    ->withPivot('jumlah');
    }
}