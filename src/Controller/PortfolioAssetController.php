<?php

namespace App\Controller;

use App\Entity\Portfolio;
use App\Entity\PortfolioAsset;
use App\Form\PortfolioAssetType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class PortfolioAssetController extends AbstractController
{

    #[Route('/portfolio/{id}/add-asset', name: 'app_portfolio_add_asset', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function addAsset(Portfolio $portfolio, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Crée une nouvelle instance de PortfolioAsset et associe automatiquement le portfolio
        $portfolioAsset = new PortfolioAsset();
        $portfolioAsset->setPortfolio($portfolio);

        // Crée le formulaire pour associer un asset
        $form = $this->createForm(PortfolioAssetType::class, $portfolioAsset, [
            // Action pointant vers la même URL pour la soumission
            'action' => $this->generateUrl('app_portfolio_add_asset', ['id' => $portfolio->getId()]),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persistance de l'association via le form type
            $entityManager->persist($portfolioAsset);
            $entityManager->flush();

            $this->addFlash('success', 'L\'asset a été associé au portfolio.');

            // Redirection vers la page de détail du portfolio
            return $this->redirectToRoute('app_portfolio_index');
        }

        // Rendu du formulaire partiel dans une vue dédiée (par exemple, _add_asset_form.html.twig)
        return $this->render('portfolio/_add_asset_form.html.twig', [
            'portfolio' => $portfolio,
            'form' => $form->createView(),
        ]);
    }

}
