<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Task>
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function getTodayDueDateTasks()
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.dueDate >= :date')
            ->andWhere('t.dueDate < :dateTomorrow')
            ->setParameter(':date', new \DateTime('today'))
            ->setParameter(':dateTomorrow', new \DateTime('tomorrow'))
            ->getQuery()
            ->execute();
    }

    public function getTasksByDueDate(\DateTime $startDate, \DateTime $endDate)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.dueDate >= :startDate')
            ->andWhere('t.dueDate <= :endDate')
            ->setParameter(':startDate', $startDate)
            ->setParameter(':endDate', $endDate)
            ->getQuery()
            ->execute();
    }

    //    /**
    //     * @return Task[] Returns an array of Task objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Task
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
