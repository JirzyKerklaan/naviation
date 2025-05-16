<?php
use App\Http\Controllers\OverviewController;

Route::get('/', [OverviewController::class, 'index'])->name('home');
