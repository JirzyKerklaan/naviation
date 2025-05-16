<?php
use App\Http\Controllers\OverviewController;

Route::get('/', [OverviewController::class, 'index'])->name('home');

Route::get('/{flightnumber}', [OverviewController::class, 'viewFlight'])->name('flight.show');