<?php

namespace App\Controller;

use App\Entity\Document;
use App\Entity\Order;
use App\Enum\DocumentTypeEnum;
use App\Form\OrderEquipmentAcceptanceProtocolType;
use App\Form\OrderEquipmentReturnProtocolType;
use App\Repository\BrandRepository;
use App\Repository\ModelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('order/document', name: 'app_order_document_')]
class OrderDocumentController extends BaseController
{
    #[Route('/equipment-acceptance-protocol/{order:id}', name: 'equipment_acceptance_protocol')]
    public function index(
        Order           $order,
        BrandRepository $brandRepository,
        ModelRepository $modelRepository,
        Request         $request
    ): Response
    {
        $form = $this->createForm(OrderEquipmentAcceptanceProtocolType::class);
        $form->get('customer_name')->setData($order->getClient()->getName());
        $form->get('customer_phone')->setData($order->getClient()->getTelephone());
        $form->get('date_received')->setData(new \DateTime());
        $form->get('fault_description')->setData($order->getDescription());
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
            'brands' => $brandRepository->findAll(),
            'models' => $modelRepository->findAll(),
        ]);
    }

    #[Route('/equipment-return-protocol/{order:id}', name: 'equipment_return_protocol')]
    public function equipmentReturnProtocol(
        Order           $order,
        BrandRepository $brandRepository,
        ModelRepository $modelRepository,
        Request         $request
    ): Response
    {
        $form = $this->createForm(OrderEquipmentReturnProtocolType::class);
        $form->get('customer_name')->setData($order->getClient()->getName());
        $form->get('customer_phone')->setData($order->getClient()->getTelephone());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $document = new Document();
            $document->setDocumentType(DocumentTypeEnum::PROTOCOL_OF_ISSUING_THE_ITEM_AFTER_SERVICE);
            $document->setAssociatedOrder($order);
            $document->setDocumentData([
                'customer_name' => $data['customer_name'],
                'customer_address' => $data['customer_address'],
                'customer_phone' => $data['customer_phone'],
                'device_type' => $data['device_type'],
                'brand_model' => $data['brand_model'],
                'serial_number' => $data['serial_number'],
                'accessories' => $data['accessories'],
                'service_description' => $data['service_description'],
                'equipment_condition' => $data['equipment_condition'],
                'remarks' => $data['remarks'],
                'date_returned' => $data['date_returned'],
                'customer_signature' => $data['customer_signature'],
                'service_provider_signature' => $data['service_provider_signature'],
            ]);
            $this->doctrine->persist($document);
            $this->doctrine->flush();
            $this->addFlash('success', 'Protokół odbioru sprzętu został zapisany');
        }

        return $this->render('document/equipment_return_protocol.html.twig', [
            'order' => $order,
            'brands' => $brandRepository->findAll(),
            'models' => $modelRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }
}
