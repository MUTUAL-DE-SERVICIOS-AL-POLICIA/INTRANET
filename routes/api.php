<?php

Route::group([
	'middleware' => 'api',
	'prefix' => 'v1',
], function () {
	Route::patch('user', 'Api\V1\UserController@update')->name('user_update');
	Route::get('icon', 'Api\V1\IconController@index')->name('icon_list');
	Route::get('group', 'Api\V1\GroupController@index')->name('group_list');
	Route::get('service', 'Api\V1\ServiceController@index')->name('service_list');
	Route::get('icon/{id}', 'Api\V1\IconController@show')->name('icon_details');
	Route::get('group/{id}', 'Api\V1\GroupController@show')->name('group_details');
	Route::get('service/{id}', 'Api\V1\ServiceController@show')->name('service_details');
	// Login
	Route::post('auth', 'Api\V1\AuthController@store')->name('login');
	Route::group([
		'middleware' => 'jwt.auth'
	], function () {
		// Logout and refresh token
		Route::get('auth', 'Api\V1\AuthController@show')->name('profile');
		Route::patch('auth', 'Api\V1\AuthController@update')->name('refresh');
		Route::delete('auth', 'Api\V1\AuthController@destroy')->name('logout');
		Route::post('icon', 'Api\V1\IconController@store')->name('icon_store');
		Route::patch('icon/{id}', 'Api\V1\IconController@update')->name('icon_update');
		Route::delete('icon/{id}', 'Api\V1\IconController@destroy')->name('icon_destroy');
		Route::post('service', 'Api\V1\ServiceController@store')->name('service_store');
		Route::patch('service/{id}', 'Api\V1\ServiceController@update')->name('service_update');
		Route::delete('service/{id}', 'Api\V1\ServiceController@destroy')->name('service_destroy');
		Route::post('group', 'Api\V1\GroupController@store')->name('group_store');
		Route::patch('group/{id}', 'Api\V1\GroupController@update')->name('group_update');
		Route::delete('group/{id}', 'Api\V1\GroupController@destroy')->name('group_destroy');
	});
});
