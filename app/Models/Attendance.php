<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'online_meeting_id',
        'student_id',
        'status',
        'notes',
    ];

    public function onlineMeeting()
    {
        return $this->belongsTo(OnlineMeeting::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
