<?php

use Faker\Generator as Faker;

$factory->define(App\Service::class, function (Faker $faker) {
  $faker->addProvider(new \Faker\Provider\Lorem($faker));
  $faker->addProvider(new \Faker\Provider\Internet($faker));
  $faker->addProvider(new \Faker\Provider\en_US\Company($faker));

  $icons = App\Icon::get()->all();
  $groups = App\Group::get()->all();

  return [
    'shortened' => $faker->unique()->word(),
    'name' => $faker->company,
    'href' => $faker->unique()->url(),
    'href_manual' => $faker->url(),
    'href_test' => $faker->url(),
    'icon_id' => $icons[array_rand($icons)]->id,
    'group_id' => $groups[array_rand($groups)]->id,
    'description' => $faker->sentence(),
  ];
});
