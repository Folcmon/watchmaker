<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Order;
use App\Entity\OrderAttachment;
use App\Enum\OrderStatusEnum;
use App\Form\OrderType;
use App\Repository\FileRepository;
use App\Repository\OrderAttachementRepository;
use App\Repository\OrderRepository;
use App\Repository\StorageRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[Route('/orders')]
class OrderController extends BaseController
{
    #[Route('/', name: 'order_index', methods: ['GET'])]
    public function index(Request $request, OrderRepository $orderRepository, PaginatorInterface $paginator): Response
    {
        $results = null;
        $qb = $this->doctrine->createQueryBuilder();

        if (!$request->get('search')) {
            $results = $orderRepository->findBy([], ['createdAt' => 'DESC']);
        } else {
            $results = $orderRepository->createQueryBuilder('order')
                ->join('order.client', 'client')
                ->where($qb->expr()->like('client.email', ':search'))
                ->orWhere($qb->expr()->like('client.telephone', ':search'))
                ->orWhere($qb->expr()->like('client.name', ':search'))
                ->orderBy('order.createdAt', 'DESC')
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

    #[Route('/new/{client}', name: 'order_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        StorageRepository $storageRepository,
        FileRepository $fileRepository,
        OrderAttachementRepository $orderAttachmentRepository,
        ?Client $client = null
    ): Response {
        $order = new Order();
        $order->setStatus(OrderStatusEnum::NEW->value);
        $order->setOrderAcceptanceDate(new \DateTime());
        if ($client !== null) {
            $order->setClient($client);
        }
        $this->entityManager->persist($order);
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);
        $this->saveOrder($form, $request, $order, $storageRepository, $fileRepository, $orderAttachmentRepository);
        return $this->render('order/new.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
        ]);
    }

    private function uploadOrderAttachment($files, $realisedOrder, $uploadsDirectory): void
    {
        if ($files != null) {
            /**
             * @var $oneFileAttachment UploadedFile
             */
            foreach ($files as $oneFileAttachment) {
                $directory = $uploadsDirectory . DIRECTORY_SEPARATOR . OrderAttachment::SERVICE_ATTACHMENT_STORE_FOLDER;
                $extension = $oneFileAttachment->guessExtension();
                if (!$extension) {
                    $extension = 'bin';
                }
                $filename = md5(microtime()) . '.' . $extension;
                $oneFileAttachment->move($directory, $filename);
                $orderAttachment = new OrderAttachment();
                $orderAttachment->setOrder($realisedOrder);
                $this->doctrine->persist($orderAttachment);
                $this->doctrine->flush();
            }
        }
    }

    #[Route('/{id}', name: 'order_show', methods: ['GET'])]
    public function show(Order $realisedOrder): Response
    {
        return $this->render('order/show.html.twig', [
            'order' => $realisedOrder,
        ]);
    }

    #[Route('/{id}/edit', name: 'order_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Order $order,
        StorageRepository $storageRepository,
        FileRepository $fileRepository,
        OrderAttachementRepository $orderAttachmentRepository
    ): Response {
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);
        $this->saveOrder($form, $request, $order, $storageRepository, $fileRepository, $orderAttachmentRepository);

        return $this->render('order/edit.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'order_delete', methods: ['POST'])]
    public function delete(Request $request, Order $realisedOrder): Response
    {
        if ($this->isCsrfTokenValid('delete' . $realisedOrder->getId(), $request->request->get('_token'))) {
            $em = $this->doctrine;
            $uploadsDirectory = $this->getParameter('uploadsDirectory');
            $filesystem = new Filesystem();
            if (!empty($realisedOrder->getOrderAttachments())) {
                foreach ($realisedOrder->getOrderAttachments() as $attachment) {
                    $fileToRemove = $uploadsDirectory . DIRECTORY_SEPARATOR . OrderAttachment::SERVICE_ATTACHMENT_STORE_FOLDER . DIRECTORY_SEPARATOR . $attachment->getPath();
                    $filesystem->remove($fileToRemove);
                    $this->doctrine->remove($attachment);
                }
            }
            $em->remove($realisedOrder);
            $em->flush();
        }

        return $this->redirectToRoute('order_index');
    }

    #[Route('/client/{id}', name: 'order_show_by_client', methods: ['GET'])]
    public function showByClient(
        Client $client,
        OrderRepository $realisedOrderRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $realisedOrders = $realisedOrderRepository->findBy(['client' => $client]);

        $pagination = $paginator->paginate(
            $realisedOrders,
            $request->query->getInt('page', 1),
            25
        );

        return $this->render('order/showByClient.html.twig', [
            'pagination' => $pagination,
            'orders' => $realisedOrders,
            'client' => $client
        ]);
    }

    private function saveOrder(
        FormInterface $form,
        Request $request,
        Order $order,
        StorageRepository $storageRepository,
        FileRepository $fileRepository,
        OrderAttachementRepository $orderAttachmentRepository
    ): void {
        if ($form->isSubmitted() && $form->isValid()) {
            $usedParts = $order->getRealisedServiceUsedItems() ?? null;
            if ($usedParts != null) {
                foreach ($usedParts as $oneUsedPart) {
                    $usedPartStorageEntity = $storageRepository->find($oneUsedPart->getStorage()->getId());
                    $usedPartStorageEntity->setQuantity($usedPartStorageEntity->getQuantity() - $oneUsedPart->getQuantity());
                    $calculatedPriceForOneItem = $usedPartStorageEntity->getTotalPrice() * $oneUsedPart->getQuantity();
                    $oneUsedPart->setPrice($calculatedPriceForOneItem);
                }

            }
            $this->entityManager->flush();
            $files = $request->get('order')['orderAttachments'] ?? null;
            if ($files != null) {
                foreach ($files as $file) {
                    //check if order attachment exists
                    $orderAttachment = $orderAttachmentRepository->findOneBy([
                        'order' => $order,
                        'file' => $fileRepository->find($file)
                    ]);
                    if ($orderAttachment !== null) {
                        continue;
                    }
                    $orderAttachment = new OrderAttachment();
                    $orderAttachment->setFile($fileRepository->find($file));
                    $orderAttachment->setOrder($order);
                    $this->entityManager->persist($orderAttachment);
                }
                $this->entityManager->flush();
            }
            $this->redirectToRoute('order_show', ['id' => $order->getId()]);
        }
    }

}
