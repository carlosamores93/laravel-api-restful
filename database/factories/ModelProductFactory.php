<?php

use Faker\Generator as Faker;

$factory->define(App\Model\Product::class, function (Faker $faker) {
	$name =  $faker->word;
    return [
    	'name' => $name,
    	'slug' => str_slug($name),
    	'detail' => $faker->paragraph,
    	'price' => $faker->numberBetween(100, 1000),
    	'stock' => $faker->randomDigit,
    	'discount' => $faker->numberBetween(5, 40)
    ];
});
