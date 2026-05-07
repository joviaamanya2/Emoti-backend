<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Get logged-in user profile
    public function profile()
    {
        return response()->json(auth()->user());
    }

    // Update profile
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'contact' => 'sometimes|string|max:20',
            'address' => 'sometimes|string|max:255',
            'password' => 'sometimes|min:6'
        ]);

        if ($request->password) {
            $request->merge([
                'password' => Hash::make($request->password)
            ]);
        }

        $user->update($request->only(['name', 'email', 'password', 'contact', 'address']));

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user
        ]);
    }

    // Admin: get all users (WITH PAGINATION)
    public function index()
    {
        // Ensure the user is an admin
        if (!auth()->user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Get users with pagination (10 per page), newest first, selecting only necessary columns
        $users = User::select('id', 'name', 'email', 'created_at')
                     ->latest()
                     ->paginate(10); 

        return response()->json($users);
    }
    
    // Admin: delete user
    public function destroy($id)
    {
        // Ensure the user is an admin
        if (!auth()->user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Safety check: Prevent deleting yourself
        if (auth()->id() == $id) {
            return response()->json(['message' => 'You cannot delete your own account'], 400);
        }

        User::findOrFail($id)->delete();

        return response()->json(['message' => 'User deleted']);
    }
}