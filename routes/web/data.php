<?php

use Illuminate\Support\Facades\Route;

/**
 * prefix: data
 * namespace: Data
 */

Route::prefix('users')->namespace('Users')->group(function() {

    Route::prefix('logs')->namespace('Logs')->group(function() {
        Route::get('/{user}', 'UserLogsController@index');
    });

    Route::get('/', 'UsersController@index');
    Route::post('/', 'UsersController@store');
    Route::match(['put', 'patch'], '/{user}', 'UsersController@update');
    Route::delete('/{user}', 'UsersController@destroy');
});