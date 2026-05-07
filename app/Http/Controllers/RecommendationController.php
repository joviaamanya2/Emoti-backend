<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    public function index()
    {
        return Recommendation::all();
    }

    public function store(Request $request)
    {
        $data = $request->all();

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('uploads', 'public');
        }

        return Recommendation::create($data);
    }

    public function update(Request $request, $id)
    {
        $rec = Recommendation::findOrFail($id);

        $data = $request->all();

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('uploads', 'public');
        }

        $rec->update($data);

        return $rec;
    }

    public function destroy($id)
    {
        Recommendation::destroy($id);
        return response()->json(["message" => "Deleted"]);
    }
}
