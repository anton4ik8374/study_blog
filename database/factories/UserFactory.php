<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\User;
use App\Models\Post;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

/*$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});*/

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'content' => $faker->sentence,
        'views' => $faker->numberBetween(1,5000),
        'date' => date($format = 'd/m/y', $max = '29/10/19'),
        'category_id' => array_rand([2,3,4,5,6,7]),
        'tags' => [array_rand([7,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26]),array_rand([7,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26]),array_rand([7,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26])],
        'user_id' => array_rand([1,7,9,11,13,14]),
        'status' => 0,
        'is_featured' => 0,
    ];
});