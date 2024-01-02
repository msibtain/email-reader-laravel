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

Route::get('/domains', [App\Http\Controllers\DomainsController::class, 'index'])->name('index');

Route::get('/rules', [App\Http\Controllers\RulesController::class, 'index'])->name('index');
Route::get('/rules/add', [App\Http\Controllers\RulesController::class, 'add'])->name('add');
Route::post('/rules/add', [App\Http\Controllers\RulesController::class, 'submit'])->name('submit');
Route::get('/rules/edit/{id}', [App\Http\Controllers\RulesController::class, 'edit'])->name('edit');
Route::post('/rules/edit/{id}', [App\Http\Controllers\RulesController::class, 'update'])->name('update');
Route::get('/rules/delete/{id}', [App\Http\Controllers\RulesController::class, 'delete'])->name('delete');