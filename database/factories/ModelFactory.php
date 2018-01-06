<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Product::class, function (Faker\Generator $faker) {
	$name = $faker->sentence(3);
	$products = [
					0 => '/images/products/1.png',
					1 => '/images/products/2.png'
				];

	$optional = [
					'width' => rand(1,10),
					'height' => rand(1,10),
					'weight' => rand(1,10)
				];
    return [
		'name' => $name,
		'slug' => str_slug($name),
		'description' => $faker->paragraph(3),
		'optional' => json_encode($optional),
		'images' => json_encode($products),
		'price' => $faker->randomNumber(5),
		'is_discount' => $faker->boolean(2),
		'discount' => $faker->randomNumber(1),
		'category_id' => $faker->randomNumber(1),
		'brand_id' => $faker->randomNumber(1),
		'is_homepage' => $faker->boolean(2),
		'user_id' => 1,
		'active' => TRUE,
		'stock' => 10,
    ];
});

$factory->define(App\Models\Category::class, function (Faker\Generator $faker) {
	$name = $faker->company;
	$products = [
					0 => '/images/products/product01.jpg',
					1 => '/images/products/product02.jpg',
					2 => '/images/products/product03.jpg'
				];

	$optional = [
					'width' => rand(1,10),
					'height' => rand(1,10),
					'weight' => rand(1,10)
				];
    return [
		'name' => $name,
		'slug' => str_slug($name),
		'description' => $faker->paragraph(3),
		'optional' => json_encode($optional),
		'images' => json_encode($products),
		'parrent_id' => rand(0,4),
		'user_id' => 1,
		'active' => TRUE,
    ];
});

