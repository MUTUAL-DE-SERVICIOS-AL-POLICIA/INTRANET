<?php

use Faker\Generator as Faker;

$factory->define(App\Group::class, function (Faker $faker) {
  $faker->addProvider(new \Faker\Provider\Lorem($faker));

  return [
    'shortened' => $faker->word(),
    'name' => $faker->sentence()
  ];
});
