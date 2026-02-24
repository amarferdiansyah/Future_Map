<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit()
    {
        $user = auth()->user();
        
        // Load profile jika belum ada
        if (!$user->profile) {
            $user->profile()->create([]);
        }
        
        $majors = Major::all();
        
        return view('profile.edit', compact('user', 'majors'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'nim' => 'nullable|string|unique:users,nim,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'nim' => $request->nim,
        ]);

        return redirect()->route('profile.edit')->with('success', 'Profile berhasil diperbarui.');
    }

    /**
     * Update the user's profile details.
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $profile = $user->profile;
        
        $request->validate([
            'major_id' => 'nullable|exists:majors,id',
            'semester' => 'nullable|integer|min:1|max:14',
            'gpa' => 'nullable|numeric|min:0|max:4',
            'graduation_date' => 'nullable|date',
            'linkedin_url' => 'nullable|url',
            'portfolio_url' => 'nullable|url',
            'bio' => 'nullable|string|max:1000',
        ]);

        $profile->update($request->only([
            'major_id', 'semester', 'gpa', 'graduation_date',
            'linkedin_url', 'portfolio_url', 'bio'
        ]));

        return redirect()->route('profile.edit')->with('success', 'Data profil berhasil diperbarui.');
    }

    /**
     * Upload CV file.
     */
    public function uploadCv(Request $request)
    {
        $request->validate([
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $user = auth()->user();
        $profile = $user->profile;

        // Hapus CV lama jika ada
        if ($profile->cv_path) {
            $oldPath = public_path('uploads/cvs/' . $profile->cv_path);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        // Upload CV baru
        $file = $request->file('cv');
        $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/cvs'), $filename);
        
        $profile->update(['cv_path' => $filename]);

        return redirect()->route('profile.edit')->with('success', 'CV berhasil diupload.');
    }

    /**
     * Update avatar.
     */
    public function updateAvatar(Request $request)
    {
    $request->validate([
        'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $user = auth()->user();

    // Hapus avatar lama jika ada
    if ($user->avatar) {
        $oldPath = public_path('uploads/avatars/' . $user->avatar);
        if (file_exists($oldPath)) {
            unlink($oldPath);
        }
    }

    // Upload avatar baru
    $file = $request->file('avatar');
    $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
    $file->move(public_path('uploads/avatars'), $filename);
    
    $user->update(['avatar' => $filename]);

    return redirect()->route('profile.edit')->with('success', 'Foto profile berhasil diperbarui.');
    }

    /**
     * Update password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Cek password saat ini
        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        auth()->user()->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('profile.edit')->with('success', 'Password berhasil diperbarui.');
    }

    /**
     * Delete account.
     */
    public function destroy()
    {
        $user = auth()->user();
        
        // Hapus file-file terkait
        if ($user->avatar) {
            $avatarPath = public_path('uploads/avatars/' . $user->avatar);
            if (file_exists($avatarPath)) {
                unlink($avatarPath);
            }
        }
        
        if ($user->profile && $user->profile->cv_path) {
            $cvPath = public_path('uploads/cvs/' . $user->profile->cv_path);
            if (file_exists($cvPath)) {
                unlink($cvPath);
            }
        }

        // Hapus user
        $user->delete();

        auth()->logout();

        return redirect('/')->with('success', 'Akun Anda telah dihapus.');
    }
}