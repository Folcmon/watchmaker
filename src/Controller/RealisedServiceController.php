<?php

namespace App\Controller;

use App\Entity\RealisedService;
use App\Form\RealisedServiceType;
use App\Repository\RealisedServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_USER")
 */

#[Route('/realised_service')]
class RealisedServiceController extends AbstractController
{
    #[Route('/', name: 'realised_service_index', methods: ['GET'])]
    public function index(RealisedServiceRepository $realisedServiceRepository): Response
    {
        return $this->render('realised_service/index.html.twig', [
            'realised_services' => $realisedServiceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'realised_service_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $realisedService = new RealisedService();
        $form = $this->createForm(RealisedServiceType::class, $realisedService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($realisedService);
            $entityManager->flush();

            return $this->redirectToRoute('realised_service_index');
        }

        return $this->render('realised_service/new.html.twig', [
            'realised_service' => $realisedService,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'realised_service_show', methods: ['GET'])]
    public function show(RealisedService $realisedService): Response
    {
        return $this->render('realised_service/show.html.twig', [
            'realised_service' => $realisedService,
        ]);
    }

    #[Route('/{id}/edit', name: 'realised_service_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RealisedService $realisedService): Response
    {
        $form = $this->createForm(RealisedServiceType::class, $realisedService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('realised_service_index');
        }

        return $this->render('realised_service/edit.html.twig', [
            'realised_service' => $realisedService,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'realised_service_delete', methods: ['POST'])]
    public function delete(Request $request, RealisedService $realisedService): Response
    {
        if ($this->isCsrfTokenValid('delete'.$realisedService->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($realisedService);
            $entityManager->flush();
        }

        return $this->redirectToRoute('realised_service_index');
    }
}
