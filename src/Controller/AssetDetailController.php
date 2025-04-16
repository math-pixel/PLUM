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
            // Couleurs existantes
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

            // Nouvelles couleurs
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

        $labels = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
        $datasets = [];

        $labelsCharts = ['Investissement','Intérêts','Profit'];
        $datas = [
            [1000, 1000, 1000, 1000, 1000, 1000, 1000, 1000, 1000, 1000, 1000, 1000],
            [1000, 1020, 1040, 1080, 1100, 1150, 1200, 1300, 1400, 1500, 1600, 1700],
            [0, 20, 40, 80, 100, 150, 200, 300, 400, 500, 600, 700],
        ];
        $colorSelected = ['fuchsia', 'red', 'emerald'];


        for ($i = 0; $i < 3; $i++) {
            $datasets[$i] = [
                'label' => $labelsCharts[$i],
                'data' => $datas[$i],
                'backgroundColor' => $colors[$colorSelected[$i]]['fill'],
                'borderColor' => $colors[$colorSelected[$i]]['stroke'],
                'borderWidth' => 2,
                'tension' => 0.4,
                'fill' => true,
            ];
        }


        $chart = [
            'labels' => $labels,
            'datasets' => $datasets
        ];


        return $this->render('asset_detail/index.html.twig', [
            'controller_name' => 'AssetDetailController',
            'chartData' => json_encode($chart),
            'assetName' => "BTC",
            'assetIcon' => "aaa"
        ]);
    }
}

//[
//    [
//        'label' => 'Investissement',
//        'data' => [1000, 1000, 1000, 1000, 1000, 1000, 1000, 1000, 1000, 1000, 1000, 1000],
//        'backgroundColor' => $colors['purple']['fill'],
//        'borderColor' => $colors['purple']['stroke'],
//        'borderWidth' => 2,
//        'tension' => 0.4,
//        'fill' => true,
//    ],
//    [
//        'label' => 'Intérêts',
//        'data' => [1000, 1020, 1040, 1080, 1100, 1150, 1200, 1300, 1400, 1500, 1600, 1700],
//        'backgroundColor' => $colors['blue']['fill'],
//        'borderColor' => $colors['blue']['stroke'],
//        'borderWidth' => 2,
//        'tension' => 0.4,
//        'fill' => true,
//    ],
//    [
//        'label' => 'Profit',
//        'data' => [0, 20, 40, 80, 100, 150, 200, 300, 400, 500, 600, 700],
//        'backgroundColor' => $colors['emerald']['fill'],
//        'borderColor' => $colors['emerald']['stroke'],
//        'borderWidth' => 2,
//        'tension' => 0.4,
//        'fill' => true,
//    ],
//],