<?php

use Illuminate\Support\Facades\Route;

Route::prefix('movies')->middleware('api.key')->group(function () {
    Route::get('/', 'MoviesController@list');

    Route::get('/{id}', 'MoviesController@showDetails');
});
