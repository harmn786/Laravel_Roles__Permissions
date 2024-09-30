<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolesConrtoller;
use App\Http\Controllers\UserController;
use App\Models\Article;
use Illuminate\Support\Facades\Route;

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

Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
Route::get('/permissions/show', [PermissionController::class, 'index'])->name('permissions.show');
Route::post('/permissions/store', [PermissionController::class, 'store'])->name('permissions.store');
Route::get('/permissions/{id}/edit/', [PermissionController::class, 'edit'])->name('permissions.edit');
Route::post('/permissions/{id}/update', [PermissionController::class, 'update'])->name('permissions.update');
Route::delete('/permissions/delete', [PermissionController::class,'destroy'])->name('permissions.delete');


Route::get('/roles/create', [RolesConrtoller::class, 'create'])->name('roles.create');
Route::get('/roles/show', [RolesConrtoller::class, 'index'])->name('roles.show');
Route::post('/roles/store', [RolesConrtoller::class, 'store'])->name('roles.store');
Route::get('/roles/{id}/edit/', [RolesConrtoller::class, 'edit'])->name('roles.edit');
Route::post('/roles/{id}/update', [RolesConrtoller::class, 'update'])->name('roles.update');
Route::delete('/roles/delete', [RolesConrtoller::class,'destroy'])->name('roles.delete');


Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
Route::get('/articles/show', [ArticleController::class, 'index'])->name('articles.show');
Route::post('/articles/store', [ArticleController::class, 'store'])->name('articles.store');
Route::get('/articles/{id}/edit/', [ArticleController::class, 'edit'])->name('articles.edit');
Route::post('/articles/{id}/update', [ArticleController::class, 'update'])->name('articles.update');
Route::delete('/articles/delete', [ArticleController::class,'destroy'])->name('articles.delete');


Route::get('/users/show', [UserController::class, 'index'])->name('users.show');
Route::get('/users/create/', [UserController::class, 'create'])->name('users.create');
Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{id}/edit/', [UserController::class, 'edit'])->name('users.edit');
Route::post('/users/{id}/update', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/delete', [UserController::class, 'destroy'])->name('users.delete');
require __DIR__.'/auth.php';
