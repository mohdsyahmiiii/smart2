<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSession;
use App\Models\Attendance;
use App\Services\QrCodeService;
use Illuminate\Http\Request;
use PDF;
use Telegram\Bot\Laravel\Facades\Telegram;

class AttendanceController extends Controller
{
    protected $qrCodeService;

    public function __construct(QrCodeService $qrCodeService)
    {
        $this->qrCodeService = $qrCodeService;
    }

    public function generateQR(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('lecturer.qr');
        }

        $request->validate([
            'session_name' => 'required|string|max:255'
        ]);

        $result = $this->qrCodeService->generateSessionQR(auth()->id(), $request->session_name);
        
        return view('lecturer.qr', [
            'qrCode' => $result['qrCode'],
            'sessionName' => $result['sessionName'],
            'expiresIn' => $result['expiresIn'],
            'session' => $result['session']
        ]);
    }

    public function scan($token)
    {
        $session = AttendanceSession::where('qr_code', $token)
            ->where('is_active', true)
            ->where('expires_at', '>', now())
            ->firstOrFail();

        $attendance = Attendance::create([
            'session_id' => $session->id,
            'student_id' => auth()->id(),
            'scanned_at' => now(),
        ]);

        // Send notification to Telegram with session name, lecturer, and student ID
        Telegram::sendMessage([
            'chat_id' => env('TELEGRAM_CHANNEL_ID'),
            'text' => "Session: {$session->session_name}\n" .
                     "Lecturer: {$session->lecturer->name}\n" .
                     "Student: {$attendance->student->name}\n" .
                     "Student ID: {$attendance->student->student->student_id}\n" .
                     "Time: {$attendance->scanned_at}",
        ]);

        return redirect()->route('student.dashboard')->with('success', 'Attendance recorded successfully!');
    }

    public function generateReport()
    {
        $attendances = AttendanceSession::with(['attendances.student'])
            ->where('lecturer_id', auth()->id())
            ->get();

        $pdf = PDF::loadView('lecturer.report', compact('attendances'));
        return $pdf->download('attendance-report.pdf');
    }

    public function analytics()
    {
        $sessions = AttendanceSession::where('lecturer_id', auth()->id())
            ->withCount('attendances')
            ->orderBy('created_at', 'desc')
            ->get();

        // Prepare data for chart
        $chartData = [
            'labels' => $sessions->pluck('created_at')->map(function($date) {
                return $date->format('d M Y H:i');
            }),
            'data' => $sessions->pluck('attendances_count'),
        ];

        return view('lecturer.analytics', compact('sessions', 'chartData'));
    }

    public function getAttendees(AttendanceSession $session)
    {
        if ($session->lecturer_id !== auth()->id()) {
            abort(403);
        }

        return $session->attendances()->with('student:id,name')->get();
    }

    public function viewAttendees(AttendanceSession $session)
    {
        // Check if the logged-in lecturer owns this session
        if ($session->lecturer_id !== auth()->id()) {
            abort(403);
        }

        $attendees = $session->attendances()
            ->with('student.student') // This assumes there's a student relationship in your User model
            ->get();

        return view('attendance.attendees', compact('session', 'attendees'));
    }
} 