<?php

namespace App\Entity;

use App\Repository\AssetRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: AssetRepository::class)]
class Asset
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;
    private Collection $users;

    /**
     * @var Collection<int, PortfolioAsset>
     */
    #[ORM\OneToMany(targetEntity: PortfolioAsset::class, mappedBy: 'asset', orphanRemoval: true)]
    private Collection $portfolioAssets;


    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $symbol = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $currentValue = null;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->portfolioAssets = new ArrayCollection();
    }

    public function getUsers(): Collection
    {
        return $this->users;
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
     * @return Collection<int, PortfolioAsset>
     */
    public function getPortfolioAssets(): Collection
    {
        return $this->portfolioAssets;
    }

    public function addPortfolioAsset(PortfolioAsset $portfolioAsset): static
    {
        if (!$this->portfolioAssets->contains($portfolioAsset)) {
            $this->portfolioAssets->add($portfolioAsset);
            $portfolioAsset->setAsset($this);
        }

        return $this;
    }

    public function removePortfolioAsset(PortfolioAsset $portfolioAsset): static
    {
        if ($this->portfolioAssets->removeElement($portfolioAsset)) {
            if ($portfolioAsset->getAsset() === $this) {
                $portfolioAsset->setAsset(null);
            }
        }

        return $this;
    }

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function setSymbol(?string $symbol): void
    {
        $this->symbol = $symbol;
    }

    public function getCurrentValue(): ?float
    {
        return $this->currentValue;
    }

    public function setCurrentValue(?float $currentValue): self
    {
        $this->currentValue = $currentValue;
        return $this;
    }

}
