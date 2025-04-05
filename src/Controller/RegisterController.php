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

#[Route('/register')]
final class RegisterController extends AbstractController
{
    #[Route(name: '', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('register/index.html.twig', [

        ]);
    }
}
