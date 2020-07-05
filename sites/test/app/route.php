<?php

Route::get('/', "TestController@index");
Route::get('/data/', "TestController@data");
Route::post('/insert/', "TestController@insert");
Route::post('/update/', "TestController@update");


Route::get('/auth/', "AuthController@index");
Route::post('/login/', "AuthController@login");
Route::get('/logout/', "AuthController@logout");
