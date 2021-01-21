<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Models\UserLog;
use Faker\Generator as Faker;

$factory->define(UserLog::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'slug' => 'Tested_user',
        'message' => $faker->sentence(12)
    ];
});
