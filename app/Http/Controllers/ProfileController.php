<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('profile.edit', ['user' => $request->user()]);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_photo' => ['nullable', 'boolean'],
        ]);

        $oldPhotoPath = $user->profile_photo_path;
        if ($request->hasFile('photo')) {
            $newPhotoPath = $request->file('photo')->store('profile-photos', 'public');
            if (! $newPhotoPath) {
                return back()->withInput()->withErrors(['photo' => 'Foto belum dapat disimpan. Silakan coba lagi.']);
            }
            $data['profile_photo_path'] = $newPhotoPath;
        } elseif ($request->boolean('remove_photo') && $oldPhotoPath) {
            $data['profile_photo_path'] = null;
        }

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        unset($data['photo'], $data['remove_photo'], $data['password_confirmation']);
        $user->update($data);

        if ($oldPhotoPath && $oldPhotoPath !== $user->profile_photo_path) {
            $this->deletePhoto($oldPhotoPath);
        }

        return back()->with('success', 'Profil Anda berhasil diperbarui.');
    }

    private function deletePhoto(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
