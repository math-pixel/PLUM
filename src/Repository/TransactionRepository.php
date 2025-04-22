<?php
// src/Repository/TransactionRepository.php

namespace App\Repository;

use App\Entity\Asset;
use App\Entity\User;
use App\Entity\Transaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    public function findLastPrice(Asset $asset, User $user): ?float
    {
        $transaction = $this->findOneBy([
            'asset' => $asset,
            'user' => $user
        ], ['id' => 'DESC']);

        return $transaction?->getPrice() / 100;
    }

    public function sumQuantityByAssetAndUser(Asset $asset, User $user): float
    {
        assert($asset instanceof Asset);
        assert($user instanceof User);

        return (float) $this->createQueryBuilder('t')
            ->select('SUM(t.quantity)')
            ->where('t.asset = :asset')
            ->andWhere('t.user = :user')
            ->setParameter('asset', $asset)
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function sumQuantityByUser(User $user): float
    {
        return (float) $this->createQueryBuilder('t')
            ->select('SUM(t.quantity)')
            ->where('t.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findAllAssetIdsByUser(User $user): array
    {
        $results = $this->createQueryBuilder('t')
            ->select('DISTINCT IDENTITY(t.asset) as asset_id')
            ->where('t.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getArrayResult();

        return array_column($results, 'asset_id');
    }
}