<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use App\Repository\OrderRepository;
use App\Repository\TaskRepository;
use Doctrine\DBAL\Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class DashboardController extends BaseController
{
    /**
     * @throws Exception
     */
    #[Route('/dashboard', name: 'dashboard')]
    public function index(
        OrderRepository $realisedServiceRepository,
        ClientRepository $clientRepository,
        TaskRepository $taskRepository
    ): Response {
        $time = strtotime(date('Y-m-01 00:00:00')); // == 1338534000
        $firstDayOfMonth = date('Y-m-d H:i:s', $time); // == 2012-06-01 00:00:00
        $allRealisedServices = $realisedServiceRepository->count();
        $thisMonthRealisedServices = $realisedServiceRepository->createQueryBuilder('rs')
            ->andWhere('rs.createdAt >= :date')
            ->setParameter(':date', $firstDayOfMonth)
            ->getQuery()
            ->execute();
        $numOfClients = $clientRepository->count();
        $numOfNewClients = $clientRepository->createQueryBuilder('cr')
            ->andWhere('cr.createdAt >= :date')
            ->setParameter(':date', $firstDayOfMonth)
            ->getQuery()
            ->execute();
        $numOfRealisedServicesBYMonth = $realisedServiceRepository->getCountByYearGroupByMonth(date('Y'));
        $valueOfRealisedServicesBYMonth = $realisedServiceRepository->getValueByYearGroupByMonth(date('Y'));
        $todayDueDateTasks = $taskRepository->getTodayDueDateTasks();
        return $this->render('dashboard/index.html.twig', [
            'allRealisedServices' => $allRealisedServices,
            'thisMonthRealisedServices' => $thisMonthRealisedServices,
            'numOfClients' => $numOfClients,
            'numOfNewClients' => $numOfNewClients,
            'numOfRealisedServicesBYMonth' => json_encode($numOfRealisedServicesBYMonth),
            'valueOfRealisedServicesBYMonth' => json_encode($valueOfRealisedServicesBYMonth),
            'todayDueDateTasks' => $todayDueDateTasks,
        ]);
    }
}
