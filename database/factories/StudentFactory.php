<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\Student;
use Faker\Generator as Faker;

$factory->define(Student::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'lecturer_id' => 12,
        'email' => $faker->unique()->safeEmail,
        'password'=>\Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(8)),
        'created_at' => new DateTime,
        'updated_at' => new DateTime,
    ];
});
