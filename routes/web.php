<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ProductConfigurator;

Route::get('/', ProductConfigurator::class);

// Route::get('/', function () {
//     return view('welcome');
// });
