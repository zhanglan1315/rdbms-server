<?php

// todo: logout -> auth/logout
Route::post('logout', 'AuthController@logout');

Route::post('users', 'UserController@create');
Route::post('auth/check', 'AuthController@test');
Route::post('auth/refresh', 'AuthController@refresh');

Route::get('users', 'UserController@search');
Route::delete('users/{user}', 'UserController@delete');

Route::get('connections', 'ConnectionController@all');
Route::post('connections', 'ConnectionController@create');
Route::put('connections/{id}', 'ConnectionController@update');
Route::delete('connections/{id}', 'ConnectionController@destroy');
Route::post('connections/test', 'ConnectionController@test');

Route::post('postgres/test', 'PostgresController@test');
