<?php

namespace App\Controller;

use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StatusOrderController extends AbstractController
{
    #[Route('/status-check/order/{order}', name: 'app_status_order')]
    public function index(Order $order): Response
    {
        return $this->render('status_order/index.html.twig', [
            'order' => $order,
        ]);
    }
}
