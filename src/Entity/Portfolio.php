<?php

namespace App\Entity;

use App\Repository\PortfolioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PortfolioRepository::class)]
class Portfolio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Asset>
     */
    #[ORM\ManyToMany(targetEntity: Asset::class)]
    private Collection $assets;

    /**
     * @var Collection<int, self>
     */
    #[ORM\ManyToMany(targetEntity: self::class)]
    private Collection $portfolio;

    public function __construct()
    {
        $this->assets = new ArrayCollection();
        $this->portfolio = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Asset>
     */
    public function getAssets(): Collection
    {
        return $this->assets;
    }

    public function addAsset(Asset $asset): static
    {
        if (!$this->assets->contains($asset)) {
            $this->assets->add($asset);
        }

        return $this;
    }

    public function removeAsset(Asset $asset): static
    {
        $this->assets->removeElement($asset);

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getPortfolio(): Collection
    {
        return $this->portfolio;
    }

    public function addPortfolio(self $portfolio): static
    {
        if (!$this->portfolio->contains($portfolio)) {
            $this->portfolio->add($portfolio);
        }

        return $this;
    }

    public function removePortfolio(self $portfolio): static
    {
        $this->portfolio->removeElement($portfolio);

        return $this;
    }
}
