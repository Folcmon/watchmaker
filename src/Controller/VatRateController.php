<?php

namespace App\Controller;

use App\Entity\VatRate;
use App\Form\VatRateType;
use App\Repository\VatRateRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vat-rate')]
class VatRateController extends AbstractController
{
    #[Route('/', name: 'app_vat_rate_index', methods: ['GET'])]
    public function index(VatRateRepository $vatRateRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $results = $vatRateRepository->findAll();
        $pagination = $paginator->paginate(
            $results,
            $request->query->getInt('page', 1)
        );
        $pagination->setCustomParameters([
            'align' => 'center'
        ]);

        return $this->render('vat_rate/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/new', name: 'app_vat_rate_new', methods: ['GET', 'POST'])]
    public function new(Request $request, VatRateRepository $vatRateRepository): Response
    {
        $vatRate = new VatRate();
        $form = $this->createForm(VatRateType::class, $vatRate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $vatRateRepository->save($vatRate, true);

            return $this->redirectToRoute('app_vat_rate_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vat_rate/new.html.twig', [
            'vat_rate' => $vatRate,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vat_rate_show', methods: ['GET'])]
    public function show(VatRate $vatRate): Response
    {
        return $this->render('vat_rate/show.html.twig', [
            'vat_rate' => $vatRate,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_vat_rate_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, VatRate $vatRate, VatRateRepository $vatRateRepository): Response
    {
        $form = $this->createForm(VatRateType::class, $vatRate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $vatRateRepository->save($vatRate, true);

            return $this->redirectToRoute('app_vat_rate_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vat_rate/edit.html.twig', [
            'vat_rate' => $vatRate,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vat_rate_delete', methods: ['POST'])]
    public function delete(Request $request, VatRate $vatRate, VatRateRepository $vatRateRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $vatRate->getId(), $request->request->get('_token')))
        {
            $vatRateRepository->remove($vatRate, true);
        }

        return $this->redirectToRoute('app_vat_rate_index', [], Response::HTTP_SEE_OTHER);
    }
}
