<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Form\TransactionType;
use App\Repository\AssetRepository;
use App\Repository\PortfolioRepository;
use App\Repository\TransactionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/user/transaction')]
final class TransactionController extends AbstractController
{
    #[Route(name: 'app_transaction_index', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function index(TransactionRepository $transactionRepository): Response
    {
        $user = $this->getUser();
        $transactions = $transactionRepository->findBy(['user' => $user]);
        return $this->render('transaction/index.html.twig', [
            'transactions' => $transactions,
        ]);
    }

    #[Route('/new', name: 'app_transaction_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $transaction = new Transaction();
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Ajoute l'utilisateur connecté à la transaction
            $transaction->setUser($this->getUser());
            $entityManager->persist($transaction);
            $entityManager->flush();

            return $this->redirectToRoute('app_transaction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('transaction/new.html.twig', [
            'transaction' => $transaction,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_transaction_show', methods: ['GET'])]
    #[IsGranted('view', 'transaction')]
    public function show(Transaction $transaction): Response
    {
        return $this->render('transaction/show.html.twig', [
            'transaction' => $transaction,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_transaction_edit', methods: ['GET', 'POST'])]
    #[IsGranted('create', 'transaction')]
    public function edit(Request $request, Transaction $transaction, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_transaction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('transaction/edit.html.twig', [
            'transaction' => $transaction,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_transaction_delete', methods: ['POST'])]
    #[IsGranted('delete', 'transaction')]
    public function delete(Request $request, Transaction $transaction, EntityManagerInterface $entityManager): Response
    {

            $entityManager->remove($transaction);
            $entityManager->flush();

        return $this->redirectToRoute('app_transaction_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/transaction/portfolio/{portfolioId}/asset/{assetId}', name: 'app_transaction_asset_list', methods: ['GET'])]
    public function assetTransactions(
        int $portfolioId,
        int $assetId,
        PortfolioRepository $portfolioRepository,
        AssetRepository $assetRepository,
        TransactionRepository $transactionRepository
    ): Response {
        // Récupérer le portfolio et l'asset
        $portfolio = $portfolioRepository->find($portfolioId);
        $asset = $assetRepository->find($assetId);

        if (!$portfolio || !$asset) {
            throw $this->createNotFoundException('Portfolio or asset not found');
        }

        // Récupérer les transactions pour cet asset et utilisateur
        $transactions = $transactionRepository->findBy([
            'user' => $this->getUser(),
            'asset' => $asset
        ]);

        return $this->render('transaction/asset_transactions_portfolio.html.twig', [
            'portfolio'    => $portfolio,
            'asset'        => $asset,
            'transactions' => $transactions,
        ]);
    }
}