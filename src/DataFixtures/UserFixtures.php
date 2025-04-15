<?php
// src/DataFixtures/UserFixtures.php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public const USER_COUNT = 20;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < self::USER_COUNT; $i++) {
            $user = new User();
            $user->setEmail($faker->unique()->email);
            // Dans un vrai contexte, encode le mot de passe.
            $user->setPassword('password');

            $manager->persist($user);
            // On enregistre une référence pour l'utiliser dans les autres fixtures
            $this->addReference('user_' . $i, $user);
        }

        $manager->flush();
    }
}