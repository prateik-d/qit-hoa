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

// Route::get('/states', [App\Http\Controllers\StatesController::class, 'index'])->name('states');
// Route::get('/state/add', [App\Http\Controllers\StatesController::class, 'create'])->name('state.add');
// Route::post('/state/store', [App\Http\Controllers\StatesController::class, 'store'])->name('state.store');
// Route::get('/state/edit/{param}', [App\Http\Controllers\StatesController::class, 'edit'])->name('state.edit');
// Route::post('/state/update/{param}', [App\Http\Controllers\StatesController::class, 'update'])->name('state.update');
// Route::post('/state/delete/{id}', [App\Http\Controllers\StatesController::class, 'destroy'])->name('state.destroy');

// Route::get('/cities', [App\Http\Controllers\CitiesController::class, 'index'])->name('cities');
// Route::get('/city/add', [App\Http\Controllers\CitiesController::class, 'create'])->name('city.add');
// Route::post('/city/store', [App\Http\Controllers\CitiesController::class, 'store'])->name('city.store');
// Route::get('/city/edit/{param}', [App\Http\Controllers\CitiesController::class, 'edit'])->name('city.edit');
// Route::post('/city/update/{param}', [App\Http\Controllers\CitiesController::class, 'update'])->name('city.update');
// Route::post('/city/delete/{id}', [App\Http\Controllers\CitiesController::class, 'destroy'])->name('city.destroy');

// Route::get('/roles', [App\Http\Controllers\RolesController::class, 'index'])->name('roles');
// Route::get('/role/add', [App\Http\Controllers\RolesController::class, 'create'])->name('role.add');
// Route::post('/role/store', [App\Http\Controllers\RolesController::class, 'store'])->name('role.store');
// Route::get('/role/edit/{param}', [App\Http\Controllers\RolesController::class, 'edit'])->name('role.edit');
// Route::post('/role/update/{param}', [App\Http\Controllers\RolesController::class, 'update'])->name('role.update');
// Route::post('/role/delete/{id}', [App\Http\Controllers\RolesController::class, 'destroy'])->name('role.destroy');

Route::get('/headings', [App\Http\Controllers\PermissionHeadingController::class, 'index'])->name('headings');
Route::get('/heading/add', [App\Http\Controllers\PermissionHeadingController::class, 'create'])->name('heading.add');
Route::post('/heading/store', [App\Http\Controllers\PermissionHeadingController::class, 'store'])->name('heading.store');
Route::get('/heading/edit/{param}', [App\Http\Controllers\PermissionHeadingController::class, 'edit'])->name('heading.edit');
Route::post('/heading/update/{param}', [App\Http\Controllers\PermissionHeadingController::class, 'update'])->name('heading.update');
Route::post('/heading/delete/{id}', [App\Http\Controllers\PermissionHeadingController::class, 'destroy'])->name('heading.destroy');


// Route::get('/users', [App\Http\Controllers\UsersController::class, 'index'])->name('users');
