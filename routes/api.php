<?php

use Illuminate\Support\Facades\Route;

Route::prefix('movies')->group(function () {
    Route::get('/', 'MoviesController@list');

    Route::get('/{id}', 'MoviesController@showDetails');
});
