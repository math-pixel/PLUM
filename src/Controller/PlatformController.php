<?php

namespace App\Controller;

use App\Entity\Platform;
use App\Form\PlatformType;
use App\Repository\PlatformRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/platform')]
final class PlatformController extends AbstractController
{
    #[Route(name: 'app_platform_index', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(PlatformRepository $platformRepository): Response
    {
        return $this->render('platform/index.html.twig', [
            'platforms' => $platformRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_platform_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $platform = new Platform();
        $form = $this->createForm(PlatformType::class, $platform);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($platform);
            $entityManager->flush();

            return $this->redirectToRoute('app_platform_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('platform/new.html.twig', [
            'platform' => $platform,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_platform_show', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function show(Platform $platform): Response
    {
        return $this->render('platform/show.html.twig', [
            'platform' => $platform,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_platform_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Platform $platform, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PlatformType::class, $platform);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_platform_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('platform/edit.html.twig', [
            'platform' => $platform,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_platform_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Platform $platform, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$platform->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($platform);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_platform_index', [], Response::HTTP_SEE_OTHER);
    }
}
