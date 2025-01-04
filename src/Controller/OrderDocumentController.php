<?php

namespace App\Controller;

use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('order/document', name: 'app_order_document_')]
class OrderDocumentController extends AbstractController
{
    #[Route('/acceptance/{order:id}', name: 'acceptance')]
    public function index(Order $order): Response
    {
        dd($order);
        return $this->render('order_acceptance/index.html.twig', [
            'order' => $order,
        ]);
    }
}
