<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Journal; // Assuming you have a Journal model
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function index(): JsonResponse
    {
        // Fetch all journals with user info
        $journals = Journal::with('user:id,name')->latest()->get();
        return response()->json($journals);
    }
}