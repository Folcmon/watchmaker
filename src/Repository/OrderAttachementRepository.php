<?php

namespace App\Repository;

use App\Entity\OrderAttachment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrderAttachment|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderAttachment|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderAttachment[]    findAll()
 * @method OrderAttachment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderAttachementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderAttachment::class);
    }

    // /**
    //  * @return ServiceAttachment[] Returns an array of ServiceAttachment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ServiceAttachement
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
