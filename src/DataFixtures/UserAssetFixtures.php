<?php
// src/DataFixtures/UserAssetFixtures.php

namespace App\DataFixtures;

use App\Entity\Asset;
use App\Entity\User;
use App\Entity\UserAsset;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class UserAssetFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Création de 30 associations
        for ($i = 0; $i < 30; $i++) {
            $userAsset = new UserAsset();

            $user = $this->getReference('user_' . mt_rand(0, UserFixtures::USER_COUNT - 1), User::class);
            $asset = $this->getReference('asset_' . mt_rand(0, AssetFixtures::ASSET_COUNT - 1), Asset::class);

            $userAsset->setUser($user);
            $userAsset->setAsset($asset);
            $userAsset->setNumber($faker->randomFloat(2, 1, 100));
            $userAsset->setData($faker->word);

            $manager->persist($userAsset);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [UserFixtures::class, AssetFixtures::class];
    }
}