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
        OrderRepository  $orderRepository,
        ClientRepository $clientRepository,
        TaskRepository   $taskRepository
    ): Response
    {
        $firstDayOfMonth = new \DateTime(date('Y-m-01 00:00:00'));
        $allRealisedServices = $orderRepository->count();
        $thisMonthRealisedServices = $orderRepository->getOrdersBetweenDates($firstDayOfMonth, new \DateTime());

        $numOfClients = $clientRepository->count();
        $numOfNewClients = $clientRepository->newClientsBeetweenDates($firstDayOfMonth, new \DateTime());

        $numOfRealisedServicesBYMonth = $orderRepository->getCountByYearGroupByMonth(date('Y'));
        $valueOfRealisedServicesBYMonth = $orderRepository->getValueByYearGroupByMonth(date('Y'));

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
