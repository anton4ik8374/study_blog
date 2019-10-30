<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'content' => $faker->paragraphs(rand(5, 10), true),
        'views' => $faker->numberBetween(1,5000),
        'date' => mt_rand(1,30) . '/' . mt_rand(1,12) . '/' . mt_rand(10 , 19),
        'category_id' => array_rand(array_flip([2,3,4,5,6,7])),
        'user_id' => array_rand(array_flip([1,7,9,11,13,14])),
        'status' => 0,
        'is_featured' => 0,
    ];
});