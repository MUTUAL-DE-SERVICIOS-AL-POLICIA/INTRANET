<?php

use Illuminate\Database\Seeder;

class IconSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    factory(App\Icon::class, 10)->create();
  }
}
