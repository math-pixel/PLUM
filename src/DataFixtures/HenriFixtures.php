<?php
// src/DataFixtures/DemoFixtures.php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Portfolio;
use App\Entity\Asset;
use App\Entity\PortfolioAsset;
use App\Entity\Transaction;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class HenriFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // 1. Création de l'utilisateur
        $henri = new User();
        $henri->setEmail('henri.larget@gmail.com');
        $hashed = $this->passwordHasher->hashPassword($henri, 'password123');
        $henri->setPassword($hashed);
        $manager->persist($henri);

        // 2. Portfolios
        $parent = new Portfolio();
        $parent->setName('le meilleur prof')->setUser($henri);
        $manager->persist($parent);

        $child = new Portfolio();
        $child->setName('les meilleurs élèves')->setUser($henri)->setParent($parent);
        $manager->persist($child);

        // 3. Asset for parent portfolio only
        $henriAsset = new Asset();
        $henriAsset->setName('HENRI');
        $manager->persist($henriAsset);

        $parentPa = new PortfolioAsset();
        $parentPa->setPortfolio($parent)
                 ->setAsset($henriAsset);
        $manager->persist($parentPa);

        // 4. Assets for child portfolio only
        $childAssetNames = ['MATHIEU', 'UGO', 'PL'];
        foreach ($childAssetNames as $name) {
            $asset = new Asset();
            $asset->setName($name);
            $manager->persist($asset);

            $pa = new PortfolioAsset();
            $pa->setPortfolio($child)
               ->setAsset($asset);
            $manager->persist($pa);

            // 5. Generate realistic transactions for Henri on this asset
            $txCount = $faker->numberBetween(10, 20);
            for ($t = 0; $t < $txCount; $t++) {
                $tx = new Transaction();
                $qty = $faker->numberBetween(1, 100);
                if ($faker->boolean(30)) {
                    $qty = -$faker->numberBetween(1, min($qty, 50));
                }
                $price = round($faker->randomFloat(2, 5, 50), 2);
                $tx->setUser($henri)
                   ->setAsset($asset)
                   ->setQuantity($qty)
                   ->setPrice($price);
                $manager->persist($tx);
            }
        }

        $manager->flush();
    }
}