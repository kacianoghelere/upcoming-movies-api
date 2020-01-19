<?php

use Illuminate\Support\Facades\Route;

Route::prefix('upcoming-movies')->group(function () {
    Route::get('/', 'UpcomingMoviesController@index');

    Route::get('/{id}', 'UpcomingMoviesController@show');
});
