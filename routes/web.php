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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/permissions', [App\Http\Controllers\PermissionsController::class, 'index'])->name('permissions');

Route::get('/permission/add', [App\Http\Controllers\PermissionsController::class, 'create'])->name('permission.add');
Route::post('/permission/store', [App\Http\Controllers\PermissionsController::class, 'store'])->name('permission.store');
Route::get('/permission/edit/{param}', [App\Http\Controllers\PermissionsController::class, 'edit'])->name('permission.edit');
Route::post('/permission/update/{param}', [App\Http\Controllers\PermissionsController::class, 'update'])->name('permission.update');
Route::post('/permission/delete/{id}', [App\Http\Controllers\PermissionsController::class, 'destroy'])->name('permission.destroy');