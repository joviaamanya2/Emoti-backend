<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        return response()->json(
            Game::where('is_active', true)->get()
        );
    }

    public function show(Game $game)
    {
        return response()->json($game);
    }
}