<?php

use Faker\Generator as Faker;
use bheller\ImagesGenerator\ImagesGeneratorProvider;

$factory->define(App\Icon::class, function (Faker $faker) {
  $faker->addProvider(new \Faker\Provider\Lorem($faker));
  $faker->addProvider(new ImagesGeneratorProvider($faker));
  $faker->addProvider(new \Faker\Provider\Color($faker));

  $formats = ['jpg', 'jpeg', 'png'];
  $format = $formats[array_rand($formats)];

  $path = $faker->imageGenerator(null, 160, 120, $format, true, $faker->word(), $faker->hexColor(), $faker->hexColor());
  $type = pathinfo($path, PATHINFO_EXTENSION);
  $data = file_get_contents($path);
  $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

  return [
    'name' => $faker->unique()->word(),
    'content' => $base64
  ];
});
