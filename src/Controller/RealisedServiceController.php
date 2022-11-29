<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\RealisedService;
use App\Entity\RealisedServiceUsedItem;
use App\Entity\ServiceAttachment;
use App\Form\RealisedServiceType;
use App\Repository\RealisedServiceRepository;
use App\Repository\RealisedServiceUsedItemRepository;
use App\Repository\StorageRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 */
#[Route('/realised_service')]
class RealisedServiceController extends BaseController
{
    #[Route('/', name: 'realised_service_index', methods: ['GET'])]
    public function index(Request $request, RealisedServiceRepository $realisedServiceRepository, PaginatorInterface $paginator): Response
    {
        $results = null;
        $qb = $this->doctrine->createQueryBuilder();

        if (!$request->get('search')) {
            $results = $realisedServiceRepository->findAll();
        } else {
            $results = $realisedServiceRepository->createQueryBuilder('r_e')
                ->join('r_e.client', 'c_e')
                ->where($qb->expr()->like('c_e.email', ':search'))
                ->orWhere($qb->expr()->like('c_e.telephone', ':search'))
                ->setParameter('search', "%" . $request->get('search') . "%");
        }

        $pagination = $paginator->paginate(
            $results,
            $request->query->getInt('page', 1),
            25
        );

        return $this->render('realised_service/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/new', name: 'realised_service_new', methods: ['GET', 'POST'])]
    public function new(Request $request, StorageRepository $storageRepository): Response
    {
        $em = $this->doctrine;
        $realisedService = new RealisedService();
        $form = $this->createForm(RealisedServiceType::class, $realisedService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $usedParts = $request->request->get('realised_service')['usedParts'];
            foreach ($usedParts as $oneUsedPart) {
                $usedPartStorageEntity = $storageRepository->find($oneUsedPart['usedPart']);
                $usedPartStorageEntity->setQunatity($usedPartStorageEntity->getQunatity() - $oneUsedPart['quantity']);
                $realisedServiceUsedItem = new RealisedServiceUsedItem();
                $realisedServiceUsedItem->setName($usedPartStorageEntity->getName());
                $realisedServiceUsedItem->setQuantity($oneUsedPart['quantity']);
                $realisedServiceUsedItem->setPrice(0);// do zrobienia kalkulacja ceny feature na przyszłośc  cena albo 1 itemu bądz całkowita dla typu części  * ilosć
                $em->persist($realisedServiceUsedItem);
                $realisedService->addRealisedServiceUsedItem($realisedServiceUsedItem);
            }
            $em->flush();

            $files = $request->files->get('realised_service')['serviceAttachments'];
            if ($files != null) {
                $uploadsDirectory = $this->getParameter('uploadsDirectory');
                $this->uploadServiceAttachment($files, $realisedService, $uploadsDirectory);
            }
            $em->persist($realisedService);
            $em->flush();

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
    public function edit(Request $request, RealisedService $realisedService, StorageRepository $storageRepository, RealisedServiceUsedItemRepository $realisedServiceUsedItemRepository): Response
    {
        $em = $this->doctrine;
        $form = $this->createForm(RealisedServiceType::class, $realisedService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $usedParts = $request->request->get('realised_service')['usedParts'];
            foreach ($realisedService->getRealisedServiceUsedItems() as $oldOneRealisedServiceUsedItem) {
                $realisedService->removeRealisedServiceUsedItem($oldOneRealisedServiceUsedItem);
            }
            $em->flush();
            foreach ($usedParts as $oneUsedPart) {
                $usedPartStorageEntity = $storageRepository->find($oneUsedPart['usedPart']);
                $usedPartStorageEntity->setQunatity($usedPartStorageEntity->getQunatity() - $oneUsedPart['quantity']);
                $realisedServiceUsedItem = new RealisedServiceUsedItem();
                $realisedServiceUsedItem->setName($usedPartStorageEntity->getName());
                $realisedServiceUsedItem->setQuantity($oneUsedPart['quantity']);
                $realisedServiceUsedItem->setPrice(0);// do zrobienia kalkulacja ceny feature na przyszłośc  cena albo 1 itemu bądz całkowita dla typu części  * ilosć
                $em->persist($realisedServiceUsedItem);
                $realisedService->addRealisedServiceUsedItem($realisedServiceUsedItem);
            }
            $em->flush();

            $uploadsDirectory = $this->getParameter('uploadsDirectory');

            $filesystem = new Filesystem();
            if (!empty($realisedService->getServiceAttachments())) {
                foreach ($realisedService->getServiceAttachments() as $attachment) {
                    $fileToRemove = $uploadsDirectory . DIRECTORY_SEPARATOR . ServiceAttachment::SERVICE_ATTACHMENT_STORE_FOLDER . DIRECTORY_SEPARATOR . $attachment->getPath();
                    $filesystem->remove($fileToRemove);
                    $this->doctrine->remove($attachment);
                }
            }
            $em->flush();
            $files = $request->files->get('realised_service')['serviceAttachments'];
            if ($files != null) {
                $this->uploadServiceAttachment($files, $realisedService, $uploadsDirectory);
            }
            $em->flush();

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
        if ($this->isCsrfTokenValid('delete' . $realisedService->getId(), $request->request->get('_token'))) {
            $em = $this->doctrine;
            $em->remove($realisedService);
            $em->flush();
        }

        return $this->redirectToRoute('realised_service_index');
    }

    private function uploadServiceAttachment($files, $realisedService, $uploadsDirectory)
    {
        if ($files != null) {
            /**
             * @var $oneFileAttachment UploadedFile
             */
            foreach ($files as $oneFileAttachment) {
                $directory = $uploadsDirectory . DIRECTORY_SEPARATOR . ServiceAttachment::SERVICE_ATTACHMENT_STORE_FOLDER;
                $extension = $oneFileAttachment->guessExtension();
                if (!$extension) {
                    $extension = 'bin';
                }
                $filename = md5(microtime()) . '.' . $extension;
                $oneFileAttachment->move($directory, $filename);
                $serviceAttachment = new ServiceAttachment();
                $serviceAttachment->setPath($filename);
                $serviceAttachment->setService($realisedService);
                $this->doctrine->persist($serviceAttachment);
                $this->doctrine->flush();
            }
        }
    }

    #[Route('/client/{id}', name: 'realised_service_show_by_client', methods: ['GET'])]
    public function showByClient(Client $client, RealisedServiceRepository $realisedServiceRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $realisedServices = $realisedServiceRepository->findBy(['client' => $client]);

        $pagination = $paginator->paginate(
            $realisedServices,
            $request->query->getInt('page', 1),
            25
        );

        return $this->render('realised_service/showByClient.html.twig', [
            'pagination' => $pagination,
            'realised_services' => $realisedServices,
            'client' => $client
        ]);
    }

}
