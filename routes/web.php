<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    $number = 23;
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('files')->group(function () {
    Route::post('/store', [App\Http\Controllers\FileController::class, 'store'])->name('user.files.store');
    Route::get('/list', [App\Http\Controllers\FileController::class, 'index'])->name('files.list');
    Route::get('/list/{file}', [App\Http\Controllers\FileController::class, 'displayImages'])->name('files.displayImage');
});
