<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\Lecturer;
use Faker\Generator as Faker;

$factory->define(Lecturer::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'password' => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(8)),
        'name' => $faker->name,
        'subject_id' => \App\Entities\Subject::all()->random()->id,
        'status' => 1,
        'created_at' => new DateTime,
        'updated_at' => new DateTime,
    ];
});
