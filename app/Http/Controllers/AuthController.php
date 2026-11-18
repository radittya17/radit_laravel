<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectFor(Auth::user());
        }

        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials + ['is_active' => true], $request->boolean('remember'))) {
            $request->session()->regenerate();

            return $this->redirectFor(Auth::user())
                ->with('success', Auth::user()->isAdmin() ? 'Selamat datang kembali, Admin!' : 'Selamat datang kembali!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah, atau akun Anda sedang dinonaktifkan.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'karyawan',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return $this->redirectFor($user)
            ->with('success', 'Pendaftaran berhasil. Selamat datang di Absensi NOK!');
    }

    public function sendResetLink(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $adminExists = User::query()
            ->where('email', $data['email'])
            ->where('role', 'admin')
            ->exists();

        if ($adminExists) {
            $status = Password::sendResetLink(['email' => $data['email']]);

            if ($status !== Password::RESET_LINK_SENT) {
                return back()->withInput()->withErrors([
                    'email' => 'Tautan reset belum dapat dikirim. Silakan coba lagi beberapa saat.',
                ]);
            }
        }

        return back()->with('status', 'Jika email tersebut terdaftar sebagai admin, tautan reset password telah dikirim.');
    }

    public function showResetPassword(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $data = $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $adminExists = User::query()
            ->where('email', $data['email'])
            ->where('role', 'admin')
            ->exists();

        if (! $adminExists) {
            return back()->withInput($request->only('email'))->withErrors([
                'email' => 'Tautan reset tidak valid atau sudah kedaluwarsa.',
            ]);
        }

        $status = Password::reset($data, function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password),
                'remember_token' => Str::random(60),
            ])->save();

            event(new PasswordReset($user));
        });

        if ($status !== Password::PASSWORD_RESET) {
            return back()->withInput($request->only('email'))->withErrors([
                'email' => 'Tautan reset tidak valid atau sudah kedaluwarsa.',
            ]);
        }

        return redirect()->route('login')->with('info', 'Password admin berhasil diubah. Silakan masuk dengan password baru.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('info', 'Anda telah keluar dari aplikasi.');
    }

    private function redirectFor(User $user)
    {
        return redirect()->route($user->isAdmin() ? 'admin.dashboard' : 'karyawan.dashboard');
    }
}
