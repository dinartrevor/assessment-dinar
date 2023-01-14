<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\UserController;
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

Route::get('/', [LoginController::class, 'index'])->name("login")->middleware('guest');
Route::post('/', [LoginController::class, 'authenticate'])->name("authenticate");
Route::post('/logout', [LoginController::class, 'logout'])->name("logout");

Route::middleware(['auth'])->group(function () {
    Route::get('explore', [ExploreController::class, 'index'])->name("explore");
    Route::get('explore/{slug}', [ExploreController::class, 'show'])->name("explore.show");
    Route::group(['prefix'=>'user_management',], function(){
        Route::resource('user', UserController::class)->except(['create','edit', 'destroy']);
        Route::post('user/delete', [UserController::class, 'destroy'])->name('user.destroy');
        Route::resource('permission', PermissionController::class)->except(['create','edit', 'destroy']);
        Route::post('permission/delete', [PermissionController::class, 'destroy'])->name('permission.destroy');
        Route::resource('role', RoleController::class)->except(['create','edit', 'destroy']);
        Route::post('role/delete', [RoleController::class, 'destroy'])->name('role.destroy');
    });
    Route::group(['prefix'=>'master_data',], function(){
        Route::resource('category', CategoryController::class)->except(['create','edit', 'destroy']);
        Route::post('category/delete', [CategoryController::class, 'destroy'])->name('category.destroy');
        Route::resource('story', StoryController::class)->except(['create','edit', 'destroy']);
        Route::post('story/delete', [StoryController::class, 'destroy'])->name('story.destroy');
    });
});

