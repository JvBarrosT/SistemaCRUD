<?php

use App\Http\Controllers\ImportController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Importação do JSON
    Route::get('/import', [ImportController::class, 'index'])->name('import.index');
    Route::post('/import', [ImportController::class, 'store'])->name('import.store');

    Route::resource('acs', \App\Http\Controllers\AutoridadeCertificadoraController::class);
    Route::resource('n2s', \App\Http\Controllers\AutoridadeCertificadoraN2Controller::class);
    Route::resource('ars', \App\Http\Controllers\AutoridadeRegistroController::class);
   
    Route::get('/qrcode', [\App\Http\Controllers\QrCodeController::class, 'gerar'])->name('qrcode');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';