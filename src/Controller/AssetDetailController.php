<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

final class AssetDetailController extends AbstractController
{
    #[Route('/detail', name: 'app_asset_detail')]
    public function index(): Response
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
        ];

        $chart = [
            'labels' => ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'],
            'datasets' => [
                [
                    'label' => 'Investissement',
                    'data' => [1000, 1000, 1000, 1000, 1000, 1000, 1000, 1000, 1000, 1000, 1000, 1000],
                    'backgroundColor' => $colors['purple']['fill'],
                    'borderColor' => $colors['purple']['stroke'],
                    'borderWidth' => 2,
                    'tension' => 0.4,
                    'fill' => true,
                ],
                [
                    'label' => 'Intérêts',
                    'data' => [1000, 1020, 1040, 1080, 1100, 1150, 1200, 1300, 1400, 1500, 1600, 1700],
                    'backgroundColor' => $colors['blue']['fill'],
                    'borderColor' => $colors['blue']['stroke'],
                    'borderWidth' => 2,
                    'tension' => 0.4,
                    'fill' => true,
                ],
                [
                    'label' => 'Profit',
                    'data' => [0, 20, 40, 80, 100, 150, 200, 300, 400, 500, 600, 700],
                    'backgroundColor' => $colors['emerald']['fill'],
                    'borderColor' => $colors['emerald']['stroke'],
                    'borderWidth' => 2,
                    'tension' => 0.4,
                    'fill' => true,
                ],
            ],
        ];


        return $this->render('asset_detail/index.html.twig', [
            'controller_name' => 'AssetDetailController',
            'chartData' => json_encode($chart),
            'assetName' => "BTC",
            'assetIcon' => "aaa"
        ]);
    }
}