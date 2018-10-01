<?php

use Faker\Generator as Faker;
use bheller\ImagesGenerator\ImagesGeneratorProvider;

$factory->define(App\Icon::class, function (Faker $faker) {
  $faker->addProvider(new \Faker\Provider\Lorem($faker));
  $faker->addProvider(new ImagesGeneratorProvider($faker));

  $formats = ['jpg', 'jpeg', 'png'];

  return [
    'name' => $faker->word(),
    'content' => base64_encode($faker->imageGenerator(null, 640, 480, $formats[array_rand($formats)])),
    'format' => $formats[array_rand($formats)]
  ];
});
