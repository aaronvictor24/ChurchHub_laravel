<?php

use App\Http\Controllers\Auth\LoginController as AuthLoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PastorController;
use App\Http\Controllers\ChurchController;
use App\Http\Controllers\SecretaryController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\Secretary\CalendarController;
use App\Http\Controllers\Secretary\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// 🔹 Login Routes
Route::get('/login', [AuthLoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthLoginController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthLoginController::class, 'logout'])->name('logout');



// 🔹 Admin 
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');

        Route::resource('churches', ChurchController::class);
        Route::resource('pastors', PastorController::class);
        Route::resource('secretaries', SecretaryController::class);
        Route::resource('members', MemberController::class)->only(['show']);

        Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])
            ->name('notifications.read');

        Route::get('/members/{member_id}', [MemberController::class, 'show'])
            ->name('members.show');

        Route::get('/notifications/{notification}/view-member', [App\Http\Controllers\Admin\NotificationController::class, 'viewMember'])
            ->name('notifications.viewMember');

        Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])
            ->name('notifications.destroy');
    });



// 🔹 Secretary Routes
Route::middleware(['auth', 'role:secretary'])
    ->prefix('secretary')
    ->name('secretary.')
    ->group(function () {
        Route::get('/', fn() => redirect()->route('secretary.dashboard'));
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');
        Route::resource('members', App\Http\Controllers\MemberController::class);
        Route::resource('events', EventController::class);

        Route::post('events/{event}/attendance', [EventController::class, 'updateAttendance'])
            ->name('events.attendance.update');
    });

// 🔹 Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
