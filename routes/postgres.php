<?php

Route::post('postgres/all', 'PostgresController@all');
Route::post('postgres/databases', 'PostgresController@databases');
Route::post('postgres/schemas', 'PostgresController@schemas');
Route::post('postgres/tables', 'PostgresController@tables');
Route::post('postgres/select', 'PostgresController@select');
