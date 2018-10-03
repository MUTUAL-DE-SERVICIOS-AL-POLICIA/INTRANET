<?php

Route::group([
	'middleware' => 'api',
	'prefix' => 'v1',
], function () {
	// Login
	Route::get('group', 'Api\V1\GroupController@index')->name('group_list');
	Route::post('auth', 'Api\V1\AuthController@store')->name('login');
	Route::group([
		'middleware' => 'jwt.auth'
	], function () {
		// Logout and refresh token
		Route::get('auth', 'Api\V1\AuthController@show')->name('profile');
		Route::delete('auth', 'Api\V1\AuthController@destroy')->name('logout');
		Route::patch('auth', 'Api\V1\AuthController@update')->name('refresh');
		Route::resource('icon', 'Api\V1\IconController');
		Route::resource('service', 'Api\V1\ServiceController');
		Route::post('group', 'Api\V1\GroupController@store')->name('group_store');
		Route::get('group/{id}', 'Api\V1\GroupController@show')->name('group_details');
		Route::patch('group/{id}', 'Api\V1\GroupController@update')->name('group_update');
		Route::delete('group/{id}', 'Api\V1\GroupController@destroy')->name('group_destroy');
	});
});
