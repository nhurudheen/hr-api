<?php

use App\Http\Controllers\api\v1\GeneralController;

Route::controller(GeneralController::class)->group(function () {
    Route::get('ping', 'index');
    Route::post('status-quote', 'statusQuote');
});
