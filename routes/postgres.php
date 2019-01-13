<?php

Route::post('postgres/all', 'PostgresController@all');
Route::post('postgres/databases', 'PostgresController@databases');
Route::post('postgres/schemas', 'PostgresController@schemas');
Route::post('postgres/tables', 'PostgresController@tables');
Route::post('postgres/select', 'PostgresController@select');
Route::post('postgres/table/search', 'PostgresController@tableSearch');
Route::post('postgres/table/update', 'PostgresController@tableUpdate');
