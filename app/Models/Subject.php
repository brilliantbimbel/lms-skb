<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'program_id',
        'tutor_id',
        'description',
    ];

    // Relasi ke Program Kesetaraan
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    // Relasi ke Tutor / Pamong Pengampu
    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }
}
