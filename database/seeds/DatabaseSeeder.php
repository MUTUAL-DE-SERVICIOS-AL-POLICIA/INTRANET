<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->command->info('Unguarding models');
		Model::unguard();

		$tables = [
			'permission_role',
			'permission_user',
			'permissions',
			'role_user',
			'roles',
			'users',
			'user_actions',
			'icons',
		];

		$this->command->info('Truncating existing tables');
		foreach ($tables as $table) {
			DB::statement('TRUNCATE TABLE ' . $table . ' CASCADE;');
		}

		$this->call(UserSeeder::class);
		$this->call(UserActionSeeder::class);
		$this->call(IconSeeder::class);
	}
}
