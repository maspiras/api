<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Host\HostController;
use App\Http\Controllers\Reservation\ReservationController;

Route::get('/', function () {
    return response()->json([
        'message' => 'Access Denied!',
    ]);
});

/* Route::group(['prefix' => 'reservations'], function () {
    Route::prefix('/{host_id}')->group(function () {
        //Route::get('/', [ReservationController::class, 'index']);
        Route::get('/', [HostController::class, 'index']);
        Route::prefix('/{reservation_id}')->group(function () {
            Route::post('/', [ReservationController::class, 'store']);
            Route::get('/', [ReservationController::class, 'show']);
            Route::put('/', [ReservationController::class, 'update']);
            Route::patch('/', [ReservationController::class, 'update']);
            Route::delete('/', [ReservationController::class, 'delete']);
            Route::resource('/', ReservationController::class);
        });
    });
}); */

/* Route::group(['prefix' => 'reservations'], function () {
    Route::resource('/', ReservationController::class);
}); */
Route::resource('/reservations', ReservationController::class);
