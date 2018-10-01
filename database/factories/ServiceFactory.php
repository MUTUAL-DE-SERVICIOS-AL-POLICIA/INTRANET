<?php

use Faker\Generator as Faker;

$factory->define(App\Service::class, function (Faker $faker) {
  $faker->addProvider(new \Faker\Provider\Lorem($faker));
  $faker->addProvider(new \Faker\Provider\Internet($faker));
  $faker->addProvider(new \Faker\Provider\en_US\Company($faker));

  $icons = App\Icon::get()->all();
  $groups = App\Group::get()->all();

  return [
    'shortened' => $faker->word(),
    'name' => $faker->unique()->company,
    'href' => $faker->url(),
    'icon_id' => $icons[array_rand($icons)]->id,
    'group_id' => $groups[array_rand($groups)]->id,
    'description' => $faker->sentence(),
  ];
});
