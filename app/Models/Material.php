<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = ['subject_id', 'classroom_id', 'user_id', 'title', 'content', 'file_path', 'video_url'];

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
}
