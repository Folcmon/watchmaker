<?php

namespace App\Controller;

use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderAcceptanceController extends AbstractController
{
    #[Route('/order/acceptance/{order}}', name: 'app_order_acceptance')]
    public function index(Order $order): Response
    {
        return $this->render('order_acceptance/index.html.twig', [
            'order' => $order,
        ]);
    }
}
