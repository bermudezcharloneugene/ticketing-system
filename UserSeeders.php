<?php

require_once "./vendor/autoload.php";
use Faker\Factory;
use app\utils\Seeder;
use app\utils\Utility;

if($_SERVER['REQUEST_METHOD'] === 'GET')
{
    $seed = new Seeder;
    $faker = Factory::create();
    $salt = Utility::hashAlgo();
    $hashed = Utility::hashPassword('rigelaiden123', $salt);
    
    for($i=0; $i<5;$i++)
    {
        $fakeEmail = $faker->domainWord . '@philpacs.com';

        $query = "INSERT INTO USERS (NAME, EMAIL, PASSWORD, CREATED_AT, SALT) 
        VALUES ('$faker->name', '$fakeEmail', '$hashed', CURRENT_TIMESTAMP, '$salt')";
        $seed->seed($query);
    }

}