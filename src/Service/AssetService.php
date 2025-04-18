<?php
// src/Service/AssetService.php

namespace App\Service;

use App\Entity\Asset;
use App\Entity\User;
use App\Repository\TransactionRepository;
use App\Repository\AssetRepository;

class AssetService
{
    private TransactionRepository $transactionRepository;
    private AssetRepository $assetRepository;

    public function __construct(TransactionRepository $transactionRepository, AssetRepository $assetRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->assetRepository = $assetRepository;
    }

    public function getLastTransactionPrice(Asset $asset, User $user): ?float
    {
        return $this->transactionRepository->findLastPrice($asset, $user);
    }

    public function getTotalQuantity(Asset $asset, User $user): float
    {
        return $this->transactionRepository->sumQuantityByAssetAndUser($asset, $user);
    }

    public function getCurrentValue(Asset $asset, User $user): float
    {
        $quantity = $this->getTotalQuantity($asset, $user);
        $lastPrice = $this->getLastTransactionPrice($asset, $user) ?? 0.0;

        return $quantity * $lastPrice;
    }

    public function getUserTotalQuantity(User $user): float
    {
        return $this->transactionRepository->sumQuantityByUser($user);
    }

    public function getUserTotalValue(User $user): float
    {
        $totalValue = 0.0;
        $assetIds = $this->transactionRepository->findAllAssetIdsByUser($user);

        foreach ($assetIds as $assetId) {
            $asset = $this->assetRepository->find($assetId);
            if ($asset) {
                $quantity = $this->getTotalQuantity($asset, $user);
                $price = $this->getLastTransactionPrice($asset, $user) ?? 0.0;
                $totalValue += $quantity * $price;
            }
        }

        return $totalValue;
    }
}
