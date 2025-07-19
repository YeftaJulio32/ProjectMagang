<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use App\Models\User;
use App\Models\Comment;

class UserController extends Controller
{
    /**
     * Show user dashboard
     */
    public function dashboard()
    {
        return view('user.dashboard', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Show edit profile form
     */
    public function editProfile()
    {
        return view('user.dashboard', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Update profile
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'remove_avatar' => ['nullable', 'in:0,1'],
        ]);

        $user = Auth::user();
        $updateData = [
            'name' => $request->name,
        ];

        // Handle avatar removal
        if ($request->remove_avatar == '1') {
            $currentUser = User::find(Auth::id());
            if (
                $currentUser->avatar_url &&
                strpos($currentUser->avatar_url, '/storage/avatars/') === 0 &&
                $currentUser->avatar_url !== '/storage/avatars/default-avatar.png'
            ) {
                // Delete old avatar file
                $oldAvatarPath = str_replace('/storage/', '', $currentUser->avatar_url);
                if (Storage::disk('public')->exists($oldAvatarPath)) {
                    Storage::disk('public')->delete($oldAvatarPath);
                }
            }
            // Set avatar to null so it will use default
            $updateData['avatar_url'] = null;
        }
        // Handle avatar upload
        elseif ($request->hasFile('avatar')) {
            // Delete old avatar if exists (but not default-avatar.png)
            $currentUser = User::find(Auth::id());
            if (
                $currentUser->avatar_url &&
                strpos($currentUser->avatar_url, '/storage/avatars/') === 0 &&
                $currentUser->avatar_url !== '/storage/avatars/default-avatar.png'
            ) {
                // Extract filename from URL path
                $oldAvatarPath = str_replace('/storage/', '', $currentUser->avatar_url);
                if (Storage::disk('public')->exists($oldAvatarPath)) {
                    Storage::disk('public')->delete($oldAvatarPath);
                }
            }

            // Upload new avatar
            $avatar = $request->file('avatar');
            $avatarName = time() . '_' . uniqid() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = $avatar->storeAs('avatars', $avatarName, 'public');
            $updateData['avatar_url'] = '/storage/' . $avatarPath;
        }

        // Update user data
        User::where('id', Auth::id())->update($updateData);

        return redirect()->route('user.profile.show')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Show change password form
     */
    public function changePassword()
    {
        return view('user.dashboard', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai']);
        }

        User::where('id', Auth::id())->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('user.profile.show')->with('success', 'Password berhasil diubah!');
    }
}
