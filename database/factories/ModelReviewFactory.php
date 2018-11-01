<?php

use Faker\Generator as Faker;
use App\Model\Product;

$factory->define(App\Model\Review::class, function (Faker $faker) {
	$name = $faker->name;
    return [
    	'product_id' => function(){
    		return Product::all()->random();
    	},
    	'customer' => $name,
    	'slug' => str_slug($name),
    	'review' => $faker->paragraph,
    	'star' => $faker->numberBetween(0, 10)
    ];
});
