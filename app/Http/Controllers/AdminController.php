<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function dashboard(Request $request)
    {
        $query = User::query();
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('role', 'like', "%$search%")
                    ->orWhere('joined_at', 'like', "%$search%")
                    ->orWhere('id', $search);
            });
        }
        $users = $query->orderByDesc('created_at')->paginate(10);
        return view('admin.dashboard', compact('users'));
    }

    /**
     * Show create user form
     */
    public function createUser()
    {
        return view('admin.profile.create');
    }

    /**
     * Store new user
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,user'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '_' . uniqid() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = $avatar->storeAs('avatars', $avatarName, 'public');
            $avatarPath = '/storage/' . $avatarPath;
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'joined_at' => now(),
            'avatar_url' => $avatarPath,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Delete user
     */
    public function deleteUser(User $user)
    {
        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Tidak dapat menghapus admin!');
        }

        // Delete avatar if exists (but not default-avatar.png)
        if (
            $user->avatar_url &&
            strpos($user->avatar_url, '/storage/avatars/') === 0 &&
            $user->avatar_url !== '/storage/avatars/default-avatar.png'
        ) {
            $avatarPath = str_replace('/storage/', '', $user->avatar_url);
            if (Storage::disk('public')->exists($avatarPath)) {
                Storage::disk('public')->delete($avatarPath);
            }
        }

        $user->delete();
        return redirect()->route('admin.dashboard')->with('success', 'User berhasil dihapus!');
    }

    /**
     * Show admin profile
     */
    public function showProfile($id)
    {
        $admin = User::findOrFail($id);
        return view('admin.profile.show', compact('admin'));
    }

    /**
     * Edit admin profile
     */
    public function editProfile($id)
    {
        $admin = User::findOrFail($id);
        return view('admin.profile.edit', compact('admin'));
    }

    /**
     * Update admin profile
     */
    public function updateProfile(Request $request, $id)
    {
        $admin = User::findOrFail($id);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'remove_avatar' => ['nullable', 'in:0,1'],
        ]);

        $admin->name = $request->name;

        // Debug: log request data
        Log::info('Remove avatar request:', ['remove_avatar' => $request->remove_avatar]);

        // Handle avatar removal
        if ($request->remove_avatar == '1') {
            Log::info('Processing avatar removal for admin:', ['id' => $admin->id, 'current_avatar' => $admin->avatar_url]);
            if (
                $admin->avatar_url &&
                strpos($admin->avatar_url, '/storage/avatars/') === 0 &&
                $admin->avatar_url !== '/storage/avatars/default-avatar.png'
            ) {
                // Delete old avatar file
                $oldAvatarPath = str_replace('/storage/', '', $admin->avatar_url);
                if (Storage::disk('public')->exists($oldAvatarPath)) {
                    Storage::disk('public')->delete($oldAvatarPath);
                    Log::info('Old avatar deleted:', ['path' => $oldAvatarPath]);
                }
            }
            // Set avatar to null so it will use default
            $admin->avatar_url = null;
            Log::info('Avatar set to null');
        }
        // Handle avatar upload
        elseif ($request->hasFile('avatar')) {
            // Delete old avatar if exists (but not default-avatar.png)
            if (
                $admin->avatar_url &&
                strpos($admin->avatar_url, '/storage/avatars/') === 0 &&
                $admin->avatar_url !== '/storage/avatars/default-avatar.png'
            ) {
                $oldAvatarPath = str_replace('/storage/', '', $admin->avatar_url);
                if (Storage::disk('public')->exists($oldAvatarPath)) {
                    Storage::disk('public')->delete($oldAvatarPath);
                }
            }

            // Upload new avatar
            $avatar = $request->file('avatar');
            $avatarName = time() . '_' . uniqid() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = $avatar->storeAs('avatars', $avatarName, 'public');
            $admin->avatar_url = '/storage/' . $avatarPath;
        }

        // Handle password update
        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->route('admin.profile.show', $admin->id)->with('success', 'Profil berhasil diperbarui!');
    }
}
