<?php

namespace App\Controller;

use App\Entity\OrderAttachment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[Route('/app_order_attachment', name: 'app_order_attachment')]
final class OrderAttachmentController extends BaseController
{
    public function __construct(
        EntityManagerInterface $doctrine,
        ParameterBagInterface $parameterBag,
        RequestStack $requestStack,
        EntityManagerInterface $entityManager,
    ) {
        parent::__construct($doctrine, $parameterBag, $requestStack, $entityManager);
    }

    #[Route('/{id}', name: '_delete', methods: ['DELETE'])]
    public function delete(OrderAttachment $orderAttachment): JsonResponse
    {
        try {
            $this->denyAccessUnlessGranted('ROLE_USER');
        } catch (AccessDeniedException $e) {
            return new JsonResponse(['message' => 'Brak dostępu'], Response::HTTP_FORBIDDEN);
        }
        try {
            $this->entityManager->remove($orderAttachment);
            $this->entityManager->flush();
            return new JsonResponse(['message' => 'Załącznik usunięty']);
        } catch (\Exception $e) {
            return new JsonResponse(['message' => 'Nie udało się usunąć załącznika'],
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}