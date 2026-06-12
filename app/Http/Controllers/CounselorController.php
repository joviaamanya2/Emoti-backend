<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Counselor;
use Illuminate\Support\Facades\Validator;

class CounselorController extends Controller
{
    /**
     * GET ALL COUNSELORS
     */
    public function index()
    {
        $counselors = Counselor::latest()->get();

        return response()->json([
            "success" => true,
            "data" => $counselors
        ]);
    }

    /**
     * STORE NEW COUNSELOR
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:counselors,email',
            'phone' => 'nullable|string|max:20',
            'specialty' => 'nullable|string|max:255',
            'availability' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "errors" => $validator->errors()
            ], 422);
        }

        $counselor = Counselor::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'specialty' => $request->specialty,
            'availability' => $request->availability,
            'status' => 'active',
        ]);

        return response()->json([
            "success" => true,
            "message" => "Counselor created successfully",
            "data" => $counselor
        ]);
    }

    /**
     * SHOW SINGLE COUNSELOR
     */
    public function show($id)
    {
        $counselor = Counselor::find($id);

        if (!$counselor) {
            return response()->json([
                "success" => false,
                "message" => "Counselor not found"
            ], 404);
        }

        return response()->json([
            "success" => true,
            "data" => $counselor
        ]);
    }

    /**
     * UPDATE COUNSELOR
     */
    public function update(Request $request, $id)
    {
        $counselor = Counselor::find($id);

        if (!$counselor) {
            return response()->json([
                "success" => false,
                "message" => "Counselor not found"
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:counselors,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'specialty' => 'nullable|string|max:255',
            'availability' => 'nullable|string',
            'status' => 'in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "errors" => $validator->errors()
            ], 422);
        }

        $counselor->update($request->only([
            'name',
            'email',
            'phone',
            'specialty',
            'availability',
            'status'
        ]));

        return response()->json([
            "success" => true,
            "message" => "Counselor updated successfully",
            "data" => $counselor
        ]);
    }

    /**
     * DELETE COUNSELOR
     */
    public function destroy($id)
    {
        $counselor = Counselor::find($id);

        if (!$counselor) {
            return response()->json([
                "success" => false,
                "message" => "Counselor not found"
            ], 404);
        }

        $counselor->delete();

        return response()->json([
            "success" => true,
            "message" => "Counselor deleted successfully"
        ]);
    }

    /**
     * TOGGLE STATUS (ACTIVE / INACTIVE)
     */
    public function toggleStatus($id)
    {
        $counselor = Counselor::find($id);

        if (!$counselor) {
            return response()->json([
                "success" => false,
                "message" => "Counselor not found"
            ], 404);
        }

        $counselor->status = $counselor->status === 'active'
            ? 'inactive'
            : 'active';

        $counselor->save();

        return response()->json([
            "success" => true,
            "message" => "Status updated successfully",
            "data" => $counselor
        ]);
    }
}