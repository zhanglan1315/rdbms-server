<?php

Route::get('test', 'TestController@test');
Route::post('auth/login', 'AuthController@login');
Route::post('users', 'UserController@create');
