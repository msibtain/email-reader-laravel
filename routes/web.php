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

Auth::routes(['register' => false]);

Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/blacklists', [App\Http\Controllers\BlacklistLinksController::class, 'index'])->name('index');
    Route::get('/blacklists/add', [App\Http\Controllers\BlacklistLinksController::class, 'add'])->name('add');
    Route::post('/blacklists/add', [App\Http\Controllers\BlacklistLinksController::class, 'submit'])->name('submit');
    Route::get('/blacklists/edit/{id}', [App\Http\Controllers\BlacklistLinksController::class, 'edit'])->name('edit');
    Route::post('/blacklists/edit/{id}', [App\Http\Controllers\BlacklistLinksController::class, 'update'])->name('update');
    Route::get('/blacklists/delete/{id}', [App\Http\Controllers\BlacklistLinksController::class, 'delete'])->name('delete');

    Route::get('/links', [App\Http\Controllers\EmailsController::class, 'list'])->name('list');
    Route::post('/get-links-list', [App\Http\Controllers\EmailsController::class, 'get_links_list'])->name('get_links_list');
    Route::get('/links/detail/{id}', [App\Http\Controllers\EmailsController::class, 'link_detail'])->name('link_detail');
    Route::post('/links/detail/{id}', [App\Http\Controllers\EmailsController::class, 'link_detail_table'])->name('link_detail_table');
    
    
});

Route::get('/reademails', [App\Http\Controllers\EmailsController::class, 'read'])->name('read');