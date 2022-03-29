<?php

Route::get('/', 'App\controllers\HomeController@index')->name('home.index');
Route::get('/home/show/{id}', 'App\controllers\HomeController@show')->name('home.show');
Route::get('/home/delete/{id}', 'App\controllers\HomeController@delete')->name('home.delete');
Route::post('/home/create', 'App\controllers\HomeController@create')->name('home.create');
Route::post('/home/cmtcreate', 'App\controllers\HomeController@cmtcreate')->name('home.cmtcreate');
