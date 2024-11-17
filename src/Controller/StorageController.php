<?php

namespace App\Controller;

use App\Entity\Storage;
use App\Form\StorageType;
use App\Repository\StorageRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/storage')]
#[IsGranted('ROLE_USER')]
class StorageController extends BaseController
{
    #[Route('/', name: 'storage_index', methods: ['GET'])]
    public function index(
        StorageRepository $storageRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $pagination = $paginator->paginate(
            $storageRepository->findBy([], ['createdAt' => 'DESC']),
            $request->query->getInt('page', 1)
        );
        $pagination->setCustomParameters([
            'align' => 'center'
        ]);
        return $this->render('storage/index.html.twig', [

            'pagination' => $pagination,
        ]);
    }

    #[Route('/new', name: 'storage_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $storage = new Storage();
        $form = $this->createForm(StorageType::class, $storage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->doctrine;
            $entityManager->persist($storage);
            $entityManager->flush();

            return $this->redirectToRoute('storage_index');
        }

        return $this->render('storage/new.html.twig', [
            'storage' => $storage,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'storage_show', methods: ['GET'])]
    public function show(Storage $storage): Response
    {
        return $this->render('storage/show.html.twig', [
            'storage' => $storage,
        ]);
    }

    #[Route('/{id}/edit', name: 'storage_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Storage $storage): Response
    {
        $form = $this->createForm(StorageType::class, $storage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->doctrine->flush();

            return $this->redirectToRoute('storage_index');
        }

        return $this->render('storage/edit.html.twig', [
            'storage' => $storage,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'storage_delete', methods: ['POST'])]
    public function delete(Request $request, Storage $storage): Response
    {
        if ($this->isCsrfTokenValid('delete' . $storage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->doctrine;
            $entityManager->remove($storage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('storage_index');
    }
}
