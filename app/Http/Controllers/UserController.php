<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::all();
            return response()->json($users);
        } catch (\Exception $e) {
            Log::error('Error fetching users: ', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error fetching users', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        if (!Str::isUuid($id)) {
            return response()->json(['message' => 'Invalid UUID format'], 400);
        }

        $user = User::find($id, ['id', 'last_name', 'name', 'middle_name', 'email', 'phone']);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }



    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'last_name' => 'sometimes|required|string|max:40',
            'name' => 'sometimes|required|string|max:40',
            'middle_name' => 'nullable|string|max:40',
            'email' => 'sometimes|required|string|email|max:80|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($data);
        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User soft deleted successfully']);
    }

    public function trashed()
    {

        $trashedUsers = User::onlyTrashed()->get();

        return response()->json($trashedUsers);
    }

    public function restore(User $user)
    {
        $user->restore();
        return response()->json(['message' => 'User restored successfully']);
    }

    public function forceDelete(User $user)
    {
        $user->forceDelete();
        return response()->json(['message' => 'User permanently deleted successfully']);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->validate(['ids' => 'required|array']);
        User::whereIn('id', $ids['ids'])->delete();
        return response()->json(['message' => 'Users soft deleted successfully']);
    }

    public function bulkRestore(Request $request)
    {
        $ids = $request->validate(['ids' => 'required|array']);
        User::withTrashed()->whereIn('id', $ids['ids'])->restore();
        return response()->json(['message' => 'Users restored successfully']);
    }

    public function bulkForceDelete(Request $request)
    {
        $ids = $request->validate(['ids' => 'required|array']);
        User::withTrashed()->whereIn('id', $ids['ids'])->forceDelete();
        return response()->json(['message' => 'Users permanently deleted successfully']);
    }
}
