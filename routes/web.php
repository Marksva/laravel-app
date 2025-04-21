<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PokemonController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->name('home');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('welcome');
})->middleware('auth');

Route::middleware('auth')->post('/capture-random', [PokemonController::class, 'capturarAleatorio'])->name('pokemon.capturar');

route::get('/pokemon', function () {
    return view('pokemon.index');
})->middleware('auth');

Route::resource('user', UserController::class)->middleware('auth');