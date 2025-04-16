<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AssetDetailController extends AbstractController
{
    #[Route('/detail', name: 'app_asset_detail')]
    public function index(): Response
    {
        return $this->render('asset_detail/index.html.twig', [
            'controller_name' => 'AssetDetailController',
//            'asset' => ,
        ]);
    }
}
