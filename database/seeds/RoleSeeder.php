<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$types = [			
			['name' => 'secretaria', 'display_name' => 'Secretaria', 'description' => 'Rol de secretaria']
		];

		foreach ($types as $type) {
			App\Role::create($type);
		}
    }
}
