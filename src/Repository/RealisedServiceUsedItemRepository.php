<?php

namespace App\Repository;

use App\Entity\RealisedServiceUsedItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RealisedServiceUsedItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method RealisedServiceUsedItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method RealisedServiceUsedItem[]    findAll()
 * @method RealisedServiceUsedItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RealisedServiceUsedItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RealisedServiceUsedItem::class);
    }

    // /**
    //  * @return RealisedServiceUsedItem[] Returns an array of RealisedServiceUsedItem objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RealisedServiceUsedItem
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
