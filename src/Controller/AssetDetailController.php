<?php

namespace App\Controller;

use App\Service\AssetService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use App\Repository\TransactionRepository;
use App\Entity\Asset;
use Symfony\Component\HttpFoundation\Request;

final class AssetDetailController extends AbstractController
{
    #[Route('/asset/{id}/chart', name: 'app_asset_chart', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function chart(Asset $asset, ChartBuilderInterface $chartBuilder, TransactionRepository $transactionRepository, AssetService $assetService): Response
    {
        $colors = [
            'purple' => [
                'fill' => 'rgba(139, 92, 246, 0.2)',
                'stroke' => 'rgba(139, 92, 246, 1)',
            ],
            'blue' => [
                'fill' => 'rgba(59, 130, 246, 0.2)',
                'stroke' => 'rgba(59, 130, 246, 1)',
            ],
            'emerald' => [
                'fill' => 'rgba(16, 185, 129, 0.2)',
                'stroke' => 'rgba(16, 185, 129, 1)',
            ],
            'amber' => [
                'fill' => 'rgba(245, 158, 11, 0.2)',
                'stroke' => 'rgba(245, 158, 11, 1)',
            ],
            'rose' => [
                'fill' => 'rgba(244, 63, 94, 0.2)',
                'stroke' => 'rgba(244, 63, 94, 1)',
            ],
            'indigo' => [
                'fill' => 'rgba(99, 102, 241, 0.2)',
                'stroke' => 'rgba(99, 102, 241, 1)',
            ],
            'teal' => [
                'fill' => 'rgba(20, 184, 166, 0.2)',
                'stroke' => 'rgba(20, 184, 166, 1)',
            ],
            'orange' => [
                'fill' => 'rgba(249, 115, 22, 0.2)',
                'stroke' => 'rgba(249, 115, 22, 1)',
            ],
            'lime' => [
                'fill' => 'rgba(132, 204, 22, 0.2)',
                'stroke' => 'rgba(132, 204, 22, 1)',
            ],
            'cyan' => [
                'fill' => 'rgba(6, 182, 212, 0.2)',
                'stroke' => 'rgba(6, 182, 212, 1)',
            ],
            'fuchsia' => [
                'fill' => 'rgba(217, 70, 239, 0.2)',
                'stroke' => 'rgba(217, 70, 239, 1)',
            ],
            'pink' => [
                'fill' => 'rgba(236, 72, 153, 0.2)',
                'stroke' => 'rgba(236, 72, 153, 1)',
            ],
            'sky' => [
                'fill' => 'rgba(14, 165, 233, 0.2)',
                'stroke' => 'rgba(14, 165, 233, 1)',
            ],
            'red' => [
                'fill' => 'rgba(239, 68, 68, 0.2)',
                'stroke' => 'rgba(239, 68, 68, 1)',
            ],
            'green' => [
                'fill' => 'rgba(34, 197, 94, 0.2)',
                'stroke' => 'rgba(34, 197, 94, 1)',
            ],
            'yellow' => [
                'fill' => 'rgba(234, 179, 8, 0.2)',
                'stroke' => 'rgba(234, 179, 8, 1)',
            ],
        ];

        $transactions = $transactionRepository->findBy(
            ['asset' => $asset, 'user' => $this->getUser()],
            ['id' => 'ASC']
        );
        $labels = [];
        $investments = [];
        $prices = [];
        $cumulativeInvestment = 0;

        foreach ($transactions as $transaction) {
            $cumulativeInvestment += $transaction->getQuantity() * ($transaction->getPrice() / 100);
            $labels[] = 'T' . $transaction->getId();
            $investments[] = $cumulativeInvestment;
            $prices[] = $transaction->getPrice() / 100;
        }

        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Investissement cumulé',
                    'data' => $investments,
                    'backgroundColor' => $colors['fuchsia']['fill'],
                    'borderColor' => $colors['fuchsia']['stroke'],
                    'borderWidth' => 2,
                    'tension' => 0.4,
                    'fill' => true,
                ],
                [
                    'label' => 'Prix d\'achat',
                    'data' => $prices,
                    'yAxisID' => 'y1',
                    'backgroundColor' => $colors['red']['fill'],
                    'borderColor' => $colors['red']['stroke'],
                    'borderWidth' => 2,
                    'tension' => 0.4,
                    'fill' => false,
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'position' => 'left',
                    'title' => [
                        'display' => true,
                        'text' => 'Investissement (€)'
                    ],
                ],
                'y1' => [
                    'position' => 'right',
                    'title' => [
                        'display' => true,
                        'text' => "Prix d'achat (€)"
                    ],
                    'grid' => [
                        'drawOnChartArea' => false,
                    ],
                ],
            ],
        ]);
        $totalQuantity = $assetService->getTotalQuantity($asset, $this->getUser());
        $totalValue = $assetService->getCurrentValue($asset, $this->getUser());
        return $this->render('asset_detail/index.html.twig', [
            'chart' => $chart,
            'asset' => $asset,
            'transactions' => $transactions,
            'totalQuantity' => $totalQuantity,
            'totalValue' => $totalValue,
        ]);
    }
}