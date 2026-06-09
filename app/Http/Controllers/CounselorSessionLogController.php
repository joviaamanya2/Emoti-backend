<?php

namespace App\Http\Controllers;

use App\Models\CounselorSessionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CounselorSessionLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Submit a new session log (with screenshot upload)
     */
    public function store(Request $request)
    {
        // 🔒 Only counselors and admins can submit
        $user = $request->user();
        if (!in_array($user->role, ['counselor', 'admin'])) {
            return response()->json([
                'message' => 'Unauthorized: Only counselors can submit session logs',
            ], 403);
        }

        $validated = $request->validate([
            'counselor_name'    => 'required|string|max:255',
            'counselor_email'   => 'required|email|max:255',
            'counselor_contact' => 'required|string|max:255',
            'client_name'       => 'required|string|max:255',
            'specification'     => 'required|string|max:255',
            'session_notes'     => 'nullable|string',
            'screenshot'        => 'required|image|max:5120', // max 5MB
        ]);

        // Handle screenshot upload
        $screenshotPath = null;
        if ($request->hasFile('screenshot')) {
            $screenshotPath = $request->file('screenshot')->store('session_screenshots', 'public');
        }

        $sessionLog = CounselorSessionLog::create([
            'counselor_id'     => $user->id,
            'counselor_name'   => $validated['counselor_name'],
            'counselor_email'  => $validated['counselor_email'],
            'counselor_contact' => $validated['counselor_contact'],
            'client_name'      => $validated['client_name'],
            'specification'    => $validated['specification'],
            'session_notes'    => $validated['session_notes'] ?? null,
            'screenshot_path'  => $screenshotPath,
        ]);

        return response()->json([
            'message' => 'Session log submitted successfully',
            'data'    => $sessionLog,
        ], 201);
    }

    /**
     * List session logs for the authenticated counselor
     */
    public function index(Request $request)
    {
        $user = $request->user();
        if (!in_array($user->role, ['counselor', 'admin'])) {
            return response()->json([
                'message' => 'Unauthorized: Only counselors can view session logs',
            ], 403);
        }

        $logs = CounselorSessionLog::where('counselor_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($log) {
                return [
                    'id'                => $log->id,
                    'counselor_name'    => $log->counselor_name,
                    'counselor_email'   => $log->counselor_email,
                    'counselor_contact' => $log->counselor_contact,
                    'client_name'       => $log->client_name,
                    'specification'     => $log->specification,
                    'session_notes'     => $log->session_notes,
                    'screenshot_url'    => $log->screenshot_path 
                        ? asset('storage/' . $log->screenshot_path) 
                        : null,
                    'created_at'        => $log->created_at->toIso8601String(),
                ];
            });

        return response()->json([
            'data' => $logs,
        ], 200);
    }
}