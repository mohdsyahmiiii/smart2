<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:student');
    }

    public function dashboard()
    {
        return view('student.dashboard');
    }

    public function attendanceHistory()
    {
        $attendances = auth()->user()
            ->attendances()
            ->with('session')
            ->latest()
            ->paginate(10);

        return view('student.attendance-history', compact('attendances'));
    }
} 