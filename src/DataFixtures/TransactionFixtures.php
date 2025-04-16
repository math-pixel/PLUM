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
    public const TRANSACTION_COUNT = 30;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < self::TRANSACTION_COUNT; $i++) {
            $transaction = new Transaction();

            $user = $this->getReference('user_' . mt_rand(0, UserFixtures::USER_COUNT - 1), User::class);
            $transaction->setUser($user);

            $asset = $this->getReference('asset_' . mt_rand(0, AssetFixtures::ASSET_COUNT - 1), Asset::class);
            $transaction->setAsset($asset);

            // Génère une quantité aléatoire pouvant être positive ou négative
            $quantity = $faker->numberBetween(-100, 100);
            $transaction->setQuantity($quantity);

            // Génère un prix d'achat aléatoire (entre 1€ et 500€)
            $price = $faker->randomFloat(2, 1, 500);
            $transaction->setPrice($price);

            $manager->persist($transaction);
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