<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/blacklists', [App\Http\Controllers\BlacklistLinksController::class, 'index'])->name('index');
Route::get('/blacklists/add', [App\Http\Controllers\BlacklistLinksController::class, 'add'])->name('add');
Route::post('/blacklists/add', [App\Http\Controllers\BlacklistLinksController::class, 'submit'])->name('submit');
Route::get('/blacklists/edit/{id}', [App\Http\Controllers\BlacklistLinksController::class, 'edit'])->name('edit');
Route::post('/blacklists/edit/{id}', [App\Http\Controllers\BlacklistLinksController::class, 'update'])->name('update');
Route::get('/blacklists/delete/{id}', [App\Http\Controllers\BlacklistLinksController::class, 'delete'])->name('delete');

Route::get('/reademails', [App\Http\Controllers\EmailsController::class, 'read'])->name('read');