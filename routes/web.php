<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));
Route::view('/tentang', 'about')->name('about');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:6,1')->name('login.attempt');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:6,1')->name('register.store');
    Route::get('/lupa-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/lupa-password', [AuthController::class, 'sendResetLink'])->middleware('throttle:3,1')->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->middleware('throttle:6,1')->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profil', [ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth', 'active', 'role:karyawan'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('karyawan.dashboard');
    Route::post('/absensi/masuk', [AttendanceController::class, 'recordEntry'])->name('attendance.masuk');
    Route::post('/cuti', [LeaveController::class, 'store'])->name('leaves.store');
});

Route::middleware(['auth', 'active', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/shift-feed', [AdminController::class, 'shiftFeed'])->name('dashboard.shift-feed');
    Route::get('/karyawan', [EmployeeController::class, 'index'])->name('employees.index');
    Route::post('/karyawan', [EmployeeController::class, 'store'])->name('employees.store');
    Route::put('/karyawan/{user}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/karyawan/{user}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    Route::get('/laporan', [AdminController::class, 'report'])->name('reports.index');
    Route::get('/laporan/export', [AdminController::class, 'exportReport'])->name('reports.export');
    Route::get('/laporan/export-pdf', [AdminController::class, 'exportReportPdf'])->name('reports.export-pdf');
    Route::patch('/cuti/{leave}', [LeaveController::class, 'updateStatus'])->name('leaves.update-status');
});
