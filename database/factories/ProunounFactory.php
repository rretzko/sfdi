<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Pronoun;
use Faker\Generator as Faker;


factory(Pronoun::class, 9)->create();

$factory->define(Pronoun::class, function (Faker $faker) {
    return [
            'descr' => 'he/him/his/himself',
            'intensive' => 'himself',
            'personal' => 'he',
            'possessive' => 'his',
            'object' => 'him',
            'order_by' => 2
    ];
});
