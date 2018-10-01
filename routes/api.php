<?php

Route::group([
	'middleware' => 'api',
	'prefix' => 'v1',
], function () {
	// Login
	Route::post('auth', 'Api\V1\AuthController@store')->name('login');
	Route::group([
		'middleware' => 'jwt.auth'
	], function () {
		// Logout and refresh token
		Route::get('auth', 'Api\V1\AuthController@show')->name('profile');
		Route::delete('auth', 'Api\V1\AuthController@destroy')->name('logout');
		Route::patch('auth', 'Api\V1\AuthController@update')->name('refresh');
	});
});