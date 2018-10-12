<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthForm;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/** @resource Authenticate
 *
 * Resource to authenticate via username/password credentials
 */

class AuthController extends Controller
{

	/**
	 * Get a JWT via given credentials.
	 *
	 * Login, return a JsonWebToken to request as "Bearer" Authorization header
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(AuthForm $request)
	{
		$token = auth('api')->attempt(request(['username', 'password']));

		if ($token) {
			return $this->respondWithToken($token);
		} else {
			return response()->json([
				'message' => 'No autorizado',
				'errors' => [
					'type' => ['Usuario o contraseña incorrectos'],
				],
			], 401);
		}
	}

	/**
	 * Get the authenticated User.
	 *
	 * Login, return a JsonWebToken to request as "Bearer" Authorization header
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show()
	{
		return response()->json(auth('api')->user());
	}

	/**
	 * Log the user out (Invalidate the token).
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy()
	{
		auth('api')->logout();
		return response()->json([
			'message' => 'Logged out successfully',
		], 201);
	}

	/**
	 * Refresh a token.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update()
	{
		return $this->respondWithToken(auth('api')->refresh());
	}

	/**
	 * Get the token array structure.
	 *
	 * @param  string $token
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function respondWithToken($token)
	{
		$this->guard()->user()->roles;

		return response()->json([
			'token' => $token,
			'token_type' => 'Bearer',
			'expires_in' => auth('api')->factory()->getTTL(),
			'user' => $this->guard()->user(),
			'message' => 'Indentidad verificada',
		], 200);
	}

	public function guard()
	{
		return Auth::Guard('api');
	}
}