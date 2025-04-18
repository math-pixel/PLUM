<?php
// src/DataFixtures/TransactionFixtures.php

namespace App\DataFixtures;

use App\Entity\Asset;
use App\Entity\Transaction;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TransactionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Generate realistic transactions per user and per asset
        for ($u = 0; $u < UserFixtures::USER_COUNT; $u++) {
            $user = $this->getReference('user_' . $u, User::class);

            for ($a = 0; $a < AssetFixtures::ASSET_COUNT; $a++) {
                $asset = $this->getReference('asset_' . $a, Asset::class);

                // Each user does between 5 and 15 transactions per asset
                $txCount = $faker->numberBetween(5, 15);
                for ($t = 0; $t < $txCount; $t++) {
                    $transaction = new Transaction();
                    $transaction->setUser($user);
                    $transaction->setAsset($asset);

                    // Random quantity: positive (buy) or negative (sell)
                    $quantity = $faker->numberBetween(1, 100);
                    if ($faker->boolean(30)) {
                        $quantity = -$faker->numberBetween(1, min($quantity, 50));
                    }
                    $transaction->setQuantity($quantity);

                    // Random purchase price between 1€ and 500€ with 2 decimals
                    $price = round($faker->randomFloat(2, 1, 500), 2);
                    $transaction->setPrice($price);

                    $manager->persist($transaction);
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            AssetFixtures::class,
        ];
    }
}