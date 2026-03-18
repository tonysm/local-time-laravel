<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/welcome');
Route::view('/welcome', 'welcome')->name('welcome');
