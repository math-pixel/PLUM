<?php
// src/Controller/AssetDetailController.php

namespace App\Controller;

use App\Entity\Asset;
use App\Repository\TransactionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class AssetDetailController extends AbstractController
{
    #[Route('/asset/{id}/chart', name: 'app_asset_chart', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function chart(Asset $asset, TransactionRepository $transactionRepository): Response
    {
        // Récupère uniquement les transactions de l'utilisateur pour cet asset
        $transactions = $transactionRepository->findBy(
            ['asset' => $asset, 'user' => $this->getUser()],
            ['id' => 'ASC']
        );

        $labels = [];
        $investments = [];
        $prices = [];
        $cumulative = 0.0;

        foreach ($transactions as $tx) {
            $priceFloat = $tx->getPrice() / 100;
            $cumulative += $tx->getQuantity() * $priceFloat;

            $labels[] = 'T'.$tx->getId();             // ou $tx->getCreatedAt()->format('d/m/Y')
            $investments[] = round($cumulative, 2);
            $prices[] = round($priceFloat, 2);
        }

        return $this->render('asset_detail/index.html.twig', [
            'asset'        => $asset,
            'labels'       => $labels,
            'investments'  => $investments,
            'prices'       => $prices,
            'transactions' => $transactions
        ]);
    }
}