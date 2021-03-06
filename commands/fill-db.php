<?php

use App\Connection;

require  dirname(__DIR__) . '/vendor/autoload.php';

$faker = Faker\Factory::create('fr_FR');

$pdo = Connection::getPDO();

// Ignorer la clé étrangère au début
$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
$pdo->exec('TRUNCATE TABLE post_category');
$pdo->exec('TRUNCATE TABLE post');
$pdo->exec('TRUNCATE TABLE category');
$pdo->exec('TRUNCATE TABLE user');
$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

$posts = [];
$categories = [];

//Remplir la base de données pour la table post avec des infos du faker
for($i = 0; $i < 50; $i++)
{
    $pdo->exec("INSERT INTO post SET name='{$faker->sentence(4)}', slug='{$faker->slug()}', created_at='{$faker->date()} {$faker->time()}', content='{$faker->paragraph(rand(3, 15), true)}'");
    $posts[] = $pdo->lastInsertId();
}

//Remplir la base de données avec des infos
for($i = 0; $i < 5; $i++)
{
    $pdo->exec("INSERT INTO category SET name='{$faker->sentence(3)}', slug='{$faker->slug()}'");
    $categories[] = $pdo->lastInsertId();
}

foreach($posts as $post) {
    $randomCategories = $faker->randomElements($categories, rand(0, count($categories)));
    foreach($randomCategories as $randomCategory) {
        $pdo->exec("INSERT INTO post_category SET post_id=$post, category_id=$randomCategory");
    }
}

$password = password_hash('admin', PASSWORD_BCRYPT);
$pdo->exec("INSERT INTO user SET username='admin', password='$password'");