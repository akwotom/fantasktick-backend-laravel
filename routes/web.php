<?php

use App\Http\Controllers\TaskApi;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\API;
use App\Http\Middleware\Validation;

Route::get('/', function () {
    return ('welcome');
});



Route::group(array('middleware' => [API::class]), function () {
    Route::get('/list', [TaskApi::class, 'list']);

    Route::group(array(
        'middleware' => [Validation::class]
    ), function () {

        Route::post("/create", [TaskApi::class, 'create']);
        Route::post("/update", [TaskApi::class, 'update']);
    });
});

// Route::group(['middleware' => 'api'], function () {


// });
