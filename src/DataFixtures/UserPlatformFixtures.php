<?php
// src/DataFixtures/UserPlateformFixtures.php

namespace App\DataFixtures;

use App\Entity\Platform;
use App\Entity\User;
use App\Entity\UserPlatform;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class UserPlatformFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // On crée par exemple 20 associations
        for ($i = 0; $i < 20; $i++) {
            $userPlatform = new UserPlatform();

            $user = $this->getReference('user_' . mt_rand(0, UserFixtures::USER_COUNT - 1), User::class);
            $platform = $this->getReference('platform_' . mt_rand(0, PlatformFixtures::PLATFORM_COUNT - 1), Platform::class);

            $userPlatform->setUser($user);
            $userPlatform->setPlatform($platform);
            $userPlatform->setApiKey($faker->uuid);

            $manager->persist($userPlatform);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [UserFixtures::class, PlatformFixtures::class];
    }
}