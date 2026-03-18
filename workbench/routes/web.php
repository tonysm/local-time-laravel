<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/demo');
Route::view('/demo', 'demo')->name('demo');
