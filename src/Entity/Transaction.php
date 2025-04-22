<?php
// src/Entity/Transaction.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "transactions")]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'transactions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Asset::class, inversedBy: 'transactions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Asset $asset = null;

    // Quantité de la transaction (positive pour un ajout, négative pour un retrait)
    #[ORM\Column(type:"integer")]
    private int $quantity;

    // Prix d'achat en centimes
    #[ORM\Column(type:"integer")]
    private int $price;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getAsset(): ?Asset
    {
        return $this->asset;
    }

    public function setAsset(?Asset $asset): self
    {
        $this->asset = $asset;
        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * Définit la quantité de la transaction (peut être négative ou positive).
     */
    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getPrice(): int
    {
        return $this->price;
    }


    public function setPrice($price): self
    {
        if (is_string($price)) {
            if (!str_contains($price, '.') && !str_contains($price, ',')) {
                $price .= '.00';
            }
            $price = floatval(str_replace(',', '.', $price));
        }
        $this->price = (int) round($price * 100);
        return $this;
    }
}