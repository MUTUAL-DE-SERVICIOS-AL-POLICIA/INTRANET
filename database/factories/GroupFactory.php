<?php

use Faker\Generator as Faker;

$factory->define(App\Group::class, function (Faker $faker) {
  $faker->addProvider(new \Faker\Provider\Lorem($faker));
  $faker->addProvider(new \Faker\Provider\Color($faker));

  return [
    'shortened' => $faker->word(),
    'name' => $faker->sentence(),
    'color' => $faker->hexcolor(),
  ];
});
