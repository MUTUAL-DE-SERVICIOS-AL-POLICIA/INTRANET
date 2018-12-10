<?php

use Illuminate\Database\Seeder;

class NoticeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$types = [
			['id' => 1, 'name' => 'Comunicado', 'shortened' => 'COM', 'description' => 'Comunicados'],
            ['id' => 2, 'name' => 'Instrictivo', 'shortened' => 'INS', 'description' => 'Instrictivos'],
            ['id' => 3, 'name' => 'Circular', 'shortened' => 'CIR', 'description' => 'Circulares']
		];

		foreach ($types as $type) {
			App\NoticeType::create($type);
		}
    }
}
