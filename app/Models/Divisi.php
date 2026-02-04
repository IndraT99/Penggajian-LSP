<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory, \App\Traits\HashIdRoute;

    protected $fillable = ['nama_divisi'];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}