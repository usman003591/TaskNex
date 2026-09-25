<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/signup', [AuthController::class, 'signup'])->name('signup');

Route::livewire('/', 'pages::dashboard')->name('dashboard');
Route::livewire('/starred', 'pages::starred')->name('starred');
Route::livewire('/collection/{collection}', 'pages::tasks.index')->name('tasks.index');
Route::livewire('/collection/{collection}/task/{task}', 'pages::tasks.details')->name('tasks.details');
