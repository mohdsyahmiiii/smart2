<?php

namespace App\Services;

use App\Models\AttendanceSession;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Carbon\Carbon;

class QrCodeService
{
    public function generateSessionQR($lecturerId, $sessionName)
    {
        // Generate a unique token for the QR code
        $token = Str::random(32);
        
        // Set expiration time (e.g., 15 minutes from now)
        $expiresAt = now()->addMinutes(15);
        
        // Create a new attendance session
        $session = AttendanceSession::create([
            'lecturer_id' => $lecturerId,
            'session_name' => $sessionName,
            'qr_code' => $token,
            'expires_at' => $expiresAt,
            'is_active' => true,
        ]);

        // Generate QR code
        $qrCode = QrCode::size(300)->generate(route('attendance.scan', $token));

        return [
            'qrCode' => $qrCode,
            'sessionName' => $sessionName,
            'expiresIn' => 15,
            'session' => $session
        ];
    }
} 