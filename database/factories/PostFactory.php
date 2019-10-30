<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'content' => $faker->paragraphs(rand(5, 10), true),
        'views' => $faker->numberBetween(1,5000),
        'date' => rand(1,30) . '/' . rand(1,12) . '/' . rand(10 , 19),
        'category_id' => array_rand([2 => 2,3 => 3,4 => 4,5 => 5,6 => 6,7 => 7]),
        'user_id' => array_rand([1 => 1,7 => 7,9 => 9,11 => 11,13 => 13,14 => 14]),
        'status' => 0,
        'is_featured' => 0,
    ];
});