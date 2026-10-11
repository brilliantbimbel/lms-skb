<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = ['program_id', 'tutor_id', 'name', 'academic_year'];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    public function students()
    {
        return $this->hasMany(User::class, 'classroom_id')->where('role', 'siswa');
    }
}
