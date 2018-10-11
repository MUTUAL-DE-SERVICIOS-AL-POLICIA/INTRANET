<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserForm;
use Ldap;

/** @resource User
 *
 * Resource to retrieve, show, update and destroy User data
 */

class UserController extends Controller
{
	/**
	 * Update the specified user in storage.
	 *
	 * @param  \Illuminate\Http\UserForm  $request
	 * @return \Illuminate\Http\Response
	 */
	public function update(UserForm $request)
	{
		$ldap = new Ldap();

		if ($ldap->connection) {
			if ($ldap->bind($request['username'], $request['old_password'])) {
				if ($ldap->update_password($request['username'], $request['new_password'])) {
					return response()->json([
						'user' => $request['username'],
						'message' => 'Contraseña actualizada con éxito'
					]);
				}
			} else {
				return response()->json([
					'message' => 'Unauthorized',
					'errors' => [
						'type' => ['Contraseña incorrecta'],
					]
				], 401);
			}
		}

		return response()->json([
			'message' => 'Internal server error',
			'errors' => [
				'type' => ['Error en la conexión con el servidor'],
			]
		], 500);
	}
}
