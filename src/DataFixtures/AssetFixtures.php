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

        // Quelques exemples d'assets réels avec symboles connus
        $assets = [
            ['name' => 'Apple', 'symbol' => 'AAPL'],
            ['name' => 'Microsoft', 'symbol' => 'MSFT'],
            ['name' => 'Tesla', 'symbol' => 'TSLA'],
            ['name' => 'Amazon', 'symbol' => 'AMZN'],
            ['name' => 'Google', 'symbol' => 'GOOGL'],
            ['name' => 'Bitcoin', 'symbol' => 'BTC-USD'],
            ['name' => 'Ethereum', 'symbol' => 'ETH-USD'],
            ['name' => 'TotalEnergies', 'symbol' => 'TTE.PA'],
            ['name' => 'BNP Paribas', 'symbol' => 'BNP.PA'],
            ['name' => 'Airbus', 'symbol' => 'AIR.PA'],
        ];

        foreach ($assets as $i => $data) {
            $asset = new Asset();
            $asset->setName($data['name']);
            $asset->setSymbol($data['symbol']);
            $asset->setCurrentValue($faker->randomFloat(2, 10, 1000));
            $manager->persist($asset);
            $this->addReference('asset_' . $i, $asset);
        }

        $manager->flush();
    }
}
