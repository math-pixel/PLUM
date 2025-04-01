<?php

namespace App\Controller;

use App\Entity\UserPlatform;
use App\Form\UserPlatformType;
use App\Repository\UserPlatformRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user/platform')]
final class UserPlatformController extends AbstractController
{
    #[Route(name: 'app_user_platform_index', methods: ['GET'])]
    public function index(UserPlatformRepository $userPlatformRepository): Response
    {
        return $this->render('user_platform/index.html.twig', [
            'user_platforms' => $userPlatformRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_platform_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userPlatform = new UserPlatform();
        $form = $this->createForm(UserPlatformType::class, $userPlatform);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($userPlatform);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_platform_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user_platform/new.html.twig', [
            'user_platform' => $userPlatform,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_platform_show', methods: ['GET'])]
    public function show(UserPlatform $userPlatform): Response
    {
        return $this->render('user_platform/show.html.twig', [
            'user_platform' => $userPlatform,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_platform_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserPlatform $userPlatform, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserPlatformType::class, $userPlatform);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_platform_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user_platform/edit.html.twig', [
            'user_platform' => $userPlatform,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_platform_delete', methods: ['POST'])]
    public function delete(Request $request, UserPlatform $userPlatform, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userPlatform->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($userPlatform);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_platform_index', [], Response::HTTP_SEE_OTHER);
    }
}
