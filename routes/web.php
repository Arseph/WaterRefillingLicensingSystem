<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/Home', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard')->middleware('verified');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('verified');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware('verified');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy')->middleware('verified');
});

Route::get('logout', function(){
    auth()->logout();
    return to_route('login');
});

Route::get('/Initial', function () {
    return view('Initial');
})->middleware(['auth', 'verified'])->name('Initial');

Route::get('/operational', function () {
    return view('operational');
})->middleware(['auth', 'verified'])->name('operational');


//under initial folder routes -------------------------------------------------
Route::get('/waterrefilling', function () {
    return view('/initial/initial_wrs');
})->middleware(['auth', 'verified'])->name('waterrefilling');

Route::get('/cemetery', function () {
    return view('/initial/initial_cemetery');
})->middleware(['auth', 'verified'])->name('cemetery');

Route::get('/funeral', function () {
    return view('/initial/initial_funeral');
})->middleware(['auth', 'verified'])->name('funeral');

//-----------------------------------------------------------------------------


require __DIR__.'/auth.php';
