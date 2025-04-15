<?php
// src/DataFixtures/PlatformFixtures.php

namespace App\DataFixtures;

use App\Entity\Platform;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PlatformFixtures extends Fixture
{
    public const PLATFORM_COUNT = 5;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < self::PLATFORM_COUNT; $i++) {
            $platform = new Platform();
            $platform->setName($faker->company);
            $platform->setEndpoint($faker->url);

            $manager->persist($platform);
            $this->addReference('platform_' . $i, $platform);
        }

        $manager->flush();
    }
}