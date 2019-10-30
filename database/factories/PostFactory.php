<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'content' => $faker->paragraphs(rand(5, 10), true),
        'views' => $faker->numberBetween(1,5000),
        'date' => date($format = 'd/m/y', $max = '29/10/19'),
        'category_id' => array_rand([2,3,4,5,6,7]),
        'user_id' => array_rand([1,7,9,11,13,14]),
        'status' => 0,
        'is_featured' => 0,
    ];
});