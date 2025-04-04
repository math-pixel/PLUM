<?php

namespace App\Controller;

use App\Entity\UserAsset;
use App\Form\UserAssetType;
use App\Repository\UserAssetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user/asset')]
final class UserAssetController extends AbstractController
{
    #[Route(name: 'app_user_asset_index', methods: ['GET'])]
    public function index(UserAssetRepository $userAssetRepository): Response
    {
        return $this->render('user_asset/index.html.twig', [
            'user_assets' => $userAssetRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_asset_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userAsset = new UserAsset();
        $form = $this->createForm(UserAssetType::class, $userAsset);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($userAsset);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_asset_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user_asset/new.html.twig', [
            'user_asset' => $userAsset,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_asset_show', methods: ['GET'])]
    public function show(UserAsset $userAsset): Response
    {
        return $this->render('user_asset/show.html.twig', [
            'user_asset' => $userAsset,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_asset_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserAsset $userAsset, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserAssetType::class, $userAsset);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_asset_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user_asset/edit.html.twig', [
            'user_asset' => $userAsset,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_asset_delete', methods: ['POST'])]
    public function delete(Request $request, UserAsset $userAsset, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userAsset->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($userAsset);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_asset_index', [], Response::HTTP_SEE_OTHER);
    }
}
