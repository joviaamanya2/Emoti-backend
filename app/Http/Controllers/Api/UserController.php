<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Get logged-in user profile
     */
    public function profile()
    {
        $user = auth()->user();
        
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'gender' => $user->gender ?? null,
            'contact' => $user->contact ?? null,
            'address' => $user->address ?? null,
            'created_at' => $user->created_at,
        ]);
    }

    /**
     * Update profile (name, email, contact, address)
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'contact' => 'sometimes|nullable|string|max:20',
            'address' => 'sometimes|nullable|string|max:255',
        ]);

        $user->update($request->only(['name', 'email', 'contact', 'address']));

        return response()->json([
            'message' => 'Profile updated successfully.',
            'statusCode' => 200,
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'gender' => $user->gender ?? null,
                'contact' => $user->contact ?? null,
                'address' => $user->address ?? null,
            ],
        ]);
    }

    /**
     * Change password (requires current password verification)
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ]);

        $user = auth()->user();

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'Current password is incorrect.',
                'statusCode' => 400,
            ], 400);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'Password changed successfully.',
            'statusCode' => 200,
        ]);
    }

    /**
     * Admin: Get all users with pagination
     */
    public function index()
    {
        // Ensure the user is an admin
        if (!auth()->user()->isAdmin()) {
            return response()->json([
                'message' => 'Unauthorized. Admin access required.',
                'statusCode' => 403,
            ], 403);
        }

        // Get users with pagination (10 per page), newest first
        $users = User::select('id', 'name', 'email', 'role', 'created_at')
                     ->latest()
                     ->paginate(10);

        return response()->json($users);
    }

    /**
     * Admin: Delete user
     */
    public function destroy($id)
    {
        // Ensure the user is an admin
        if (!auth()->user()->isAdmin()) {
            return response()->json([
                'message' => 'Unauthorized. Admin access required.',
                'statusCode' => 403,
            ], 403);
        }

        // Safety check: Prevent deleting yourself
        if (auth()->id() == $id) {
            return response()->json([
                'message' => 'You cannot delete your own account.',
                'statusCode' => 400,
            ], 400);
        }

        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully.',
            'statusCode' => 200,
        ]);
    }
}