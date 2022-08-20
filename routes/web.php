<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'dashboard');

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * App Routes
 */

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', \App\Http\Livewire\Dashboard::class)->name('dashboard');
    Route::get('/profile', \App\Http\Livewire\Profile::class)->name('profile');

    Route::get('/logout', function () {
        Auth::logout();
        return redirect()->route('auth.login');
    });
});

/**
 * Authentication
 */

Route::middleware('guest')->group(function () {
    Route::get('/login', \App\Http\Livewire\Auth\Login::class)->name('auth.login');
});
