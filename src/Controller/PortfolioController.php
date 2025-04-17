<?php

namespace App\Controller;

use App\Entity\Portfolio;
use App\Entity\PortfolioAsset;
use App\Form\PortfolioAssetType;
use App\Form\PortfolioType;
use App\Repository\AssetRepository;
use App\Repository\PortfolioRepository;
use App\Security\Voter\PortfolioVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/portfolio')]
final class PortfolioController extends AbstractController
{
    #[Route('/', name: 'app_portfolio_index', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function index(PortfolioRepository $portfolioRepository, AssetRepository $assetRepository): Response
    {
        $portfolios = $portfolioRepository->findBy(['user' => $this->getUser()]);

        // Création d'un formulaire pour chaque portfolio
        $forms = [];
        foreach ($portfolios as $portfolio) {
            $portfolioAsset = new PortfolioAsset();
            $portfolioAsset->setPortfolio($portfolio);
            $form = $this->createForm(PortfolioAssetType::class, $portfolioAsset, [
                'action' => $this->generateUrl('app_portfolio_add_asset', ['id' => $portfolio->getId()]),
                'method' => 'POST',
            ]);
            $forms[$portfolio->getId()] = $form->createView();
        }

        // Optionnel : récupérer tous les assets disponibles pour le select, si nécessaire
        $assets = $assetRepository->findAll();

        return $this->render('portfolio/index.html.twig', [
            'portfolios' => $portfolios,
            'forms' => $forms,
            'assets' => $assets, // si besoin dans le template pour un fallback
        ]);
    }

    #[Route('/new', name: 'app_portfolio_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        // Récupération de l'utilisateur connecté
        $user = $security->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour créer un portfolio.');
        }

        $portfolio = new Portfolio();

        // Vérifier si un portfolio parent est spécifié dans l'URL via le paramètre "parentId"
        $parentId = $request->query->get('parentId');
        if ($parentId) {
            $parentPortfolio = $entityManager->getRepository(Portfolio::class)->find($parentId);
            if ($parentPortfolio) {
                $portfolio->setParent($parentPortfolio);
            }
        }

        $form = $this->createForm(PortfolioType::class, $portfolio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On associe le portfolio à l'utilisateur connecté
            $portfolio->setUser($user);

            $entityManager->persist($portfolio);
            $entityManager->flush();

            return $this->redirectToRoute('app_portfolio_index');
        }

        return $this->render('portfolio/new.html.twig', [
            'portfolio' => $portfolio,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_portfolio_show', methods: ['GET'])]
    #[IsGranted('view', 'portfolio')]
    public function show(Portfolio $portfolio): Response
    {

        return $this->render('portfolio/show.html.twig', [
            'portfolio' => $portfolio,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_portfolio_edit', methods: ['GET', 'POST'])]
    #[IsGranted('edit', 'portfolio')]
    public function edit(Request $request, Portfolio $portfolio, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(PortfolioType::class, $portfolio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_portfolio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('portfolio/edit.html.twig', [
            'portfolio' => $portfolio,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_portfolio_delete', methods: ['POST'])]
    #[IsGranted('delete', 'portfolio')]
    public function delete(Request $request, Portfolio $portfolio, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($portfolio);
        $entityManager->flush();

        return $this->redirectToRoute('app_portfolio_index');
    }
    #[Route('/portfolio/{portfolioId}/asset/{assetId}/link', name: 'app_portfolio_asset_link', methods: ['POST'])]
    public function linkAssetToPortfolio(int $portfolioId, int $assetId, Request $request, EntityManagerInterface $entityManager, PortfolioRepository $portfolioRepository, AssetRepository $assetRepository): JsonResponse
    {
        $portfolio = $portfolioRepository->find( $portfolioId);
        $asset = $assetRepository->find($assetId);
        if (!$portfolio || !$asset) {
            return new JsonResponse(['message' => 'Not Found'], 404);
        }

        $portfolioAsset = new PortfolioAsset();
        $portfolioAsset->setPortfolio($portfolio);
        $portfolioAsset->setAsset($asset);

        $entityManager->persist($portfolioAsset);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Asset linked successfully'], 200);
    }
}
