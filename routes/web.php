<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentController;

// Auth Routes
Route::get('/', function () { return redirect()->route('login'); });
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    // Dokumen
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/create', [DocumentController::class, 'create'])->name('documents.create');
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('/documents/location', [DocumentController::class, 'location'])->name('documents.location');
    Route::get('/documents/{document}', [DocumentController::class, 'show'])->name('documents.show');
    Route::get('/documents/{document}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
    Route::put('/documents/{document}', [DocumentController::class, 'update'])->name('documents.update');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
    Route::get('/documents/{document}/preview', [DocumentController::class, 'preview'])->name('documents.preview');
	Route::get('/location', [DocumentController::class, 'location'])->name('documents.location');
Route::get('/location/{cabinet}', [DocumentController::class, 'cabinetDetail'])->name('documents.cabinet');
Route::get('/location/{cabinet}/{ordner}', [DocumentController::class, 'ordnerDetail'])->name('documents.ordner');

    // Akun
    Route::get('/profile/password', [AuthController::class, 'showChangePassword'])->name('password.change');
    Route::post('/profile/password', [AuthController::class, 'updatePassword'])->name('password.update');
});