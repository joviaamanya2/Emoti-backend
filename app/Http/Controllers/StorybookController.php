<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Storybook;

class StorybookController extends Controller
{
    /**
     * GET /api/stories
     * List all active stories (with optional category filter + pagination)
     */
    public function index(Request $request)
    {
        $category = $request->query('category');
        $limit = $request->query('limit', 10);

        $query = Storybook::where('is_active', 1);

        if ($category) {
            $query->where('category', $category);
        }

        $stories = $query->latest()
            ->limit($limit)
            ->get();

        return response()->json([
            "success" => true,
            "count" => $stories->count(),
            "data" => $stories
        ]);
    }

    /**
     * GET /api/stories/{id}
     * View single story (full pages included)
     */
    public function show($id)
    {
        $story = Storybook::where('is_active', 1)->find($id);

        if (!$story) {
            return response()->json([
                "success" => false,
                "message" => "Story not found"
            ], 404);
        }

        return response()->json([
            "success" => true,
            "data" => $story
        ]);
    }

    /**
     * GET /api/stories/search?q=
     * Search stories by title or author
     */
    public function search(Request $request)
    {
        $q = $request->query('q');

        if (!$q) {
            return response()->json([
                "success" => false,
                "message" => "Search query is required"
            ]);
        }

        $stories = Storybook::where('is_active', 1)
            ->where(function ($query) use ($q) {
                $query->where('title', 'like', "%$q%")
                      ->orWhere('author', 'like', "%$q%");
            })
            ->latest()
            ->get();

        return response()->json([
            "success" => true,
            "count" => $stories->count(),
            "data" => $stories
        ]);
    }

    /**
     * OPTIONAL FEATURE
     * GET /api/stories/categories/list
     * Get all available categories
     */
    public function categories()
    {
        $categories = Storybook::where('is_active', 1)
            ->select('category')
            ->distinct()
            ->pluck('category');

        return response()->json([
            "success" => true,
            "data" => $categories
        ]);
    }
}