<?php

use Illuminate\Support\Facades\Route;

/**
 * prefix: data
 * namespace: Data
 */

Route::prefix('accounts')->namespace('Accounts')->group(function () {
    Route::get('/user/{user?}', 'UserController@index');
    Route::prefix('updates')->namespace('Updates')->group(function () {
        Route::match(['put', 'patch'], '/user/{user}', 'UpdatedEmailController@update');
        Route::match(['put', 'patch'], '/name/{user}', 'NameUpdatesController@update');
    });
});

Route::prefix('users')->namespace('Users')->group(function () {

    Route::prefix('logs')->namespace('Logs')->group(function () {
        Route::get('/{user}', 'UserLogsController@index');
    });

    Route::prefix('updated')->namespace('Updated')->group(function () {
        Route::match(['put', 'patch'], '/password/{user}', 'UpdatedUserPasswordController@update');
        Route::post('/send-reset-link/{user}', 'UpdatedUserPasswordController@sendResetLink');
    });

    Route::get('/', 'UsersController@index');
    Route::post('/', 'UsersController@store');
    Route::match(['put', 'patch'], '/{user}', 'UsersController@update');
    Route::delete('/{user}', 'UsersController@destroy');
});
