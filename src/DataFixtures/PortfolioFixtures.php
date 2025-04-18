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
    public const PORTFOLIO_COUNT = 5;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Realistic parent portfolio names and their child mappings
        $parentNames = [
            'Real Estate',
            'Bonds',
            'Equities',
            'Commodities',
            'Global Markets',
        ];
        $childMapping = [
            'Real Estate' => ['Residential', 'Commercial', 'REITs'],
            'Bonds' => ['Government', 'Corporate', 'Municipal'],
            'Equities' => ['Large Cap', 'Mid Cap', 'Small Cap'],
            'Commodities' => ['Gold', 'Oil', 'Agriculture'],
            'Global Markets' => ['Emerging', 'Developed', 'Frontier'],
        ];

        foreach ($parentNames as $i => $parentName) {
            $portfolio = new Portfolio();
            $portfolio->setName($parentName);
            // Associate a random user
            $user = $this->getReference('user_' . mt_rand(0, UserFixtures::USER_COUNT - 1), User::class);
            $portfolio->setUser($user);
            $manager->persist($portfolio);
            $this->addReference('portfolio_' . $i, $portfolio);

            // Create coherent child portfolios
            foreach ($childMapping[$parentName] as $j => $childSuffix) {
                $child = new Portfolio();
                $child->setName($parentName . ' - ' . $childSuffix);
                $child->setUser($user);
                $child->setParent($portfolio);
                $manager->persist($child);
                $this->addReference('portfolio_' . $i . '_child_' . $j, $child);
            }
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