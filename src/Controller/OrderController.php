<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Order;
use App\Entity\RealisedServiceUsedItem;
use App\Entity\ServiceAttachment;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use App\Repository\StorageRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 */
#[Route('/orders')]
class OrderController extends BaseController
{
    #[Route('/', name: 'order_index', methods: ['GET'])]
    public function index(Request $request, OrderRepository $orderRepository, PaginatorInterface $paginator): Response
    {
        $results = null;
        $qb = $this->doctrine->createQueryBuilder();

        if (!$request->get('search'))
        {
            $results = $orderRepository->findAll();
        } else
        {
            $results = $orderRepository->createQueryBuilder('order')
                ->join('order.client', 'client')
                ->where($qb->expr()->like('client.email', ':search'))
                ->orWhere($qb->expr()->like('client.telephone', ':search'))
                ->setParameter('search', "%" . $request->get('search') . "%");
        }

        $pagination = $paginator->paginate(
            $results,
            $request->query->getInt('page', 1)
        );
        $pagination->setCustomParameters([
            'align' => 'center'
        ]);

        return $this->render('order/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/new', name: 'order_new', methods: ['GET', 'POST'])]
    public function new(Request $request, StorageRepository $storageRepository): Response
    {
        $em = $this->doctrine;
        $realisedOrder = new Order();
        $form = $this->createForm(OrderType::class, $realisedOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $files = $request->files;
            foreach ($files->getIterator() as $file)
            {
                $uploadedFiles = $file['serviceAttachments'];
                $uploadsDirectory = $this->getParameter('uploadsDirectory');
                $this->uploadOrderAttachment($uploadedFiles, $realisedOrder, $uploadsDirectory);
            }
            $em->persist($realisedOrder);
            $em->flush();

            return $this->redirectToRoute('order_index');
        }

        return $this->render('order/new.html.twig', [
            'realised_order' => $realisedOrder,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'order_show', methods: ['GET'])]
    public function show(Order $realisedOrder): Response
    {
        return $this->render('order/show.html.twig', [
            'realised_order' => $realisedOrder,
        ]);
    }

    #[Route('/{id}/edit', name: 'order_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Order $realisedOrder, StorageRepository $storageRepository, RealisedServiceUsedItem $realisedOrderUsedItemRepository): Response
    {
        $em = $this->doctrine;
        $form = $this->createForm(OrderType::class, $realisedOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $usedParts = $request->request->get('order')['usedParts'];
            foreach ($realisedOrder->getRealisedServiceUsedItems() as $oldOneOrderUsedItem)
            {
                $realisedOrder->removeRealisedServiceUsedItem($oldOneOrderUsedItem);
            }
            $em->flush();
            foreach ($usedParts as $oneUsedPart)
            {
                $usedPartStorageEntity = $storageRepository->find($oneUsedPart['usedPart']);
                $usedPartStorageEntity->setQunatity($usedPartStorageEntity->getQunatity() - $oneUsedPart['quantity']);
                $realisedOrderUsedItem = new RealisedServiceUsedItem();
                $realisedOrderUsedItem->setName($usedPartStorageEntity->getName());
                $realisedOrderUsedItem->setQuantity($oneUsedPart['quantity']);
                $realisedOrderUsedItem->setPrice(0);// do zrobienia kalkulacja ceny feature na przyszłośc  cena albo 1 itemu bądz całkowita dla typu części  * ilosć
                $em->persist($realisedOrderUsedItem);
                $realisedOrder->addRealisedServiceUsedItem($realisedOrderUsedItem);
            }
            $em->flush();

            $uploadsDirectory = $this->getParameter('uploadsDirectory');

            $filesystem = new Filesystem();
            if (!empty($realisedOrder->getServiceAttachments()))
            {
                foreach ($realisedOrder->getServiceAttachments() as $attachment)
                {
                    $fileToRemove = $uploadsDirectory . DIRECTORY_SEPARATOR . ServiceAttachment::SERVICE_ATTACHMENT_STORE_FOLDER . DIRECTORY_SEPARATOR . $attachment->getPath();
                    $filesystem->remove($fileToRemove);
                    $this->doctrine->remove($attachment);
                }
            }
            $em->flush();
            $files = $request->files->get('order')['orderAttachments'];
            if ($files != null)
            {
                $this->uploadOrderAttachment($files, $realisedOrder, $uploadsDirectory);
            }
            $em->flush();

            return $this->redirectToRoute('order_index');
        }

        return $this->render('order/edit.html.twig', [
            'realised_order' => $realisedOrder,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'order_delete', methods: ['POST'])]
    public function delete(Request $request, Order $realisedOrder): Response
    {
        if ($this->isCsrfTokenValid('delete' . $realisedOrder->getId(), $request->request->get('_token')))
        {
            $em = $this->doctrine;
            $em->remove($realisedOrder);
            $em->flush();
        }

        return $this->redirectToRoute('order_index');
    }

    private function uploadOrderAttachment($files, $realisedOrder, $uploadsDirectory)
    {
        if ($files != null)
        {
            /**
             * @var $oneFileAttachment UploadedFile
             */
            foreach ($files as $oneFileAttachment)
            {
                $directory = $uploadsDirectory . DIRECTORY_SEPARATOR . ServiceAttachment::SERVICE_ATTACHMENT_STORE_FOLDER;
                $extension = $oneFileAttachment->guessExtension();
                if (!$extension)
                {
                    $extension = 'bin';
                }
                $filename = md5(microtime()) . '.' . $extension;
                $oneFileAttachment->move($directory, $filename);
                $orderAttachment = new ServiceAttachment();
                $orderAttachment->setPath($filename);
                $orderAttachment->setService($realisedOrder);
                $this->doctrine->persist($orderAttachment);
                $this->doctrine->flush();
            }
        }
    }

    #[Route('/client/{id}', name: 'order_show_by_client', methods: ['GET'])]
    public function showByClient(Client $client, OrderRepository $realisedOrderRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $realisedOrders = $realisedOrderRepository->findBy(['client' => $client]);

        $pagination = $paginator->paginate(
            $realisedOrders,
            $request->query->getInt('page', 1),
            25
        );

        return $this->render('order/showByClient.html.twig', [
            'pagination' => $pagination,
            'realised_orders' => $realisedOrders,
            'client' => $client
        ]);
    }

}
