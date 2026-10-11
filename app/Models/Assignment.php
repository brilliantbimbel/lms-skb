<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = ['subject_id', 'classroom_id', 'user_id', 'title', 'description', 'file_path', 'due_date'];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function tutor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
