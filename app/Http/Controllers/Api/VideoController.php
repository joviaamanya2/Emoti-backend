<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        return response()->json(
            Video::where('is_active', true)->get()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'video_url' => 'required|url',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'duration' => 'nullable|integer',
        ]);

        $video = Video::create($validated);

        return response()->json($video, 201);
    }

    public function show(Video $video)
    {
        return response()->json($video);
    }

    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string',
            'video_url' => 'sometimes|url',
            'category' => 'sometimes|string',
            'description' => 'nullable|string',
            'duration' => 'nullable|integer',
        ]);

        $video->update($validated);

        return response()->json($video);
    }

    public function destroy(Video $video)
    {
        $video->delete();

        return response()->json([
            'message' => 'Video deleted successfully'
        ]);
    }
}