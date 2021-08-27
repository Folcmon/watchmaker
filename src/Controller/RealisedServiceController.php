<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\RealisedService;
use App\Entity\ServiceAttachment;
use App\Form\RealisedServiceType;
use App\Repository\RealisedServiceRepository;
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
class RealisedServiceController extends AbstractController
{
    #[Route('/', name: 'realised_service_index', methods: ['GET'])]
    public function index(Request $request, RealisedServiceRepository $realisedServiceRepository, PaginatorInterface $paginator): Response
    {
        $results = null;
        $qb = $this->getDoctrine()->getManager()->createQueryBuilder();

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
    public function new(Request $request): Response
    {
        $realisedService = new RealisedService();
        $form = $this->createForm(RealisedServiceType::class, $realisedService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $files = $request->files->get('realised_service')['serviceAttachments'];
            if ($files != null) {
                $uploadsDirectory = $this->getParameter('uploadsDirectory');
                $this->uploadServiceAttachment($files, $realisedService, $uploadsDirectory);
            }
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
            $uploadsDirectory = $this->getParameter('uploadsDirectory');

            $filesystem = new Filesystem();
            if (!empty($realisedService->getServiceAttachments())) {
                foreach ($realisedService->getServiceAttachments() as $attachment) {
                    $fileToRemove = $uploadsDirectory . DIRECTORY_SEPARATOR . ServiceAttachment::SERVICE_ATTACHMENT_STORE_FOLDER . DIRECTORY_SEPARATOR . $attachment->getPath();
                    $filesystem->remove($fileToRemove);
                    $this->getDoctrine()->getManager()->remove($attachment);
                }
            }
            $this->getDoctrine()->getManager()->flush();
            $files = $request->files->get('realised_service')['serviceAttachments'];
            if ($files != null) {
                $this->uploadServiceAttachment($files, $realisedService, $uploadsDirectory);
            }
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
        if ($this->isCsrfTokenValid('delete' . $realisedService->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($realisedService);
            $entityManager->flush();
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
                $this->getDoctrine()->getManager()->persist($serviceAttachment);
                $this->getDoctrine()->getManager()->flush();
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
