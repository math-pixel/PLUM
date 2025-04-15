<?php
// src/DataFixtures/PortfolioFixtures.php

namespace App\DataFixtures;

use App\Entity\Portfolio;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\DataFixtures\UserFixtures;

class PortfolioFixtures extends Fixture implements DependentFixtureInterface
{
    public const PORTFOLIO_COUNT = 50;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < self::PORTFOLIO_COUNT; $i++) {
            $portfolio = new Portfolio();
            $portfolio->setName($faker->word);

            // Associer un utilisateur aléatoire
            $user = $this->getReference('user_' . mt_rand(0, UserFixtures::USER_COUNT - 1), User::class);
            $portfolio->setUser($user);

            // Optionnel : ajouter une hiérarchie (30% des portefeuilles ont un parent s'il existe)
            if ($i > 0 && mt_rand(0, 100) < 30) {
                $parentIndex = mt_rand(0, $i - 1);
                $parentPortfolio = $this->getReference('portfolio_' . $parentIndex, Portfolio::class);
                $portfolio->setParent($parentPortfolio);
            }

            $manager->persist($portfolio);
            $this->addReference('portfolio_' . $i, $portfolio);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}