<?php

use App\Http\Controllers\api\v1\RorkebController;

Route::controller(RorkebController::class)->group(function () {
    Route::get('xyz', 'home');
});
