<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSession;
use Illuminate\Http\Request;

class LecturerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:lecturer');
    }

    public function dashboard()
    {
        $recentSessions = AttendanceSession::with('attendances')
            ->where('lecturer_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        return view('lecturer.dashboard', compact('recentSessions'));
    }
} 