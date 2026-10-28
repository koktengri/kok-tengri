<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\InteractionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CommunityController::class, 'index'])->name('home');
Route::get('/posts/{post:slug}', [CommunityController::class, 'show'])->name('posts.show');

Route::middleware('guest')->group(function (): void {
    Route::get('/register', [AuthController::class, 'create'])->name('register');
    Route::post('/register', [AuthController::class, 'store'])->middleware('throttle:5,1');
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:8,1');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function (): void {
    Route::get('/posts/create', [CommunityController::class, 'create'])->name('posts.create');
    Route::post('/posts', [CommunityController::class, 'store'])->middleware('throttle:10,1')->name('posts.store');
    Route::post('/posts/{post}/comments', [InteractionController::class, 'comment'])->middleware('throttle:20,1')->name('comments.store');
    Route::post('/posts/{post}/reaction', [InteractionController::class, 'react'])->name('posts.react');
    Route::post('/posts/{post}/bookmark', [InteractionController::class, 'bookmark'])->name('posts.bookmark');
    Route::post('/posts/{post}/tags', [InteractionController::class, 'tag'])->name('posts.tags');
});

Route::middleware(['auth'])->prefix('admin/community')->name('community.admin.')->group(function (): void {
    Route::get('/members', [CommunityController::class, 'members'])->name('members');
    Route::patch('/members/{user}/role', [CommunityController::class, 'updateRole'])->name('members.role');
});
