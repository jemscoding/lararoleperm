<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PermissionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth'])->group(function () {

    Route::resource('posts', PostController::class)->names('posts');
    // Roles Routes
    Route::resource('roles', RoleController::class)->names('roles');
    // Permissions Routes
    Route::resource('permissions', PermissionController::class)->names('permissions');
});

require __DIR__.'/auth.php';

Route::resource('/categories', CategoryController::class)->names('categories');
Route::resource('/tags', TagController::class)->names('tags');
Route::resource('/users', UserController::class)->names('users');

//route with authentication with a specific role admin, super_admin and editor can access using middleware
Route::group(['middleware' => ['auth', 'role:admin|super_admin|editor'], 'prefix' => 'admin'], function () {
    Route::resource('posts', PostController::class)->names('posts');
    Route::resource('roles', RoleController::class)->names('roles');
    Route::resource('permissions', PermissionController::class)->names('permissions');
});

Route::group(['middleware' =>['auth','role:author|user']], function ()
{
    // Route::resource('posts', PostController::class)->names('posts');
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index')->middleware('role:user|author');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create')->middleware('role:user|author');
    Route::get('/posts/edit', [PostController::class, 'edit'])->name('posts.edit')->middleware('role:user|author');
    Route::get('/posts/delete', [PostController::class, 'delete'])->name('posts.delete')->middleware('role:user|author');
    Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('posts.show')->middleware('role:user|author');
    Route::get('/posts/edit/{post:slug}', [PostController::class, 'edit'])->name('posts.edit')->middleware('role:user|author');
});

