<?php

/**
 * prefix: data
 * namespace: Data
 */

 Route::prefix('users')->namespace('Users')->group(function() {
    Route::get('/', 'UsersController@index');
    Route::post('/', 'UsersController@store');
 });