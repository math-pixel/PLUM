<?php
// src/DataFixtures/AssetFixtures.php

namespace App\DataFixtures;

use App\Entity\Asset;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AssetFixtures extends Fixture
{
    public const ASSET_COUNT = 10;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < self::ASSET_COUNT; $i++) {
            $asset = new Asset();
            $asset->setName($faker->word);

            $manager->persist($asset);
            $this->addReference('asset_' . $i, $asset);
        }

        $manager->flush();
    }
}