<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Add these helper methods for role checking
    public function isLecturer()
    {
        return false; // Admin is not a lecturer
    }

    public function isStudent()
    {
        return false; // Admin is not a student
    }

    public function isAdmin()
    {
        return true; // This is an admin
    }
} 