<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::dashboard')->name('dashboard');
Route::livewire('/starred', 'pages::starred')->name('starred');
Route::livewire('/list/{list}', 'pages::tasks.index')->name('tasks.index');

