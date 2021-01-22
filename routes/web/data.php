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

    Route::prefix('updated')->namespace('Updated')->group(function() {
        Route::match(['put', 'patch'], '/password/{user}', 'UpdatedUserPasswordController@update');
        Route::post('/send-reset-link/{user}', 'UpdatedUserPasswordController@sendResetLink');
    });

    Route::get('/', 'UsersController@index');
    Route::post('/', 'UsersController@store');
    Route::match(['put', 'patch'], '/{user}', 'UsersController@update');
    Route::delete('/{user}', 'UsersController@destroy');
});