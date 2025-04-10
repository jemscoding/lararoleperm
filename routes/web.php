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

// //route with authentication with a specific role admin, super_admin and editor can access using middleware
// Route::group(['middleware' => ['auth', 'role:admin|super_admin|editor|user|manager|author']], function () {
//     Route::resource('posts', PostController::class)->names('posts');
//     Route::resource('roles', RoleController::class)->names('roles');
//     Route::resource('permissions', PermissionController::class)->names('permissions');
//     Route::resource('tags', TagController::class)->names('tags');
// });

// //route for user,author
// Route::group(['middleware' =>['auth','role:author|user|admin']], function ()
// {
//     // Route::resource('posts', PostController::class)->names('posts');
//     Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
//     Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
//     Route::get('/posts/edit', [PostController::class, 'edit'])->name('posts.edit');
//     Route::get('/posts/delete', [PostController::class, 'delete'])->name('posts.delete');
//     Route::get('/posts/show/{post:slug}', [PostController::class, 'show'])->name('posts.show');
//     Route::get('/posts/edit/{post:slug}', [PostController::class, 'edit'])->name('posts.edit');
// });

// Route with authentication for admin roles
Route::group(['middleware' => ['auth', 'role:admin|super_admin|editor|manager|author|user']], function () {
    Route::resource('posts', PostController::class)->names('posts')->parameters(['posts' => 'post:slug']); // Use a different name prefix to avoid conflicts
    Route::resource('roles', RoleController::class)->names('roles');
    Route::resource('permissions', PermissionController::class)->names('permissions');
    Route::resource('categories', CategoryController::class)->names('categories');
    Route::resource('tags', TagController::class)->names('tags');
    Route::resource('users', UserController::class)->names('users');
});

// // Route for users and authors to view posts
// Route::group(['middleware' => ['auth', 'role:author|user']], function () {
//     // Route::resource('posts', PostController::class)->names('posts')->only(['index', 'show']); // Only allow index and show for regular users
//     // You can add other specific routes for creating, editing, etc., if authors/users are allowed
//     Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
//     Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
//     Route::get('/posts/edit/{post:slug}', [PostController::class, 'edit'])->name('posts.edit');
//     Route::get('/posts/show/{post:slug}', [PostController::class, 'show'])->name('posts.show');
//     Route::put('/posts/{post:slug}', [PostController::class, 'update'])->name('posts.update');
//     Route::delete('/posts/{post:slug}', [PostController::class, 'destroy'])->name('posts.destroy');
// });

