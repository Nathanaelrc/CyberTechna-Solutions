<?php

use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/servicios', [HomeController::class, 'services'])->name('services');
Route::get('/servicios/{service:slug}', [HomeController::class, 'service'])->name('services.show');
Route::get('/metodo', [HomeController::class, 'method'])->name('method');
Route::get('/cursos', [HomeController::class, 'courses'])->name('courses');
Route::get('/cursos/{course:slug}', [HomeController::class, 'course'])->name('courses.show');
Route::get('/contacto', [HomeController::class, 'contact'])->name('contact');
Route::get('/insights/{post:slug}', [HomeController::class, 'show'])->name('posts.show');
Route::post('/contacto', [ContactMessageController::class, 'store'])->name('contact.store');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::prefix('panel')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/mensajes', [DashboardController::class, 'messages'])->name('messages.index');
        Route::patch('/mensajes/{contactMessage}/review', [DashboardController::class, 'markMessageAsReviewed'])
            ->name('messages.review');
        Route::resource('services', ServiceController::class)->except('show');
        Route::resource('courses', CourseController::class)->except('show');
        Route::resource('posts', PostController::class)->except('show');
    });
