<?php

use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin/login');
});
Route::get('/admin', function () {
    return redirect('/admin/login');
});

Route::get('/admin/dashboard', function () {
    return view('Admin.Pages.Dashboard.DashboardPage');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('admin/ticket-list', [TicketController::class, 'TicketIndex']);
    Route::get('admin/ticket-create', [TicketController::class, 'TicketCreate']);
    Route::post('admin/ticket-entry', [TicketController::class, 'TicketEntry']);
    Route::get('admin/ticket-edit/{id}', [TicketController::class, 'TicketEdit']);
    Route::post('admin/ticket-update/{id}', [TicketController::class, 'TicketUpdate']);
    Route::post('admin/ticket-delete', [TicketController::class, 'TicketDelete']);

    Route::get('admin/profile', [ProfileController::class, 'ProfileIndex']);
    Route::get('admin/profile-password-update', [ProfileController::class, 'PasswordUpdatePage']);
    Route::get('admin/profile-edit/{id}', [ProfileController::class, 'ProfileEdit']);
    Route::post('admin/profile-update/{id}', [ProfileController::class, 'ProfileUpdate']);
    Route::post('admin/update-user-password/{id}', [ProfileController::class, 'PasswordUpdate']);

});

require __DIR__.'/auth.php';
