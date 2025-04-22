<?php

namespace App\Entity;

use App\Repository\PortfolioAssetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PortfolioAssetRepository::class)]
class PortfolioAsset
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'portfolioAssets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Portfolio $portfolio = null;

    #[ORM\ManyToOne(inversedBy: 'portfolioAssets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Asset $asset = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPortfolio(): ?Portfolio
    {
        return $this->portfolio;
    }

    public function setPortfolio(?Portfolio $portfolio): static
    {
        $this->portfolio = $portfolio;

        return $this;
    }

    public function getAsset(): ?Asset
    {
        return $this->asset;
    }

    public function setAsset(?Asset $asset): static
    {
        $this->asset = $asset;

        return $this;
    }
}
