<?php

namespace App\Entity;

use App\Repository\PortfolioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

#[ORM\Entity(repositoryClass: PortfolioRepository::class)]
class Portfolio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'children')]
    private ?self $parent = null;

    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'parent')]
    private Collection $children;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'portfolios')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, PortfolioAsset>
     */
    #[ORM\OneToMany(targetEntity: PortfolioAsset::class, mappedBy: 'portfolio', orphanRemoval: true)]
    private Collection $portfolioAssets;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->portfolioAssets = new ArrayCollection();
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

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(self $child): static
    {
        if (!$this->children->contains($child)) {
            $this->children->add($child);
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(self $child): static
    {
        if ($this->children->removeElement($child)) {
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

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
            $portfolioAsset->setPortfolio($this);
        }

        return $this;
    }

    public function removePortfolioAsset(PortfolioAsset $portfolioAsset): static
    {
        if ($this->portfolioAssets->removeElement($portfolioAsset)) {
            // set the owning side to null (unless already changed)
            if ($portfolioAsset->getPortfolio() === $this) {
                $portfolioAsset->setPortfolio(null);
            }
        }

        return $this;
    }

//    public function getTotalAmount(): int{
//        return 0;
//    }
}