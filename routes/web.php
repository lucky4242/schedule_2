<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScheduledSmsController;

Route::get('/', function () {
    return view('welcome');
});
