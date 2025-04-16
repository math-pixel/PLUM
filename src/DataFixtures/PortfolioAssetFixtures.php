<?php
// src/DataFixtures/PortfolioAssetFixtures.php

namespace App\DataFixtures;

use App\Entity\Portfolio;
use App\Entity\PortfolioAsset;
use App\DataFixtures\PortfolioFixtures;
use App\Entity\Asset;
use App\DataFixtures\AssetFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PortfolioAssetFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Parcours de tous les portefeuilles créés dans PortfolioFixtures
        for ($i = 0; $i < PortfolioFixtures::PORTFOLIO_COUNT; $i++) {
            /** @var Portfolio $portfolio */
            $portfolio = $this->getReference('portfolio_' . $i, Portfolio::class);

            // On ajoute entre 1 et 5 assets à chaque portfolio
            $assetCount = rand(1, 5);
            for ($j = 0; $j < $assetCount; $j++) {
                $assetIndex = rand(0, AssetFixtures::ASSET_COUNT - 1);
                /** @var Asset $asset */
                $asset = $this->getReference('asset_' . $assetIndex, Asset::class);

                // Créer une nouvelle instance de l'entité intermédiaire
                $portfolioAsset = new PortfolioAsset();
                $portfolioAsset->setPortfolio($portfolio);
                $portfolioAsset->setAsset($asset);
                // Si tu souhaites ajouter d'autres informations (par ex. date d'ajout), tu peux les définir ici
                // $portfolioAsset->setAddedAt(new \DateTime());

                $manager->persist($portfolioAsset);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            PortfolioFixtures::class,
            AssetFixtures::class,
        ];
    }
}