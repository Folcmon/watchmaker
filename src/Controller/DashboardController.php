<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use App\Repository\RealisedServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_USER")
 */
class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(RealisedServiceRepository $realisedServiceRepository, ClientRepository $clientRepository): Response
    {
        $firstDayOfMonth = date('d-m-Y', strtotime(date('Y-m-1')));
        $allRealisedServices = $realisedServiceRepository->count([]);
        $thisMonthRealisedServices = $realisedServiceRepository->createQueryBuilder('rs')
            ->andWhere('rs.createdAt >= :date')
            ->setParameter(':date',$firstDayOfMonth)
            ->getQuery()
            ->execute();
        $numOfClients = $clientRepository->count([]);
        $numOfNewClients = $clientRepository->createQueryBuilder('cr')
            ->andWhere('cr.createdAt >= :date')
            ->setParameter(':date',$firstDayOfMonth)
            ->getQuery()
            ->execute();
        return $this->render('dashboard/index.html.twig', [
            'allRealisedServices' => $allRealisedServices,
            'thisMonthRealisedServices' => $thisMonthRealisedServices,
            'numOfClients' => $numOfClients,
            'numOfNewClients' => $numOfNewClients
        ]);
    }
}
