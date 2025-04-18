<?php
// src/DataFixtures/AssetFixtures.php

namespace App\DataFixtures;

use App\Entity\Asset;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AssetFixtures extends Fixture
{
    public const ASSET_COUNT = 10;

    public function load(ObjectManager $manager): void
    {
        $names = [
            'Apple Inc.',
            'Microsoft Corp.',
            'Amazon.com Inc.',
            'Alphabet Inc.',
            'Tesla Inc.',
            'Meta Platforms Inc.',
            'Netflix Inc.',
            'NVIDIA Corp.',
            'Adobe Inc.',
            'Intel Corp.',
        ];

        for ($i = 0; $i < count($names); $i++) {
            $asset = new Asset();
            $asset->setName($names[$i]);

            $manager->persist($asset);
            $this->addReference('asset_' . $i, $asset);
        }

        $manager->flush();
    }
}