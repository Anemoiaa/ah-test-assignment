<?php

require_once __DIR__ . '/../bootstrap/app.php';

use Faker\Factory as Faker;

$faker = Faker::create();
$postRepo = new Anemoiaa\AhTestAssignment\repositories\PostRepository();
$categoryRepo = new Anemoiaa\AhTestAssignment\repositories\CategoryRepository();

$categoryIds = [];

for($i = 0; $i < 8; $i++) {
    $categoryIds[] = $categoryRepo->create([
        'name' => ucfirst($faker->unique()->word),
        'description' => $faker->sentence(50),
    ])['id'];
}

for($i = 0; $i < 500; $i++) {
    $timestamp = $faker->dateTimeThisYear()->format('Y-m-d H:i:s');

    $post = $postRepo->create([
        'title'       => ucfirst($faker->words(3, true)),
        'description' => $faker->text(255),
        'text'        => $faker->text(5000),
        'image'       => 'https://placehold.co/600x400',
        'views'       => $faker->numberBetween(0, 1000),
        'created_at'  => $timestamp,
        'updated_at'  => $timestamp
    ]);

    $postRepo->attachCategories($post['id'], $faker->randomElements($categoryIds, rand(1, 3)));
}