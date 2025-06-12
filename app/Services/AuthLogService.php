<?php

namespace App\Services;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class AuthLogService
{
    public function logLoginAttempt($success, $credentials = null)
    {
        Log::create([
            'user_id' => Auth::id(),
            'action' => $success ? 'login_success' : 'login_failed',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'details' => [
                'email' => $credentials['email'] ?? null,
                'success' => $success
            ]
        ]);
    }

    public function logLogout()
    {
        Log::create([
            'user_id' => Auth::id(),
            'action' => 'logout',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }

    public function logSessionStart()
    {
        Log::create([
            'user_id' => Auth::id(),
            'action' => 'session_start',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }
} 