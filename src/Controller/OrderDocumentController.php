<?php

namespace App\Controller;

use App\Entity\Document;
use App\Entity\Order;
use App\Enum\DocumentTypeEnum;
use App\Form\OrderEquipmentAcceptanceProtocolType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('order/document', name: 'app_order_document_')]
class OrderDocumentController extends BaseController
{
    #[Route('/equipment-acceptance-protocol/{order:id}', name: 'equipment_acceptance_protocol')]
    public function index(Order $order, Request $request): Response
    {
        $form = $this->createForm(OrderEquipmentAcceptanceProtocolType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $document = new Document();
            $document->setDocumentType(DocumentTypeEnum::PROTOCOL_OF_ACCEPTING_THE_ITEM_FOR_SERVICE);
            $document->setAssociatedOrder($order);
            $document->setDocumentData([
                'device_type' => $data['device_type'],
                'brand' => $data['brand'],
                'model' => $data['model'],
                'serial_number' => $data['serial_number'],
                'fault_description' => $data['fault_description'],
                'customer_name' => $data['customer_name'],
                'customer_phone' => $data['customer_phone'],
                'date_received' => $data['date_received'],
            ]);
            $this->doctrine->persist($document);
            $this->doctrine->flush();
            $this->addFlash('success', 'Protokół przyjęcia sprzętu został zapisany');
        }
        return $this->render('document/equipment_acceptance_protocol.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/equipment-return-protocol/{order:id}', name: 'equipment_return_protocol')]
    public function equipmentReturnProtocol(Order $order): Response
    {
        dump($order);
        return $this->render('document/equipment_acceptance_protocol.html.twig', [
            'order' => $order,
        ]);
    }
}
