<?php

namespace App\Controller;

use App\Entity\Asset;
use App\Form\AssetType;
use App\Repository\AssetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/login')]
final class LoginController extends AbstractController
{
    #[Route(name: '', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('login/index.html.twig', [

        ]);
    }
}
