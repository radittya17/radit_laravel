<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q'));
        $employees = User::query()
            ->where('role', 'karyawan')
            ->when($search, fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%");
            }))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.employees.index', compact('employees', 'search'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['role'] = 'karyawan';
        $data['password'] = Hash::make($data['password']);
        unset($data['password_confirmation']);

        User::create($data);

        return back()->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        abort_unless($user->role === 'karyawan', 404);
        $data = $this->validated($request, $user);
        $data['role'] = 'karyawan';

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }
        unset($data['password_confirmation']);

        $user->update($data);

        return back()->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy(Request $request, User $user)
    {
        abort_unless($user->role === 'karyawan', 404);
        abort_if($user->is($request->user()), 422, 'Akun yang sedang digunakan tidak dapat dihapus.');

        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }
        $user->delete();

        return back()->with('success', 'Data karyawan berhasil dihapus.');
    }

    private function validated(Request $request, ?User $user = null): array
    {
        return $request->validate([
            'nip' => ['nullable', 'string', 'max:50', Rule::unique('users', 'nip')->ignore($user)],
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', Rule::unique('users', 'email')->ignore($user)],
            'jabatan' => ['nullable', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:30'],
            'is_active' => ['required', 'boolean'],
            'password' => [$user ? 'nullable' : 'required', 'confirmed', 'min:8'],
        ]);
    }
}
