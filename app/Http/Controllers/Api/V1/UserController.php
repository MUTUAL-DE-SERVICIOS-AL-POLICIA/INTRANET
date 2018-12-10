<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserForm;
use App\User;
use Ldap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/** @resource User
 *
 * Resource to retrieve, show, update and destroy User data
 */

class UserController extends Controller
{
	/**
	 * Display User's data.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return User::where('active', true)->with('roles')->orderBy('username')->get();
	}

	/**
	 * Stores a user.
	 *
	 * @param  \App\Employee  $employee
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		
		if (!env("LDAP_AUTHENTICATION")) {
			abort(409);
		} else {
			$ldap = new Ldap();
			$user = new User();
			$entry = $ldap->get_entry(request("employee_id"));
			$username = $entry['uid'];

			if ($username) {
				$user->username = $username;
				$user->password = Hash::make($username);
				$user->save();
				return $user;
			}
			abort(409);
		}
	}

	/**
	 * Update the specified user in storage.
	 *
	 * @param  \Illuminate\Http\UserForm  $request
	 * @return \Illuminate\Http\Response
	 */
	public function update(UserForm $request)
	{
		$ldap = new Ldap();

		if ($ldap->connection && $ldap->verify_open_port()) {
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
						'type' => ['Usuario o contraseña incorrecta'],
					]
				], 403);
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
