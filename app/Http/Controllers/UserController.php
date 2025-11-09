<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $searchKeyword = trim((string) $request->query('q', ''));
        $roleFilter = $request->query('role', '');

        $users = User::when($searchKeyword !== '', function ($query) use ($searchKeyword) {
                $like = '%' . $searchKeyword . '%';
                // Use ILIKE for PostgreSQL case-insensitive search
                $query->where(function ($subQuery) use ($like) {
                    $subQuery->where('name', 'ILIKE', $like)
                        ->orWhere('email', 'ILIKE', $like);
                });
            })
            ->when($roleFilter !== '', function ($query) use ($roleFilter) {
                $query->where('role', $roleFilter);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.users.index', [
            'users' => $users,
            'q' => $searchKeyword,
            'roleFilter' => $roleFilter,
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $id,
                'role' => 'required|in:admin,user',
            ];

            // Only validate password if provided
            if ($request->filled('password')) {
                $rules['password'] = 'required|min:8|confirmed';
            }

            $validated = $request->validate($rules);

            // Only update password if provided
            if (!empty($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']);
            }

            $user->update($validated);

            return redirect()->route('admin.users.index')
                ->with('success', 'User berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Prevent deleting yourself
            if ($user->id === auth()->id()) {
                return redirect()->route('admin.users.index')
                    ->with('error', 'Anda tidak dapat menghapus akun sendiri!');
            }

            // Prevent deleting the last admin
            if ($user->role === 'admin') {
                $adminCount = User::where('role', 'admin')->count();
                if ($adminCount <= 1) {
                    return redirect()->route('admin.users.index')
                        ->with('error', 'Tidak dapat menghapus admin terakhir!');
                }
            }
            
            $user->delete();

            return redirect()->route('admin.users.index')
                ->with('success', 'User berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

