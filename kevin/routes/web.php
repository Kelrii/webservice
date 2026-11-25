<?php

use App\Http\Controllers\BiodataController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BiodataController::class, 'index'])->name('home');
Route::post('/biodata', [BiodataController::class, 'store'])->name('biodata.store');
Route::put('/biodata/{id}', [BiodataController::class, 'update'])->name('biodata.update');
Route::delete('/biodata/{id}', [BiodataController::class, 'destroy'])->name('biodata.destroy');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::get('/kelvin', function () {
    return view('kelvin');
})->name('kelvin');

Route::get('/tentang', function () {
    return view('tentang');
})->name('tentang');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

require __DIR__.'/settings.php';
