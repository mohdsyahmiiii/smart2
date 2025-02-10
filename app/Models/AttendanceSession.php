<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceSession extends Model
{
    protected $fillable = [
        'lecturer_id',
        'session_name',
        'qr_code',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function lecturer()
    {
        return $this->belongsTo(User::class, 'lecturer_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'session_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'attendances', 'session_id', 'student_id')
                    ->withTimestamps()
                    ->withPivot('scanned_at');
    }
} 